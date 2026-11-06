/**
 * Manu Hosting - API Client
 * Handles all API communication with CSRF protection, interceptors, and error handling
 */

class ApiClient {
    constructor(options = {}) {
        this.baseUrl = options.baseUrl || '/api/v1';
        this.defaultHeaders = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        };
        this.csrfToken = null;
        this.interceptors = {
            request: [],
            response: [],
            error: [],
        };
        this.refreshingToken = false;
        this.failedRequests = [];
    }

    setCsrfToken(token) {
        this.csrfToken = token;
    }

    getCsrfToken() {
        return this.csrfToken;
    }

    // CSRF token from meta tag
    initCsrfFromMeta() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        if (meta) {
            this.setCsrfToken(meta.getAttribute('content'));
        }
    }

    // Add request interceptor
    onRequest(fn) {
        this.interceptors.request.push(fn);
    }

    // Add response interceptor
    onResponse(fn) {
        this.interceptors.response.push(fn);
    }

    // Add error interceptor
    onError(fn) {
        this.interceptors.error.push(fn);
    }

    // Build headers
    _buildHeaders(customHeaders = {}) {
        const headers = { ...this.defaultHeaders };
        
        if (this.csrfToken) {
            headers['X-CSRF-Token'] = this.csrfToken;
        }

        return { ...headers, ...customHeaders };
    }

    // Run request interceptors
    async _runRequestInterceptors(config) {
        for (const interceptor of this.interceptors.request) {
            config = await interceptor(config) || config;
        }
        return config;
    }

    // Run response interceptors
    async _runResponseInterceptors(response) {
        for (const interceptor of this.interceptors.response) {
            response = await interceptor(response) || response;
        }
        return response;
    }

    // Run error interceptors
    async _runErrorInterceptors(error) {
        for (const interceptor of this.interceptors.error) {
            error = await interceptor(error) || error;
        }
        throw error;
    }

    // Core request method
    async request(method, url, data = null, options = {}) {
        const fullUrl = url.startsWith('http') ? url : `${this.baseUrl}${url}`;
        
        const config = {
            method: method.toUpperCase(),
            headers: this._buildHeaders(options.headers),
            credentials: 'same-origin',
        };

        if (data && method.toUpperCase() !== 'GET') {
            config.body = JSON.stringify(data);
        } else if (data && method.toUpperCase() === 'GET') {
            const params = new URLSearchParams(data);
            const separator = fullUrl.includes('?') ? '&' : '?';
            config.url = `${fullUrl}${separator}${params}`;
        }

        // Run request interceptors
        const finalConfig = await this._runRequestInterceptors(config);

        try {
            const response = await fetch(finalConfig.url || fullUrl, finalConfig);
            
            // Handle 419 CSRF token mismatch
            if (response.status === 419) {
                // Try to refresh CSRF token
                const newToken = await this.refreshCsrfToken();
                if (newToken) {
                    finalConfig.headers['X-CSRF-Token'] = newToken;
                    return this.request(method, url, data, options);
                }
            }

            // Handle 401 unauthorized
            if (response.status === 401) {
                // Redirect to login if not already there
                if (!window.location.pathname.includes('/login')) {
                    window.location.href = '/login?redirect=' + encodeURIComponent(window.location.pathname);
                    return;
                }
            }

            const contentType = response.headers.get('Content-Type');
            const isJson = contentType && contentType.includes('application/json');
            const responseData = isJson ? await response.json() : await response.text();

            if (!response.ok) {
                const error = new ApiError(
                    responseData?.message || responseData?.error || `HTTP ${response.status}`,
                    response.status,
                    responseData
                );
                throw error;
            }

            // Run response interceptors
            const finalResponse = await this._runResponseInterceptors({
                data: responseData,
                status: response.status,
                headers: response.headers,
            });

            return finalResponse.data;

        } catch (error) {
            if (error instanceof ApiError) {
                throw error;
            }
            // Network or other errors
            const apiError = new ApiError(
                error.message || 'Netzwerkfehler',
                0,
                { originalError: error.message }
            );
            throw apiError;
        }
    }

    // Refresh CSRF token
    async refreshCsrfToken() {
        try {
            const response = await fetch('/api/v1/csrf-token', {
                method: 'GET',
                credentials: 'same-origin',
            });
            const data = await response.json();
            if (data.token) {
                this.setCsrfToken(data.token);
                // Update meta tag
                const meta = document.querySelector('meta[name="csrf-token"]');
                if (meta) {
                    meta.setAttribute('content', data.token);
                }
                return data.token;
            }
        } catch (e) {
            console.error('Failed to refresh CSRF token:', e);
        }
        return null;
    }

    // Convenience methods
    get(url, params = null, options = {}) {
        return this.request('GET', url, params, options);
    }

    post(url, data = null, options = {}) {
        return this.request('POST', url, data, options);
    }

    put(url, data = null, options = {}) {
        return this.request('PUT', url, data, options);
    }

    patch(url, data = null, options = {}) {
        return this.request('PATCH', url, data, options);
    }

    delete(url, data = null, options = {}) {
        return this.request('DELETE', url, data, options);
    }
}

class ApiError extends Error {
    constructor(message, status, data) {
        super(message);
        this.name = 'ApiError';
        this.status = status;
        this.data = data;
    }
}

// Create global instance
const api = new ApiClient();

// Initialize CSRF from meta tag on load
document.addEventListener('DOMContentLoaded', () => {
    api.initCsrfFromMeta();
});

// Export for modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { ApiClient, ApiError, api };
}
