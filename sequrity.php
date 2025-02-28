<?php
class Security
{
    /**
     * Detect and sanitize input for potential SQL injection
     *
     * @param string $input The user input to validate
     * @return string|bool Sanitized input or false if malicious input is detected
     */
    public static function sanitizeInput($input)
    {
        // Patterns for detecting common SQL injection attempts
        $patterns = [
            '/select.*from/i',          // Detect SELECT statements
            '/union.*select/i',         // Detect UNION-based injections
            '/insert.*into/i',          // Detect INSERT statements
            '/update.*set/i',           // Detect UPDATE statements
            '/delete.*from/i',          // Detect DELETE statements
            '/drop.*table/i',           // Detect DROP TABLE statements
            '/--|;|#/',                 // Detect SQL comments or statement chaining
            '/\b(or|and)\b.*=/i',       // Detect logical operations
            '/\'\s*or\s*\'.*\'/',       // Detect 'OR' based bypass
        ];

        // Check if any malicious patterns are found
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $input)) {
                return false; // Malicious input detected
            }
        }

        // Sanitize input to remove potentially harmful characters
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Validate input type and length
     *
     * @param string $input The user input to validate
     * @param int $maxLength The maximum allowed length for the input
     * @return string|bool Sanitized input or false if invalid
     */
    public static function validateInput($input, $maxLength = 255)
    {
        // Check input length
        if (strlen($input) > $maxLength) {
            return false; // Input too long
        }

        // Check and sanitize input
        return self::sanitizeInput($input);
    }
}


?>
