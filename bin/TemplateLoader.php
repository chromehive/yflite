<?php
/**
 * YFlite Template Loader
 * Loads and processes template stub files
 */

class TemplateLoader {
    private static $templateDir;
    
    /**
     * Set template directory
     */
    public static function setTemplateDir($dir) {
        self::$templateDir = rtrim($dir, '/');
    }
    
    /**
     * Get template directory
     */
    public static function getTemplateDir() {
        if (!self::$templateDir) {
            self::$templateDir = __DIR__ . '/templates';
        }
        return self::$templateDir;
    }
    
    /**
     * Load a template file
     * @param string $templateName Template filename (e.g., 'page.php.stub')
     * @return string Template content
     * @throws Exception if template not found
     */
    public static function load($templateName) {
        $templatePath = self::getTemplateDir() . '/' . $templateName;
        
        if (!file_exists($templatePath)) {
            throw new Exception("Template not found: $templatePath");
        }
        
        return file_get_contents($templatePath);
    }
    
    /**
     * Replace placeholders in template
     * @param string $template Template content
     * @param array $variables Associative array of variable => value
     * @return string Processed template
     */
    public static function replace($template, $variables) {
        foreach ($variables as $key => $value) {
            // Replace {{variable}} placeholders
            $template = str_replace('{{' . $key . '}}', $value, $template);
            // Replace {{variable|ucfirst}} type modifiers
            $template = preg_replace_callback('/\{\{' . preg_quote($key, '/') . '\|([a-zA-Z_]+)\}\}/', function($matches) use ($value) {
                $modifier = $matches[1];
                switch ($modifier) {
                    case 'ucfirst':
                        return ucfirst($value);
                    case 'lower':
                        return strtolower($value);
                    case 'upper':
                        return strtoupper($value);
                    default:
                        return $value;
                }
            }, $template);
        }
        return $template;
    }
    
    /**
     * Load and process a template with variables
     * @param string $templateName Template filename
     * @param array $variables Variables to replace
     * @return string Processed template
     */
    public static function render($templateName, $variables = []) {
        $template = self::load($templateName);
        return self::replace($template, $variables);
    }
}

