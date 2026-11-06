<?php

namespace App\Validation;

class Validator
{
    private array $data = [];
    private array $rules = [];
    private array $messages = [];
    private array $errors = [];
    private array $attributes = [];
    private array $customAttributes = [];

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public static function make(array $data, array $rules, array $messages = [], array $customAttributes = []): self
    {
        $validator = new self($data);
        $validator->rules = $rules;
        $validator->messages = $messages;
        $validator->customAttributes = $customAttributes;
        return $validator;
    }

    public function validate(): bool
    {
        $this->errors = [];

        foreach ($this->rules as $field => $rules) {
            $ruleList = is_array($rules) ? $rules : explode('|', $rules);
            $value = $this->getValue($field);

            foreach ($ruleList as $rule) {
                [$ruleName, $parameters] = $this->parseRule($rule);
                
                if (!$this->applyRule($field, $value, $ruleName, $parameters)) {
                    $this->addError($field, $ruleName, $parameters);
                    break; // Stop on first error for this field
                }
            }
        }

        return empty($this->errors);
    }

    public function validateOrFail(): void
    {
        if (!$this->validate()) {
            throw new ValidationException($this->errors());
        }
    }

    private function getValue(string $field): mixed
    {
        $keys = explode('.', $field);
        $value = $this->data;

        foreach ($keys as $key) {
            if (is_array($value) && array_key_exists($key, $value)) {
                $value = $value[$key];
            } else {
                return null;
            }
        }

        return $value;
    }

    private function parseRule(string $rule): array
    {
        if (str_contains($rule, ':')) {
            [$name, $params] = explode(':', $rule, 2);
            $parameters = explode(',', $params);
            return [$name, $parameters];
        }
        return [$rule, []];
    }

    private function applyRule(string $field, mixed $value, string $rule, array $parameters): bool
    {
        $method = 'validate' . ucfirst($rule);

        if (method_exists($this, $method)) {
            return $this->$method($field, $value, $parameters);
        }

        // Unknown rule - treat as pass
        return true;
    }

    private function addError(string $field, string $rule, array $parameters): void
    {
        $message = $this->getMessage($field, $rule);
        $attribute = $this->getAttribute($field);

        $replacements = [
            ':attribute' => $attribute,
            ':field' => $field,
        ];

        foreach ($parameters as $i => $param) {
            $replacements[":param{$i}"] = $param;
        }

        $message = strtr($message, $replacements);

        $this->errors[$field][] = $message;
    }

    private function getMessage(string $field, string $rule): string
    {
        // Check custom messages
        $key = "{$field}.{$rule}";
        if (isset($this->messages[$key])) {
            return $this->messages[$key];
        }

        // Check generic field messages
        if (isset($this->messages[$field])) {
            return $this->messages[$field];
        }

        // Default messages
        $defaults = [
            'required' => 'Das Feld :attribute ist erforderlich.',
            'email' => 'Das Feld :attribute muss eine gültige E-Mail-Adresse sein.',
            'min' => 'Das Feld :attribute muss mindestens :param0 Zeichen haben.',
            'max' => 'Das Feld :attribute darf maximal :param0 Zeichen haben.',
            'between' => 'Das Feld :attribute muss zwischen :param0 und :param1 Zeichen haben.',
            'numeric' => 'Das Feld :attribute muss eine Zahl sein.',
            'integer' => 'Das Feld :attribute muss eine ganze Zahl sein.',
            'string' => 'Das Feld :attribute muss ein Text sein.',
            'array' => 'Das Feld :attribute muss ein Array sein.',
            'boolean' => 'Das Feld :attribute muss true oder false sein.',
            'confirmed' => 'Die Bestätigung für :attribute stimmt nicht überein.',
            'unique' => 'Der Wert für :attribute ist bereits vergeben.',
            'exists' => 'Der Wert für :attribute ist ungültig.',
            'in' => 'Das Feld :attribute hat einen ungültigen Wert.',
            'not_in' => 'Das Feld :attribute hat einen ungültigen Wert.',
            'regex' => 'Das Feld :attribute hat ein ungültiges Format.',
            'url' => 'Das Feld :attribute muss eine gültige URL sein.',
            'ip' => 'Das Feld :attribute muss eine gültige IP-Adresse sein.',
            'date' => 'Das Feld :attribute muss ein gültiges Datum sein.',
            'after' => 'Das Feld :attribute muss nach :param0 liegen.',
            'before' => 'Das Feld :attribute muss vor :param0 liegen.',
            'alpha' => 'Das Feld :attribute darf nur Buchstaben enthalten.',
            'alpha_num' => 'Das Feld :attribute darf nur Buchstaben und Zahlen enthalten.',
            'alpha_dash' => 'Das Feld :attribute darf nur Buchstaben, Zahlen, Bindestriche und Unterstriche enthalten.',
            'uuid' => 'Das Feld :attribute muss eine gültige UUID sein.',
            'json' => 'Das Feld :attribute muss ein gültiges JSON sein.',
            'file' => 'Das Feld :attribute muss eine Datei sein.',
            'image' => 'Das Feld :attribute muss ein Bild sein.',
            'mimes' => 'Das Feld :attribute muss einen der Typen :param0 haben.',
            'size' => 'Die Datei :attribute muss :param0 KB groß sein.',
            'password' => 'Das Passwort entspricht nicht den Anforderungen.',
        ];

        return $defaults[$rule] ?? "Das Feld :attribute ist ungültig (Regel: {$rule}).";
    }

    private function getAttribute(string $field): string
    {
        return $this->customAttributes[$field] ?? $this->attributes[$field] ?? ucfirst(str_replace('_', ' ', $field));
    }

    public function setAttribute(string $field, string $attribute): void
    {
        $this->attributes[$field] = $attribute;
    }

    public function setCustomAttributes(array $attributes): void
    {
        $this->customAttributes = $attributes;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function firstError(string $field): ?string
    {
        return $this->errors[$field][0] ?? null;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function getErrorBag(): \Illuminate\Support\MessageBag
    {
        // Simple implementation without Laravel dependency
        return new class($this->errors) {
            private array $errors;
            public function __construct(array $errors) { $this->errors = $errors; }
            public function all(): array { return array_merge(...array_values($this->errors)); }
            public function first(string $key): ?string { return $this->errors[$key][0] ?? null; }
            public function get(string $key): array { return $this->errors[$key] ?? []; }
            public function has(string $key): bool { return isset($this->errors[$key]); }
        };
    }

    // Validation Rules

    protected function validateRequired(string $field, mixed $value, array $params): bool
    {
        if (is_null($value)) return false;
        if (is_string($value) && trim($value) === '') return false;
        if (is_array($value) && empty($value)) return false;
        return true;
    }

    protected function validateEmail(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true; // Optional field
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    protected function validateMin(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        $min = (int)($params[0] ?? 0);
        if (is_string($value)) return mb_strlen($value) >= $min;
        if (is_array($value)) return count($value) >= $min;
        if (is_numeric($value)) return $value >= $min;
        return true;
    }

    protected function validateMax(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        $max = (int)($params[0] ?? PHP_INT_MAX);
        if (is_string($value)) return mb_strlen($value) <= $max;
        if (is_array($value)) return count($value) <= $max;
        if (is_numeric($value)) return $value <= $max;
        return true;
    }

    protected function validateBetween(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        $min = (int)($params[0] ?? 0);
        $max = (int)($params[1] ?? PHP_INT_MAX);
        if (is_string($value)) {
            $len = mb_strlen($value);
            return $len >= $min && $len <= $max;
        }
        if (is_array($value)) {
            $count = count($value);
            return $count >= $min && $count <= $max;
        }
        if (is_numeric($value)) {
            return $value >= $min && $value <= $max;
        }
        return true;
    }

    protected function validateNumeric(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        return is_numeric($value);
    }

    protected function validateInteger(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    protected function validateString(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        return is_string($value);
    }

    protected function validateArray(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        return is_array($value);
    }

    protected function validateBoolean(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        return is_bool($value) || in_array($value, [0, 1, '0', '1', 'true', 'false'], true);
    }

    protected function validateConfirmed(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        $confirmField = $field . '_confirmation';
        $confirmValue = $this->getValue($confirmField);
        return $value === $confirmValue;
    }

    protected function validateUnique(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        // Requires database - placeholder for now
        // Format: unique:table,column,exceptId,idColumn
        return true;
    }

    protected function validateExists(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        // Requires database - placeholder for now
        return true;
    }

    protected function validateIn(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        return in_array($value, $params, true);
    }

    protected function validateNotIn(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        return !in_array($value, $params, true);
    }

    protected function validateRegex(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        if (!is_string($value)) return false;
        $pattern = $params[0] ?? '';
        return preg_match($pattern, $value) === 1;
    }

    protected function validateUrl(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }

    protected function validateIp(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        return filter_var($value, FILTER_VALIDATE_IP) !== false;
    }

    protected function validateDate(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        if (!is_string($value)) return false;
        $format = $params[0] ?? 'Y-m-d';
        $date = \DateTime::createFromFormat($format, $value);
        return $date !== false && $date->format($format) === $value;
    }

    protected function validateAfter(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        if (!is_string($value)) return false;
        $after = $params[0] ?? date('Y-m-d');
        $date = strtotime($value);
        $afterTime = strtotime($after);
        return $date > $afterTime;
    }

    protected function validateBefore(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        if (!is_string($value)) return false;
        $before = $params[0] ?? date('Y-m-d');
        $date = strtotime($value);
        $beforeTime = strtotime($before);
        return $date < $beforeTime;
    }

    protected function validateAlpha(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        return ctype_alpha(str_replace(' ', '', $value));
    }

    protected function validateAlphaNum(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        return ctype_alnum(str_replace(' ', '', $value));
    }

    protected function validateAlphaDash(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        return preg_match('/^[a-zA-Z0-9_-]+$/', $value) === 1;
    }

    protected function validateUuid(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $value) === 1;
    }

    protected function validateJson(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        if (!is_string($value)) return false;
        json_decode($value);
        return json_last_error() === JSON_ERROR_NONE;
    }

    protected function validatePassword(string $field, mixed $value, array $params): bool
    {
        if ($value === null || $value === '') return true;
        if (!is_string($value)) return false;
        
        // Default password requirements
        $minLength = 12;
        $requireUpper = true;
        $requireLower = true;
        $requireNumber = true;
        $requireSymbol = true;

        if (mb_strlen($value) < $minLength) return false;
        if ($requireUpper && !preg_match('/[A-Z]/', $value)) return false;
        if ($requireLower && !preg_match('/[a-z]/', $value)) return false;
        if ($requireNumber && !preg_match('/[0-9]/', $value)) return false;
        if ($requireSymbol && !preg_match('/[^A-Za-z0-9]/', $value)) return false;

        return true;
    }
}

class ValidationException extends \Exception
{
    private array $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;
        parent::__construct('Validation failed', 422);
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
