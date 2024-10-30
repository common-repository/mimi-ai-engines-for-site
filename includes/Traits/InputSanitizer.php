<?php

namespace VietDevelopers\MiMi\Traits;

/**
 * Trait: Input Sanitizer.
 *
 * It will sanitize any input value based on type.
 */
trait InputSanitizer
{

    /**
     * Sanitize settings request.
     *
     * @since 1.0.0
     *
     * @param mixed  $value
     * @param string $type
     *
     * @return mixed $sanitized value
     */
    public function sanitize($value, string $type)
    {
        $sanitized = '';

        switch ($type) {
            case 'text':
            case 'textarea':
                $sanitized = sanitize_text_field(wp_unslash($value));
                break;

            case 'number':
                $sanitized = absint(wp_unslash($value));
                break;

            case 'email':
                $sanitized = sanitize_email(wp_unslash($value));
                break;

            case 'switch':
                $sanitized = (bool) wp_unslash($value);
                break;

            case 'boolean':
                $sanitized = ($value === 1 || $value === '1') ? 1 : 0;
                break;

            case 'array_number':
                if (is_array($value)) {
                    $sanitized = array_map('absint', $value);
                } else {
                    $sanitized = array();
                }
                break;

            case 'array_text':
                if (is_array($value)) {
                    $sanitized = array_map('sanitize_text_field', $value);
                } else {
                    $sanitized = array();
                }
                break;

            case 'block':
                // Sanitize gutenberg block data.
                // We're not sanitizing it, now, when we're showing it,
                // We'll use gutenberg's own way for rendering blocks.
                $sanitized = $value;
                break;

            default:
                $sanitized = $value;
                break;
        }

        return $sanitized;
    }
}
