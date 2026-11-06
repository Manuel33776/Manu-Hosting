/**
 * Manu Hosting - Main Application
 * Event Bus, Toast, Modal, Forms, Tables, Seasonal Particles
 */

// ============================================
// Event Bus
// ============================================
class EventBus {
    constructor() {
        this.events = new Map();
    }

    on(event, callback) {
        if (!this.events.has(event)) {
            this.events.set(event, []);
        }
        this.events.get(event).push(callback);
        return () => this.off(event, callback);
    }

    off(event, callback) {
        if (!this.events.has(event)) return;
        const callbacks = this.events.get(event);
        const index = callbacks.indexOf(callback);
        if (index > -1) callbacks.splice(index, 1);
    }

    emit(event, data) {
        if (!this.events.has(event)) return;
        this.events.get(event).forEach(cb => {
            try { cb(data); } catch (e) { console.error(e); }
        });
    }

    once(event, callback) {
        const wrapper = (data) => {
            callback(data);
            this.off(event, wrapper);
        };
        this.on(event, wrapper);
    }
}

const eventBus = new EventBus();

// ============================================
// Toast System
// ============================================
class ToastManager {
    constructor() {
        this.container = null;
        this.init();
    }

    init() {
        if (document.getElementById('toast-container')) return;
        this.container = document.createElement('div');
        this.container.id = 'toast-container';
        this.container.className = 'toast-container';
        document.body.appendChild(this.container);
    }

    show(message, type = 'info', title = '', duration = 5000) {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                ${title ? `<div class="toast-title">${this.escapeHtml(title)}</div>` : ''}
                <div class="toast-message">${this.escapeHtml(message)}</div>
            </div>
            <button class="toast-close" aria-label="Schließen">&times;</button>
        `;

        const closeBtn = toast.querySelector('.toast-close');
        closeBtn.addEventListener('click', () => this.remove(toast));

        this.container.appendChild(toast);

        // Auto remove
        setTimeout(() => this.remove(toast), duration);

        return toast;
    }

    remove(toast) {
        if (!toast.parentNode) return;
        toast.style.animation = 'slideInRight 0.3s ease reverse';
        setTimeout(() => toast.remove(), 300);
    }

    success(message, title = '', duration) { return this.show(message, 'success', title, duration); }
    error(message, title = '', duration) { return this.show(message, 'error', title, duration); }
    warning(message, title = '', duration) { return this.show(message, 'warning', title, duration); }
    info(message, title = '', duration) { return this.show(message, 'info', title, duration); }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

const toast = new ToastManager();

// ============================================
// Modal System
// ============================================
class ModalManager {
    constructor() {
        this.modals = new Map();
        this.activeModal = null;
        this.init();
    }

    init() {
        // Handle escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.activeModal) {
                this.close(this.activeModal);
            }
        });
    }

    register(id, element) {
        this.modals.set(id, element);
        element.addEventListener('click', (e) => {
            if (e.target === element) this.close(id);
        });
    }

    open(id) {
        const modal = this.modals.get(id) || document.getElementById(id);
        if (!modal) return;

        this.activeModal = id;
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
        modal.focus();
        eventBus.emit('modal:open', { id, modal });
    }

    close(id) {
        const modal = this.modals.get(id) || document.getElementById(id);
        if (!modal) return;

        modal.classList.remove('active');
        this.activeModal = null;
        document.body.style.overflow = '';
        eventBus.emit('modal:close', { id, modal });
    }

    closeAll() {
        this.modals.forEach((_, id) => this.close(id));
    }
}

const modal = new ModalManager();

// ============================================
// Form Handling
// ============================================
class FormHandler {
    static init(form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const submitBtn = form.querySelector('[type="submit"]');
            const originalText = submitBtn?.textContent;
            
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="animate-spin">⏳</span> Verarbeite...';
            }

            // Clear previous errors
            form.querySelectorAll('.form-error').forEach(el => el.remove());
            form.querySelectorAll('.form-input.error').forEach(el => el.classList.remove('error'));

            const formData = new FormData(form);
            const data = Object.fromEntries(formData);

            try {
                const action = form.action || window.location.pathname;
                const method = form.method || 'POST';
                
                const response = await fetch(action, {
                    method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': api.getCsrfToken() || '',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify(data),
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new ApiError(result.message || 'Fehler', response.status, result);
                }

                toast.success(result.message || 'Erfolgreich gespeichert');
                eventBus.emit('form:success', { form, result });

                if (result.redirect) {
                    setTimeout(() => window.location.href = result.redirect, 1000);
                }

            } catch (error) {
                if (error.status === 422 && error.data?.errors) {
                    FormHandler.showErrors(form, error.data.errors);
                }
                toast.error(error.message || 'Ein Fehler ist aufgetreten');
                eventBus.emit('form:error', { form, error });
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            }
        });

        // Real-time validation clearing
        form.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('input', () => {
                input.classList.remove('error');
                const errorEl = input.parentNode.querySelector('.form-error');
                if (errorEl) errorEl.remove();
            });
        });
    }

    static showErrors(form, errors) {
        Object.entries(errors).forEach(([field, messages]) => {
            const input = form.querySelector(`[name="${field}"]`);
            if (input) {
                input.classList.add('error');
                const errorDiv = document.createElement('div');
                errorDiv.className = 'form-error';
                errorDiv.textContent = Array.isArray(messages) ? messages[0] : messages;
                input.parentNode.appendChild(errorDiv);
            }
        });
    }
}

// Initialize forms on DOMContentLoaded
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form[data-ajax]').forEach(form => FormHandler.init(form));
});

// ============================================
// Table Enhancements
// ============================================
class TableEnhancer {
    static init(table) {
        // Sortable columns
        table.querySelectorAll('th[data-sort]').forEach(th => {
            th.style.cursor = 'pointer';
            th.addEventListener('click', () => TableEnhancer.sort(table, th));
        });

        // Row selection
        const selectAll = table.querySelector('thead input[type="checkbox"]');
        if (selectAll) {
            selectAll.addEventListener('change', () => {
                table.querySelectorAll('tbody input[type="checkbox"]').forEach(cb => {
                    cb.checked = selectAll.checked;
                });
            });
        }

        // Expandable rows
        table.querySelectorAll('tbody tr[data-expand]').forEach(row => {
            row.style.cursor = 'pointer';
            row.addEventListener('click', (e) => {
                if (e.target.tagName === 'INPUT' || e.target.tagName === 'BUTTON' || e.target.tagName === 'A') return;
                row.classList.toggle('expanded');
            });
        });
    }

    static sort(table, th) {
        const column = th.dataset.sort;
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const isAsc = th.classList.contains('sort-asc');

        // Reset all headers
        table.querySelectorAll('th').forEach(h => h.classList.remove('sort-asc', 'sort-desc'));
        th.classList.add(isAsc ? 'sort-desc' : 'sort-asc');

        rows.sort((a, b) => {
            const aVal = a.querySelector(`[data-${column}]`)?.dataset[column] || a.cells[th.cellIndex]?.textContent || '';
            const bVal = b.querySelector(`[data-${column}]`)?.dataset[column] || b.cells[th.cellIndex]?.textContent || '';
            
            const comparison = aVal.localeCompare(bVal, undefined, { numeric: true });
            return isAsc ? -comparison : comparison;
        });

        rows.forEach(row => tbody.appendChild(row));
    }
}

// Initialize tables on DOMContentLoaded
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.table').forEach(table => TableEnhancer.init(table));
});

// ============================================
// Confirmation Dialogs
// ============================================
function confirmAction(message, options = {}) {
    return new Promise((resolve) => {
        const modal = document.createElement('div');
        modal.className = 'modal-overlay';
        modal.innerHTML = `
            <div class="modal">
                <div class="modal-header">
                    <h3 class="modal-title">${options.title || 'Bestätigen'}</h3>
                </div>
                <div class="modal-body">
                    <p>${message}</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-action="cancel">${options.cancelText || 'Abbrechen'}</button>
                    <button class="btn btn-${options.danger ? 'danger' : 'primary'}" data-action="confirm">${options.confirmText || 'Bestätigen'}</button>
                </div>
            </div>
        `;

        document.body.appendChild(modal);
        document.body.style.overflow = 'hidden';

        modal.querySelector('[data-action="cancel"]').addEventListener('click', () => {
            modal.remove();
            document.body.style.overflow = '';
            resolve(false);
        });

        modal.querySelector('[data-action="confirm"]').addEventListener('click', () => {
            modal.remove();
            document.body.style.overflow = '';
            resolve(true);
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.remove();
                document.body.style.overflow = '';
                resolve(false);
            }
        });
    });
}

// ============================================
// Loading States
// ============================================
function setLoading(element, loading = true) {
    if (loading) {
        element.dataset.originalContent = element.innerHTML;
        element.innerHTML = '<span class="animate-spin">⏳</span> Lädt...';
        element.disabled = true;
    } else {
        element.innerHTML = element.dataset.originalContent || element.innerHTML;
        element.disabled = false;
    }
}

// ============================================
// Date/Time Formatting
// ============================================
function formatDate(date, options = {}) {
    const d = new Date(date);
    return d.toLocaleDateString('de-DE', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        ...options,
    });
}

function formatDateTime(date, options = {}) {
    const d = new Date(date);
    return d.toLocaleString('de-DE', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        ...options,
    });
}

function formatDuration(seconds) {
    if (seconds < 60) return `${seconds}s`;
    const minutes = Math.floor(seconds / 60);
    if (minutes < 60) return `${minutes}m ${seconds % 60}s`;
    const hours = Math.floor(minutes / 60);
    if (hours < 24) return `${hours}h ${minutes % 60}m`;
    const days = Math.floor(hours / 24);
    return `${days}d ${hours % 24}h`;
}

function formatBytes(bytes) {
    if (bytes === 0) return '0 B';
    const k = 1024;
    const sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// ============================================
// Seasonal Particles (Background Animation)
// ============================================
class SeasonalParticles {
    constructor(canvas) {
        this.canvas = canvas;
        this.ctx = canvas.getContext('2d');
        this.particles = [];
        this.animationId = null;
        this.season = this.getCurrentSeason();
        this.colors = this.getSeasonColors();
        this.init();
    }

    getCurrentSeason() {
        const month = new Date().getMonth(); // 0-11
        if (month >= 2 && month <= 4) return 'spring';
        if (month >= 5 && month <= 7) return 'summer';
        if (month >= 8 && month <= 10) return 'autumn';
        return 'winter';
    }

    getSeasonColors() {
        const themes = {
            spring: ['#8B5CF6', '#A78BFA', '#C4B5FD', '#3B82F6', '#60A5FA'],
            summer: ['#F59E0B', '#FBBF24', '#FDE047', '#3B82F6', '#22D3EE'],
            autumn: ['#EF4444', '#F87171', '#F97316', '#FB923C', '#F59E0B'],
            winter: ['#3B82F6', '#60A5FA', '#93C5FD', '#8B5CF6', '#A78BFA'],
        };
        return themes[this.season] || themes.winter;
    }

    init() {
        this.resize();
        this.createParticles();
        this.animate();

        window.addEventListener('resize', () => this.resize());
    }

    resize() {
        this.canvas.width = window.innerWidth;
        this.canvas.height = window.innerHeight;
    }

    createParticles() {
        const count = Math.min(100, Math.floor((this.canvas.width * this.canvas.height) / 15000));
        this.particles = [];

        for (let i = 0; i < count; i++) {
            this.particles.push({
                x: Math.random() * this.canvas.width,
                y: Math.random() * this.canvas.height,
                size: Math.random() * 3 + 1,
                speedX: (Math.random() - 0.5) * 0.5,
                speedY: Math.random() * 0.5 + 0.2,
                opacity: Math.random() * 0.5 + 0.1,
                color: this.colors[Math.floor(Math.random() * this.colors.length)],
                rotation: Math.random() * Math.PI * 2,
                rotationSpeed: (Math.random() - 0.5) * 0.01,
            });
        }
    }

    animate() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

        this.particles.forEach(p => {
            p.x += p.speedX;
            p.y -= p.speedY;
            p.rotation += p.rotationSpeed;

            // Wrap around
            if (p.y < -10) {
                p.y = this.canvas.height + 10;
                p.x = Math.random() * this.canvas.width;
            }
            if (p.x < -10) p.x = this.canvas.width + 10;
            if (p.x > this.canvas.width + 10) p.x = -10;

            this.ctx.save();
            this.ctx.translate(p.x, p.y);
            this.ctx.rotate(p.rotation);
            this.ctx.globalAlpha = p.opacity;
            this.ctx.fillStyle = p.color;
            this.ctx.beginPath();
            this.ctx.moveTo(0, -p.size);
            this.ctx.lineTo(p.size * 0.866, p.size * 0.5);
            this.ctx.lineTo(-p.size * 0.866, p.size * 0.5);
            this.ctx.closePath();
            this.ctx.fill();
            this.ctx.restore();
        });

        this.animationId = requestAnimationFrame(() => this.animate());
    }

    destroy() {
        if (this.animationId) {
            cancelAnimationFrame(this.animationId);
        }
    }
}

// Initialize seasonal particles on hero sections
document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('seasonal-particles');
    if (canvas) {
        window.seasonalParticles = new SeasonalParticles(canvas);
    }
});

// ============================================
// Copy to Clipboard
// ============================================
async function copyToClipboard(text, successMessage = 'Kopiert!') {
    try {
        await navigator.clipboard.writeText(text);
        toast.success(successMessage);
        return true;
    } catch (e) {
        toast.error('Fehler beim Kopieren');
        return false;
    }
}

// ============================================
// Debounce
// ============================================
function debounce(fn, delay) {
    let timeoutId;
    return (...args) => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => fn(...args), delay);
    };
}

// ============================================
// Global Exports
// ============================================
window.ManuHosting = {
    eventBus,
    toast,
    modal,
    api,
    confirmAction,
    setLoading,
    formatDate,
    formatDateTime,
    formatDuration,
    formatBytes,
    copyToClipboard,
    debounce,
    FormHandler,
    TableEnhancer,
    SeasonalParticles,
};
