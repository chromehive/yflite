#!/usr/bin/env php
<?php
/**
 * scripts/pack_production.php
 * Safely build a production-ready folder and optional ZIP for YFlite projects.
 *
 * Usage examples:
 * yflite build --dest=build-example --zip --controllers=a.php,b.php --models=j.php,k.php --views=x.php,y.php --includeFile=extras.txt
 *
 */

ini_set('display_errors', '0');
error_reporting(E_ALL & ~E_NOTICE);

/* -----------------------------
   Helper: print to STDERR
   ----------------------------- */
function eprint($msg)
{
    fwrite(STDERR, $msg . PHP_EOL);
}

/* -----------------------------
   Usage / Help
   ----------------------------- */
function usage()
{
    $u = <<<USG
Usage: yflite build [options]

Options:
  --dest=NAME             Destination directory name inside _build/ (only A-Za-z0-9_-). Default: dist
  --zip                   Create a ZIP archive of the build folder
  --controllers=a,b       Comma-separated list of controller files (without or with .php)
  --models=x,y            Comma-separated list of model files
  --views=foo,bar         Comma-separated list of view files
  --includeFile=path      Path to a file listing additional include paths, one per line (relative paths, no traversal)
  --help                  Show this help

Examples:
  yflite build --dest=build-example --zip --controllers=a.php,b.php --models=j.php,k.php --views=x.php,y.php --includeFile=extras.txt

USG;
    echo $u;
}

/* -----------------------------
   Allowed arguments validation
   ----------------------------- */
$allowedArgs = [
    'dest',
    'zip',
    'controllers',
    'models',
    'views',
    'includeFile',
    'help'
];

/* -----------------------------
   Parse args with getopt
   ----------------------------- */
$opts = getopt('', ['dest::', 'zip', 'controllers::', 'models::', 'views::', 'includeFile::', 'help']);

if (isset($opts['help'])) {
    usage();
    exit(0);
}

/* Validate flags */
foreach (array_keys($opts) as $flag) {
    if (!in_array($flag, $allowedArgs, true)) {
        eprint("Error: Unknown flag --{$flag}");
        usage();
        exit(1);
    }
}

/* -----------------------------
   Safety validators
   ----------------------------- */
function validateDestName(string $name): bool
{
    return (bool)preg_match('/^[A-Za-z0-9_-]+$/', $name);
}

function validateSafePath(string $path): bool
{
    // disallow traversal and absolute paths
    if ($path === '') return false;
    if (strpos($path, '..') !== false) return false;
    // Windows absolute like C:\ or / starting with slash
    if (preg_match('/^[A-Za-z]:\\\\/', $path)) return false;
    if (substr($path, 0, 1) === '/' || substr($path, 0, 1) === '\\') return false;
    // allow letters, numbers, dot, underscore, dash and slashes
    return (bool)preg_match('#^[A-Za-z0-9_\-./\\\\]+$#', $path);
}

/* -----------------------------
   Filesystem guard: only delete inside _build (and never delete the _build root)
   ----------------------------- */
function safeCanDelete(string $path): bool
{
    $destBuildDir = realpath($path);
    if ($destBuildDir === false) return false;

    $buildRoot = $destBuildDir . '/../';
    $buildRootReal = realpath($buildRoot);

    // create _build if not exists so realpath works consistently
    if ($buildRootReal === false) {
        @mkdir($buildRoot, 0777, true);
        $buildRootReal = realpath($buildRoot);
    }
    if ($buildRootReal === false) return false;

    // Ensure $destBuildDir is inside buildRootReal
    // Normalize separators
    $r = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $destBuildDir);
    $b = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $buildRootReal);

    if (strpos($r, $b) !== 0) {
        return false;
    }

    // Do not allow deletion of the _build root itself
    if ($r === $b) return false;

    return true;
}

/* -----------------------------
   Safe recursive delete (only inside _build)
   ----------------------------- */
function rrmdir_safe(string $dir)
{
    $destBuildDir = realpath($dir);
    if ($destBuildDir === false) return;

    if (!safeCanDelete($destBuildDir)) {
        eprint("[ERROR] Refusing to delete outside safe _build scope: {$destBuildDir}");
        return;
    }

    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($destBuildDir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($it as $fileinfo) {
        $path = $fileinfo->getRealPath();
        if ($path === false) continue;
        // double-check path still inside build root
        if (!safeCanDelete(dirname($path))) {
            eprint("[WARN] Skipping unsafe path during delete: {$path}");
            continue;
        }
        if ($fileinfo->isDir()) {
            @rmdir($path);
        } else {
            @unlink($path);
        }
    }
    @rmdir($destBuildDir);
}

/* -----------------------------
   Safe copy recursive (no traversal, skip unsafe names)
   ----------------------------- */
function copyRecursive_safe(string $src, string $dst)
{
    // resolve src
    $srcReal = realpath($src);
    if ($srcReal === false) {
        eprint("[WARN] Source not found, skipping: {$src}");
        return false;
    }

    // Prevent copying if src path contains traversal tokens
    if (strpos($src, '..') !== false) {
        eprint("[WARN] Source contains '..' - skipping: {$src}");
        return false;
    }

    // Prevent absolute paths (only relative allowed)
    // if (substr($src, 0, 1) === '/' || substr($src, 0, 1) === '\\' || preg_match('/^[A-Za-z]:\\\\/', $src)) {
    //     eprint("[WARN] Absolute source path not allowed (use relative): {$src}");
    //     return false;
    // }

    // If single file
    if (is_file($srcReal)) {
        @mkdir(dirname($dst), 0777, true);
        return copy($srcReal, $dst);
    }

    // Directory copy
    if (!is_dir($srcReal)) {
        eprint("[WARN] Source is not a directory: {$srcReal}");
        return false;
    }

    @mkdir($dst, 0777, true);
    $dir = opendir($srcReal);
    if (!$dir) return false;

    while (false !== ($file = readdir($dir))) {
        if ($file === '.' || $file === '..') continue;
        if (strpos($file, '..') !== false) {
            eprint("[WARN] Unsafe filename skipped: {$file}");
            continue;
        }

        $srcPath = $srcReal . DIRECTORY_SEPARATOR . $file;
        $dstPath = $dst . DIRECTORY_SEPARATOR . $file;

        if (is_dir($srcPath)) {
            copyRecursive_safe($srcPath, $dstPath);
        } else {
            // create dest dir if needed
            @mkdir(dirname($dstPath), 0777, true);
            copy($srcPath, $dstPath);
        }
    }
    closedir($dir);
    return true;
}

/* -----------------------------
   normalizeList: sanitize and prefix with folder
   ----------------------------- */
function normalizeList_safe($arg, $folder)
{
    $out = [];
    if (!$arg) return $out;

    $parts = array_filter(array_map('trim', explode(',', $arg)));
    foreach ($parts as $p) {
        if ($p === '') continue;
        // only safe characters for file names
        if (!preg_match('/^[A-Za-z0-9_\-\.]+$/', $p)) {
            eprint("[WARN] Invalid filename skipped: {$p}");
            continue;
        }
        if (strpos($p, '..') !== false) {
            eprint("[WARN] Unsafe filename skipped (..): {$p}");
            continue;
        }
        // add extension if missing
        if (pathinfo($p, PATHINFO_EXTENSION) === '') $p .= '.php';
        $safePath = rtrim($folder, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $p;
        $out[] = $safePath;
    }
    return $out;
}

/* -----------------------------
   Simple progress line (counts items)
   ----------------------------- */
function progressStart($total)
{
    if ($total <= 0) return;
    echo "Progress: 0/{$total}\r";
}

function progressAdvance(&$count, $total, $label = '')
{
    $count++;
    if ($total > 0) {
        echo "Progress: {$count}/{$total} - {$label}" . str_repeat(' ', 10) . "\r";
        if ($count >= $total) echo PHP_EOL;
    }
}

/* -----------------------------
   Begin main script logic
   ----------------------------- */

$isDestSet = isset($opts['dest']);
$destName = $opts['dest'] ?? 'dist';
$makeZip = isset($opts['zip']);
$controllersArg = $opts['controllers'] ?? null;
$modelsArg = $opts['models'] ?? null;
$viewsArg = $opts['views'] ?? null;
$includeFile = $opts['includeFile'] ?? null;

/* Validate dest name */
if (!validateDestName($destName)) {
    eprint("Invalid destination name '{$destName}'. Allowed characters: A-Z a-z 0-9 _ (underscore).");
    exit(1);
}

/* Base includes (defaults) */
$baseIncludes = [
    'path.php',
    'composer.json',
    'core',
    'configs',
    'middlewares',
    'routes',
    'helpers',
    'public',
    'api',
];
$includes = $baseIncludes;

/* Load includes from includeFile (if provided). Must be safe paths relative to project root */
if ($includeFile) {
    if (!file_exists($includeFile)) {
        eprint("Include file not found: {$includeFile}");
        exit(1);
    }
    $lines = file($includeFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $path = trim($line);
        if ($path === '') continue;
        if (!validateSafePath($path)) {
            eprint("Unsafe include path detected in includeFile: {$path}");
            exit(1);
        }
        $includes[] = $path;
    }
}

/* Normalize custom lists */
$controllerPaths = normalizeList_safe($controllersArg, 'controllers');
$viewPaths = normalizeList_safe($viewsArg, 'views');
$modelPaths = normalizeList_safe($modelsArg, 'models');

/* If no specific controllers/models/views provided, include entire folders */
if (empty($controllerPaths)) {
    $includes[] = 'controllers';
} else {
    foreach ($controllerPaths as $p) $includes[] = $p;
}
if (empty($viewPaths)) {
    $includes[] = 'views';
} else {
    foreach ($viewPaths as $p) $includes[] = $p;
}
if (empty($modelPaths)) {
    $includes[] = 'models';
} else {
    foreach ($modelPaths as $p) $includes[] = $p;
}

/* Deduplicate preserving order */
$seen = [];
$uniq = [];
foreach ($includes as $i) {
    if ($i === '' || $i === null) continue;
    if (isset($seen[$i])) continue;
    $seen[$i] = true;
    $uniq[] = $i;
}
$includes = $uniq;

/* Final dest path inside _build/ */
$destDir = '_build' . DIRECTORY_SEPARATOR . $destName; //$projectRoot . DIRECTORY_SEPARATOR . 
$projectRoot = getcwd();


/* If exists, remove existing dest safely */
if (file_exists($destDir)) {
    echo "Preparing to remove existing {$destDir}\n";

    if (!safeCanDelete($destDir)) {
        eprint("Refusing to delete '{$destDir}' — unsafe path.");
        exit(1);
    }

    rrmdir_safe($destDir);
}

/* Create destination */
if (!is_dir($destDir) && !@mkdir($destDir, 0777, true)) {
    eprint("Failed to create destination directory: {$destDir}");
    exit(1);
}

/* Copy selected includes into dest */
$copied = [];
$totalItems = count($includes);
$progressCount = 0;
progressStart($totalItems);

foreach ($includes as $pathToInc) {
    if (!$pathToInc) continue;

    // pathToInc relative to project root
    $source = $projectRoot . DIRECTORY_SEPARATOR . $pathToInc;

    // If the source does not exist, skip with message
    if (!file_exists($source)) {
        echo PHP_EOL;
        $progressCount = $progressCount - 1;
        echo "Skipped missing: {$pathToInc}\n";
        progressAdvance($progressCount, $totalItems, "Skipped {$pathToInc}");
        continue;
    }

    // target pathToInc inside dest
    $target = $destDir . DIRECTORY_SEPARATOR . $pathToInc;

    // If source is file or directory, use safe copy
    if (is_dir($source)) {
        copyRecursive_safe($source, $target);
    } else {
        @mkdir(dirname($target), 0777, true);
        copy($source, $target);
    }

    if (file_exists($source)) {
        $copied[] = $pathToInc;
    }
    progressAdvance($progressCount, $totalItems, "Copied {$pathToInc}");
}

/* Summary of copied items */
echo PHP_EOL;
echo "Copied " . count($copied) . " paths to {$destDir}:\n";
foreach ($copied as $c) echo " - {$c}\n";

/* -----------------------------
   Create ZIP if requested
   ----------------------------- */
if ($makeZip) {
    $zipFile = $destDir . '.zip';

    if (file_exists($zipFile)) {
        // remove previous zip safely inside _build
        if (safeCanDelete(dirname($zipFile))) {
            @unlink($zipFile);
        }
    }

    $zip = new ZipArchive();
    if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($destDir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
        $base = realpath($destDir);
        foreach ($it as $file) {
            $filePath = $file->getRealPath();
            if ($filePath === false) continue;
            $relativePath = substr($filePath, strlen($base) + 1);
            // normalize path for zip entry
            $zip->addFile($filePath, str_replace('\\', '/', $relativePath));
        }
        $zip->close();
        echo "Created ZIP: {$zipFile}\n";
    } else {
        eprint("Failed to create zip file: {$zipFile}");
        exit(1);
    }

    // If dest was NOT explicitly set by user and the default is used, remove the folder after zip
    if (!$isDestSet) {
        // only remove if safe and matches default name 'dist' (this mirrors previous behaviour)
        if ($destName === 'dist') {
            if (safeCanDelete($destDir)) {
                echo "Removing {$destDir} directory (default dest was used)\n";
                rrmdir_safe($destDir);
            } else {
                echo "Refusing to remove {$destDir} (unsafe)\n";
            }
        } else {
            echo "Keeping {$destDir} directory\n";
        }
    } else {
        echo "Keeping {$destDir} directory\n";
    }
}

/* -----------------------------
   Finish
   ----------------------------- */
echo "Done.\n";
echo "Production Build Completed Successfully.\n";
exit(0);
