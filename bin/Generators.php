<?php

/**
 * YFlite CLI Generators
 * Functions to generate controllers, models, views, and routes
 */

require_once __DIR__ . '/TemplateLoader.php';

// Determine project root (the directory where the user ran the command).
// getcwd() will usually return the consumer project's root when executed via vendor/bin wrapper.
$projectRoot = getcwd();
if ($projectRoot === false) {
    // Fallback to package location when running inside the package itself
    $projectRoot = dirname(__DIR__, 2);
}

/**
 * Create a new YFlite project structure
 */
function createProjectStructure(string $templateDir = null, string $newProjectDir = "")
{
    global $projectRoot;
    $dirNameChosen = "";

    if (!empty($newProjectDir)) {
        $dirNameChosen = $newProjectDir . '/';

        // Ensure the project directory exists
        if (!is_dir($dirNameChosen)) {
            mkdir($dirNameChosen, 0777, true);
            echo "📁  Project Directory created: " . str_replace($projectRoot . '/', '', $dirNameChosen) . "\n";
        }
    }

    // Create directories
    $directories = [
        'app/_core',
        'app/configs',
        'app/controllers',
        'app/helpers',
        'app/middlewares',
        'app/models',
        'app/routes',
        'app/views/components',
        'app/views/layouts',
        'app/views/pages',
        'public/assets/css',
        'public/assets/js',
        'storage/cache',
        'storage/logs',
        'tests',
        '.vscode',
    ];

    foreach ($directories as $dir) {
        if (!is_dir($dirNameChosen . $dir)) {
            mkdir($dirNameChosen . $dir, 0777, true);
            echo "📁 Created directory: {$dirNameChosen}{$dir}\n";
        }
    }

    // Creates from or copies template files (See If We Can Avoid Repeating This Files Block Without An Issue)
    $files = [
        '.env' => TemplateLoader::load('env.stub'),
        'path.php' => TemplateLoader::load('path.php.stub'),
        'README.md' => TemplateLoader::load('README.md.stub'),
        'app/_core/bootstrap.php' => TemplateLoader::load('core/bootstrap.php.stub'),
        'app/_core/config.php' => TemplateLoader::load('core/config.php.stub'),
        'app/_core/helper.php' => TemplateLoader::load('core/helper.php.stub'),
        'app/_core/route.php' => TemplateLoader::load('core/route.php.stub'),
        'app/_core/security.php' => TemplateLoader::load('core/security.php.stub'),
        'app/_core/yf.php' => TemplateLoader::load('core/yf.php.stub'),
        'app/_core/env.php' => TemplateLoader::load('core/env.php.stub'),
        'app/configs/index.php' => TemplateLoader::load('configs/index.php.stub'),
        'app/configs/route_aliases.php' => TemplateLoader::load('configs/route_aliases.php.stub'),
        'app/helpers/index.php' => TemplateLoader::load('helpers/index.php.stub'),
        'app/routes/index.php' => TemplateLoader::load('routes/index.php.stub'),
        'app/controllers/public.php' => TemplateLoader::render('controller_alt.php.stub', ['title' => 'Public', 'controllerName' => 'home']),
        'app/middlewares/auth.php' => TemplateLoader::load('auth.php.stub'),
        'app/views/layouts/main.php' => TemplateLoader::load('layouts/main.php.stub'),
        'app/views/layouts/dashboard.php' => TemplateLoader::load('layouts/dashboard.php.stub'),
        'app/views/components/head.php' => TemplateLoader::load('components/head.php.stub'),
        'app/views/components/header.php' => TemplateLoader::load('components/header.php.stub'),
        'app/views/components/foot.php' => TemplateLoader::load('components/foot.php.stub'),
        'app/views/components/footer.php' => TemplateLoader::load('components/footer.php.stub'),
        'app/views/pages/home.php' => TemplateLoader::render('home.php.stub', ['title' => 'Home', 'fileName' => 'home']),
        'app/views/pages/404.php' => TemplateLoader::render('404.php.stub', ['name' => '404']),
        'public/index.php' => TemplateLoader::load('public/index.php.stub'),
        'public/robots.txt' => TemplateLoader::load('public/robots.txt.stub'),
        'public/sitemap.txt' => TemplateLoader::load('public/sitemap.txt.stub'),
        'public/assets/js/debug.js' => TemplateLoader::load('public/debug.js.stub'),
        'public/assets/js/head-support.js' => TemplateLoader::load('public/head-support.js.stub'),
        'public/assets/js/htmx2.min.js' => TemplateLoader::load('public/htmx2.min.js.stub'),
        'public/assets/js/hyperscript.min.js' => TemplateLoader::load('public/hyperscript.min.js.stub'),
        'public/assets/js/yf-interpreter.js' => TemplateLoader::load('public/yf-interpreter.js.stub'),
        '.vscode/yflite.code-snippets' => TemplateLoader::load('vscode/yflite.code-snippets.stub'),
    ];

    foreach ($files as $path => $content) {
        if (!file_exists($dirNameChosen . $path)) {
            file_put_contents($dirNameChosen . $path, $content);
            echo "📄 Created file: {$dirNameChosen}{$path}\n";
        }
    }
}

/**
 * Write a file safely: if file exists prompt, backup if overwriting.
 */
function safeWriteFile(string $dest, string $contents): bool
{
    $destDir = dirname($dest);
    if (!is_dir($destDir) && !@mkdir($destDir, 0777, true) && !is_dir($destDir)) {
        echo "Error: Could not create directory: {$destDir}\n";
        return false;
    }

    if (!file_exists($dest)) {
        if (file_put_contents($dest, $contents) === false) {
            echo "Error: Failed to write {$dest}\n";
            return false;
        }
        echo "Created: {$dest}\n";
        return true;
    }

    // Prompt user for overwrite
    echo "File exists: {$dest}\nOverwrite? [y/N]: ";
    $answer = strtolower(trim(fgets(STDIN) ?: ''));
    if ($answer !== 'y') {
        echo "Skipped: {$dest}\n";
        return false;
    }

    // Create a timestamped backup
    $backup = $dest . '.bak.' . date('YmdHis');
    if (!@copy($dest, $backup)) {
        echo "Warning: could not create backup for {$dest}. Aborting write.\n";
        return false;
    }

    if (file_put_contents($dest, $contents) === false) {
        echo "Error: Failed to write {$dest}\n";
        return false;
    }

    echo "Overwrote: {$dest} (backup: {$backup})\n";
    return true;
}

/**
 * Create a new YFlite project structure (safe mode - prompts before overwriting)
 */
function createProjectStructureSafe(string $templateDir = null, string $newProjectDir = null)
{
    global $projectRoot;

    // Create directories
    $directories = [
        'app/_core',
        'app/configs',
        'app/controllers',
        'app/helpers',
        'app/middlewares',
        'app/models',
        'app/routes',
        'app/views/components',
        'app/views/layouts',
        'app/views/pages',
        'public/assets/css',
        'public/assets/js',
        'storage/cache',
        'storage/logs',
        'tests',
        '.vscode',
    ];

    foreach ($directories as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
            echo "📁 Created directory: {$dir}\n";
        }
    }

    // Files to create with their content (See If We Can Avoid Repeating This Files Block Without An Issue)
    $files = [
        '.env' => TemplateLoader::load('env.stub'),
        'path.php' => TemplateLoader::load('path.php.stub'),
        'README.md' => TemplateLoader::load('README.md.stub'),
        'app/_core/bootstrap.php' => TemplateLoader::load('core/bootstrap.php.stub'),
        'app/_core/config.php' => TemplateLoader::load('core/config.php.stub'),
        'app/_core/helper.php' => TemplateLoader::load('core/helper.php.stub'),
        'app/_core/route.php' => TemplateLoader::load('core/route.php.stub'),
        'app/_core/security.php' => TemplateLoader::load('core/security.php.stub'),
        'app/_core/yf.php' => TemplateLoader::load('core/yf.php.stub'),
        'app/_core/env.php' => TemplateLoader::load('core/env.php.stub'),
        'app/configs/index.php' => TemplateLoader::load('configs/index.php.stub'),
        'app/configs/route_aliases.php' => TemplateLoader::load('configs/route_aliases.php.stub'),
        'app/helpers/index.php' => TemplateLoader::load('helpers/index.php.stub'),
        'app/routes/index.php' => TemplateLoader::load('routes/index.php.stub'),
        'app/controllers/public.php' => TemplateLoader::render('controller_alt.php.stub', ['title' => 'Public', 'controllerName' => 'home']),
        'app/middlewares/auth.php' => TemplateLoader::load('auth.php.stub'),
        'app/views/layouts/main.php' => TemplateLoader::load('layouts/main.php.stub'),
        'app/views/layouts/dashboard.php' => TemplateLoader::load('layouts/dashboard.php.stub'),
        'app/views/components/head.php' => TemplateLoader::load('components/head.php.stub'),
        'app/views/components/header.php' => TemplateLoader::load('components/header.php.stub'),
        'app/views/components/foot.php' => TemplateLoader::load('components/foot.php.stub'),
        'app/views/components/footer.php' => TemplateLoader::load('components/footer.php.stub'),
        'app/views/pages/home.php' => TemplateLoader::render('home.php.stub', ['title' => 'Home', 'fileName' => 'home']),
        'app/views/pages/404.php' => TemplateLoader::render('404.php.stub', ['name' => '404']),
        'public/index.php' => TemplateLoader::load('public/index.php.stub'),
        'public/robots.txt' => TemplateLoader::load('public/robots.txt.stub'),
        'public/sitemap.txt' => TemplateLoader::load('public/sitemap.txt.stub'),
        'public/assets/js/debug.js' => TemplateLoader::load('public/debug.js.stub'),
        'public/assets/js/head-support.js' => TemplateLoader::load('public/head-support.js.stub'),
        'public/assets/js/htmx2.min.js' => TemplateLoader::load('public/htmx2.min.js.stub'),
        'public/assets/js/hyperscript.min.js' => TemplateLoader::load('public/hyperscript.min.js.stub'),
        'public/assets/js/yf-interpreter.js' => TemplateLoader::load('public/yf-interpreter.js.stub'),
        '.vscode/yflite.code-snippets' => TemplateLoader::load('vscode/yflite.code-snippets.stub'),
    ];

    foreach ($files as $path => $content) {
        safeWriteFile($path, $content);
    }
}

/**
 * Generate a single page
 */
function makePage($name)
{
    global $projectRoot;
    if (!$name) {
        echo "⚠️ Please provide a page name. Example: yflite make:page dashboard\n";
        return false;
    }

    $filePath = strtolower($name);
    $parts = explode('/', $filePath);
    $fileName = array_pop($parts);

    // Build the target directory under the consuming project (always ensure app/views/pages exists)
    $baseViewsDir = rtrim($projectRoot, '/\\') . '/app/views/pages';
    $subPath = implode('/', array_filter($parts, function ($p) {
        return $p !== '';
    }));
    $dirPath = $baseViewsDir . ($subPath !== '' ? '/' . $subPath : '');

    // Ensure the views (and any sub) directory exists
    if (!is_dir($dirPath)) {
        mkdir($dirPath, 0777, true);
        echo "📁  Directory created: " . str_replace($projectRoot . '/', '', $dirPath) . "\n";
    }

    $pagePath = rtrim($dirPath, '/\\') . '/' . $fileName . '.php';

    if (file_exists($pagePath)) {
        echo "⚠️ Page already exists: app/views/pages/" . str_replace($projectRoot . '/app/views/pages/', '', $pagePath) . "\n";
        return false;
    }

    $title = ucfirst(str_replace(['-', '_'], ' ', $fileName));

    $template = TemplateLoader::render('page.php.stub', [
        'title' => $title,
        'fileName' => $fileName
    ]);

    file_put_contents($pagePath, $template);
    echo "✅ Page created: app/views/pages/" . str_replace($projectRoot . '/app/views/pages/', '', $pagePath) . "\n";
    return true;
}

/**
 * Generate multiple pages
 */
function makePages($names)
{
    $successCount = 0;
    foreach ($names as $name) {
        if (makePage($name)) {
            $successCount++;
        }
    }
    return $successCount;
}

/**
 * Generate multiple controllers
 */
function makeController($name)
{
    global $projectRoot;
    if (!$name) {
        echo "⚠️ Please provide a controller name. Example: yflite make:controller products\n";
        return false;
    }

    // // Generate controller
    // $name = ucfirst(str_replace('Controller', '', $name));
    // $content = TemplateLoader::render('controller_alt.php.stub', ['title' => $name, 'controllerName' => $name]);
    // $controllerPath = $projectRoot . '/app/controllers/' . strtolower($name) . '.php';

    // if (!is_dir(dirname($controllerPath))) {
    //     mkdir(dirname($controllerPath), 0777, true);
    // }

    // if (file_exists($controllerPath)) {
    //     echo "⚠️ Error: Controller already exists: " . basename($controllerPath) . "\n";
    //     exit(1);
    // }

    // file_put_contents($controllerPath, $content);
    // echo "✅ Controller Created: app/controllers/" . basename($controllerPath) . "\n";
    // exit(0);

    $filePath = strtolower($name);
    $parts = explode('/', $filePath);
    $fileName = array_pop($parts);

    // Build the target directory under the consuming project (always ensure controllers exists)
    $controllerDir = rtrim($projectRoot, '/\\') . '/controllers';
    $subPath = implode('/', array_filter($parts, function ($p) {
        return $p !== '';
    }));
    $dirPath = $controllerDir . ($subPath !== '' ? '/' . $subPath : '');

    // Ensure the controllers (and any sub) directory exists
    if (!is_dir($dirPath)) {
        mkdir($dirPath, 0777, true);
        echo "📁 Directory created: " . str_replace($projectRoot . '/', '', $dirPath) . "\n";
    }

    $controllerPath = rtrim($dirPath, '/\\') . '/' . $fileName . '.php';

    if (file_exists($controllerPath)) {
        echo "⚠️ Controller already exists: app/controllers/" . str_replace($projectRoot . '/app/controllers/', '', $controllerPath) . "\n";
        return false;
    }

    $title = ucfirst(str_replace(['-', '_'], ' ', $fileName));

    $template = TemplateLoader::render('controller.php.stub', [
        'title' => $title,
        'resource' => $fileName
    ]);

    file_put_contents($controllerPath, $template);
    echo "✅ Controller created: app/controllers/" . str_replace($projectRoot . '/app/controllers/', '', $controllerPath) . "\n";
    return true;
}

/**
 * Generate multiple controllers
 */
function makeControllers($names)
{
    $successCount = 0;
    foreach ($names as $name) {
        if (makeController($name)) {
            $successCount++;
        }
    }
    return $successCount;
}

/**
 * Parse fields string into structured array
 * Example: "title:string,price:decimal:0.01|min=0,description:text"
 */
function parseFields($fieldsString)
{
    if (empty($fieldsString)) {
        return ['name' => ['type' => 'string']]; // Default field
    }

    $fields = [];
    $parts = explode(',', $fieldsString);

    foreach ($parts as $part) {
        $part = trim($part);
        if (empty($part)) continue;

        // Separate field definition from attributes (field:type:step|attr=value)
        $mainPart = $part;
        $attrs = [];

        if (strpos($part, '|') !== false) {
            $pipeParts = explode('|', $part);
            $mainPart = array_shift($pipeParts); // field:type:step
            foreach ($pipeParts as $attrPart) {
                if (strpos($attrPart, '=') !== false) {
                    list($key, $value) = explode('=', $attrPart, 2);
                    $attrs[trim($key)] = trim($value);
                }
            }
        }

        // Parse field definition: fieldName:type:step
        $mainParts = explode(':', $mainPart, 3);
        $fieldName = trim($mainParts[0]);
        $type = isset($mainParts[1]) ? strtolower(trim($mainParts[1])) : 'string';
        $step = isset($mainParts[2]) ? trim($mainParts[2]) : null;

        $fields[$fieldName] = ['type' => $type];
        if ($step !== null) {
            $fields[$fieldName]['step'] = $step;
        }
        $fields[$fieldName] = array_merge($fields[$fieldName], $attrs);
    }

    return $fields;
}

/**
 * Generate HTML form fields based on field definitions
 */
function generateFormFields($fields, $valuesVar = null)
{
    $html = '';

    foreach ($fields as $fieldName => $fieldDef) {
        $type = $fieldDef['type'] ?? 'string';
        $label = ucfirst(str_replace(['_', '-'], ' ', $fieldName));

        if ($valuesVar) {
            $valueExpr = '<?= htmlspecialchars(' . $valuesVar . '[\'' . $fieldName . '\'] ?? \'\') ?>';
        } else {
            $valueExpr = '';
        }

        $html .= "    <div class=\"mb-4\">\n";
        $html .= "        <label for=\"$fieldName\" class=\"block text-sm font-medium mb-2\">$label</label>\n";

        // Generate appropriate input based on type
        switch ($type) {
            case 'text':
            case 'textarea':
                $html .= "        <textarea name=\"$fieldName\" id=\"$fieldName\" class=\"w-full border rounded px-3 py-2\" rows=\"4\">" . $valueExpr . "</textarea>\n";
                break;

            case 'email':
                $required = isset($fieldDef['required']) ? 'required' : '';
                $html .= "        <input type=\"email\" name=\"$fieldName\" id=\"$fieldName\" value=\"" . $valueExpr . "\" class=\"w-full border rounded px-3 py-2\" $required>\n";
                break;

            case 'password':
                $minlength = isset($fieldDef['minlength']) ? "minlength=\"{$fieldDef['minlength']}\"" : '';
                $html .= "        <input type=\"password\" name=\"$fieldName\" id=\"$fieldName\" class=\"w-full border rounded px-3 py-2\" autocomplete=\"new-password\" $minlength>\n";
                break;

            case 'tel':
                $pattern = isset($fieldDef['pattern']) ? "pattern=\"{$fieldDef['pattern']}\"" : '';
                $placeholder = isset($fieldDef['placeholder']) ? "placeholder=\"{$fieldDef['placeholder']}\"" : '';
                $html .= "        <input type=\"tel\" name=\"$fieldName\" id=\"$fieldName\" value=\"" . $valueExpr . "\" class=\"w-full border rounded px-3 py-2\" $pattern $placeholder>\n";
                break;

            case 'number':
            case 'int':
            case 'integer':
                $min = $fieldDef['min'] ?? '0';
                $step = $fieldDef['step'] ?? '1';
                $max = isset($fieldDef['max']) ? "max=\"{$fieldDef['max']}\"" : '';
                $html .= "        <input type=\"number\" name=\"$fieldName\" id=\"$fieldName\" value=\"" . $valueExpr . "\" class=\"w-full border rounded px-3 py-2\" min=\"$min\" step=\"$step\" $max>\n";
                break;

            case 'decimal':
            case 'float':
            case 'double':
                $min = $fieldDef['min'] ?? '0';
                $step = $fieldDef['step'] ?? '0.01';
                $max = isset($fieldDef['max']) ? "max=\"{$fieldDef['max']}\"" : '';
                $html .= "        <input type=\"number\" name=\"$fieldName\" id=\"$fieldName\" value=\"" . $valueExpr . "\" class=\"w-full border rounded px-3 py-2\" min=\"$min\" step=\"$step\" $max>\n";
                break;

            case 'image':
                $html .= "        ";
                if ($valuesVar) {
                    $varRef = $valuesVar;
                    $html .= "<?php if (!empty(" . $varRef . "['$fieldName'])): ?>\n";
                    $html .= "            <div class=\"mb-2\">\n";
                    $html .= "                <img src=\"<?= htmlspecialchars(" . $varRef . "['$fieldName']) ?>\" alt=\"$label\" class=\"max-h-32 rounded\">\n";
                    $html .= "            </div>\n";
                    $html .= "        <?php endif; ?>\n        ";
                }
                $html .= "<input type=\"file\" name=\"$fieldName\" id=\"$fieldName\" accept=\"image/*\" class=\"w-full border rounded px-3 py-2\">\n";
                break;

            case 'file':
                $html .= "        <input type=\"file\" name=\"$fieldName\" id=\"$fieldName\" class=\"w-full border rounded px-3 py-2\">\n";
                break;

            default:
                // Default to text input (string type)
                $html .= "        <input type=\"text\" name=\"$fieldName\" id=\"$fieldName\" value=\"" . $valueExpr . "\" required class=\"w-full border rounded px-3 py-2\">\n";
                break;
        }

        $html .= "    </div>\n\n";
    }

    return $html;
}

/**
 * Check if fields require multipart/form-data
 */
function fieldsRequireMultipart($fields)
{
    foreach ($fields as $fieldDef) {
        $type = $fieldDef['type'] ?? 'string';
        if (in_array($type, ['image', 'file'])) {
            return true;
        }
    }
    return false;
}

/**
 * Inject a single route into app/routes/index.php
 */
function injectRoute($method, $path, $handler)
{
    global $projectRoot;
    $routesFile = $projectRoot . '/app/routes/index.php';

    if (!file_exists($routesFile)) {
        echo "⚠️ app/routes/index.php not found. Creating it...\n";
        file_put_contents($routesFile, "<?php\n\nreturn [\n];\n");
    }

    $content = file_get_contents($routesFile);
    $routeLine = "    ['$method', '$path', '$handler'],\n";

    // Simple check - if route line already in content
    if (strpos($content, $routeLine) !== false) {
        echo "⚠️ Route already exists: $method $path\n";
        return false;
    }

    // Find the closing ] and insert before it
    $pos = strrpos($content, '];');
    if ($pos !== false) {
        $content = substr($content, 0, $pos) . $routeLine . '];';
    } else {
        $content = rtrim($content) . "\n" . $routeLine;
    }

    file_put_contents($routesFile, $content);
    echo "✅ Route added: $method $path -> $handler\n";
    return true;
}

/**
 * Inject CRUD routes for a resource
 * remove $className
 */
function injectCrudRoutes($resource, $className)
{
    $routes = [
        ['GET', "/$resource", "$resource:{$resource}_index"],
        ['GET', "/$resource/create", "$resource:{$resource}_create"],
        ['POST', "/$resource/store", "$resource:{$resource}_store"],
        ['GET', "/$resource/(\d+)", "$resource:{$resource}_show"],
        ['GET', "/$resource/(\d+)/edit", "$resource:{$resource}_edit"],
        ['POST', "/$resource/(\d+)/update", "$resource:{$resource}_update"],
        ['POST', "/$resource/(\d+)/delete", "$resource:{$resource}_delete"],
    ];

    $injected = 0;
    foreach ($routes as $route) {
        if (injectRoute($route[0], $route[1], $route[2])) {
            $injected++;
        }
    }

    return $injected;
}

/**
 * Generate a model file
 */
function makeModel($name, $table = null)
{
    global $projectRoot;
    if (!$name) {
        echo "⚠️ Please provide a model name. Example: yflite make:model User\n";
        return false;
    }

    $modelPath = $projectRoot . '/models/' . $name . '.php';

    if (file_exists($modelPath)) {
        echo "⚠️ Model already exists: models/$name.php\n";
        return false;
    }

    // Create models directory if needed
    $modelDir = $projectRoot . '/models';
    if (!is_dir($modelDir)) {
        mkdir($modelDir, 0777, true);
    }

    // Determine table name
    if (!$table) {
        $table = strtolower($name);
        // Convert PascalCase to snake_case for table name
        $table = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $table));
    }

    $template = TemplateLoader::render('model.php.stub', [
        'className' => $name,
        'tableName' => $table
    ]);

    file_put_contents($modelPath, $template);
    echo "✅ Model created: models/$name.php\n";
    return true;
}

/**
 * Generate CRUD files for a resource
 */
function makeCrud($name, $fields = null)
{
    global $projectRoot;
    if (!$name) {
        echo "⚠️ Please provide a resource name. Example: yflite make:crud Product\n";
        return false;
    }

    $resource = strtolower($name);
    $className = ucfirst($name);

    // Parse fields
    $parsedFields = parseFields($fields);

    // Create directories
    $controllerDir = $projectRoot . '/controllers';
    $modelDir = $projectRoot . '/models';
    $viewDir = $projectRoot . '/app/views/pages/' . $resource;

    foreach ([$controllerDir, $modelDir, $viewDir] as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    // Generate controller
    $controllerPath = $controllerDir . '/' . $resource . '.php';
    if (!file_exists($controllerPath)) {
        $controllerTemplate = TemplateLoader::render('controller.php.stub', [
            'title' => $className,
            'resource' => $resource,
        ]);
        file_put_contents($controllerPath, $controllerTemplate);
        echo "✅ Controller created: app/controllers/$resource.php\n";
    } else {
        echo "⚠️ Controller already exists: app/controllers/$resource.php\n";
    }

    // Generate model
    $modelPath = $modelDir . '/' . $className . '.php';
    if (!file_exists($modelPath)) {
        $modelTemplate = TemplateLoader::render('model.php.stub', [
            'className' => $className,
            'tableName' => $resource
        ]);
        file_put_contents($modelPath, $modelTemplate);
        echo "✅ Model created: models/$className.php\n";
    } else {
        echo "⚠️ Model already exists: models/$className.php\n";
    }

    // Generate views
    $viewTemplates = [
        'index' => 'crud/index.php.stub',
        'create' => 'crud/create.php.stub',
        'edit' => 'crud/edit.php.stub',
        'show' => 'crud/show.php.stub'
    ];

    $formFields = generateFormFields($parsedFields);
    $editFormFields = generateFormFields($parsedFields, '$item');
    $hasFileFields = fieldsRequireMultipart($parsedFields);
    $enctype = $hasFileFields ? ' enctype="multipart/form-data"' : '';

    foreach ($viewTemplates as $viewName => $templateName) {
        $viewPath = $viewDir . '/' . $viewName . '.php';

        $viewVars = [
            'resource' => $resource,
            'className' => $className,
            'resourceTitle' => ucfirst($resource),
            'formFields' => $viewName === 'create' ? $formFields : ($viewName === 'edit' ? $editFormFields : ''),
            'enctype' => ($viewName === 'create' || $viewName === 'edit') ? $enctype : ''
        ];

        $viewContent = TemplateLoader::render($templateName, $viewVars);
        file_put_contents($viewPath, $viewContent);
        echo "✅ View created: app/views/pages/$resource/$viewName.php\n";
    }

    // Inject routes
    $routesInjected = injectCrudRoutes($resource, $className);
    if ($routesInjected > 0) {
        echo "✅ $routesInjected CRUD routes added to app/routes/index.php\n";
    }

    echo "✅ CRUD scaffolding complete for: $name\n";
    return true;
}
