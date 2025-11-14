<?php

/**
 * scripts/pack_production.php
 *
 * Create a minimal production package by copying only essential files and
 * optionally creating a zip. Supports restricting which controllers and
 * views to include.
 *
 * Usage:
 *   php scripts/pack_production.php [--dest=dist] [--zip]
 *   php scripts/pack_production.php --controllers=home.php,product.php --views=layout.php,home.php
 *   php scripts/pack_production.php --include-file=includes.txt
 */

ini_set('display_errors', '0');
error_reporting(E_ALL & ~E_NOTICE);

$opts = getopt('', ['dest::', 'zip', 'controllers::', 'models::', 'views::', 'include-file::', 'help']);
if (isset($opts['help'])) {
    echo "Usage: php scripts/pack_production.php [--dest=dist] [--zip] [--controllers=a.php,b.php] [--models=j.php,k.php] [--views=x.php,y.php] [--include-file=path]\n";
    exit(0);
}

$isDestSet = isset($opts['dest']);
$dest = $opts['dest'] ?? 'dist';
$makeZip = isset($opts['zip']);
$controllersArg = $opts['controllers'] ?? null;
$modelsArg = $opts['models'] ?? null;
$viewsArg = $opts['views'] ?? null;
$includeFile = $opts['include-file'] ?? null;

$baseIncludes = [
    'bootstrap.php',
    'config.php',
    'middlewares',
    'api',
    'path.php',
    'routes.php',
    'helpers.php',
    'public'
];

function rrmdir($dir)
{
    if (!is_dir($dir)) return;
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($it as $file) {
        if ($file->isDir()) rmdir($file->getPathname());
        else unlink($file->getPathname());
    }
    rmdir($dir);
}

function copyRecursive($src, $dst)
{
    if (is_file($src)) {
        @mkdir(dirname($dst), 0777, true);
        return copy($src, $dst);
    }
    $dir = opendir($src);
    @mkdir($dst, 0777, true);
    while (false !== ($file = readdir($dir))) {
        if ($file === '.' || $file === '..') continue;
        $srcPath = $src . DIRECTORY_SEPARATOR . $file;
        $dstPath = $dst . DIRECTORY_SEPARATOR . $file;
        if (is_dir($srcPath)) {
            copyRecursive($srcPath, $dstPath);
        } else {
            copy($srcPath, $dstPath);
        }
    }
    closedir($dir);
    return true;
}

function normalizeList($arg, $folder)
{
    $out = [];
    if (!$arg) return $out;
    $parts = array_filter(array_map('trim', explode(',', $arg)));
    foreach ($parts as $p) {
        if ($p === '') continue;
        // allow users to pass names with or without extension
        $name = $p;
        if (pathinfo($name, PATHINFO_EXTENSION) === '') {
            $name .= '.php';
        }
        $out[] = rtrim($folder, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $name;
    }
    return $out;
}

$includes = $baseIncludes;

// load includes from file if provided
if ($includeFile) {
    if (!file_exists($includeFile)) {
        fwrite(STDERR, "Include file not found: {$includeFile}\n");
        exit(1);
    }
    $lines = file($includeFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $includes[] = trim($line);
    }
}

$controllerPaths = normalizeList($controllersArg, 'controllers');
$viewPaths = normalizeList($viewsArg, 'views');
$modelPaths = normalizeList($modelsArg, 'models');

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

// dedupe while preserving order
$seen = [];
$uniq = [];
foreach ($includes as $i) {
    if (isset($seen[$i])) continue;
    $seen[$i] = true;
    $uniq[] = $i;
}
$includes = $uniq;

// prepare dest
if (file_exists($dest)) {
    echo "Removing existing {$dest}\n";
    rrmdir($dest);
}
mkdir($dest, 0777, true);

$copied = [];
foreach ($includes as $path) {
    if (!$path) continue;
    if (!file_exists($path)) {
        echo "Skipped missing: {$path}\n";
        continue;
    }
    $target = $dest . DIRECTORY_SEPARATOR . $path;
    if (is_dir($path)) {
        copyRecursive($path, $target);
    } else {
        @mkdir(dirname($target), 0777, true);
        copy($path, $target);
    }
    $copied[] = $path;
}

echo "Copied " . count($copied) . " paths to {$dest}:\n";
foreach ($copied as $c) echo " - {$c}\n";

if ($makeZip) {
    $zipFile = $dest . '.zip';
    if (file_exists($zipFile)) unlink($zipFile);
    $zip = new ZipArchive();
    if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
        $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dest, RecursiveDirectoryIterator::SKIP_DOTS)
        );
        $base = realpath($dest);
        foreach ($it as $file) {
            $filePath = $file->getRealPath();
            $localPath = substr($filePath, strlen($base) + 1);
            $zip->addFile($filePath, $localPath);
        }
        $zip->close();
        echo "Created {$zipFile}\n";

        // echo 'Folder Exist? ' . file_exists($dest);
        // echo 'Destination Set? ' . $isDestSet;

        if (empty($isDestSet)) {
            echo "Removing {$dest} directory \n";
            rrmdir($dest);
            // echo 'Folder Still Exist? ' . file_exists($dest);
        } else {
            echo "Keeping {$dest} directory \n";
            // echo 'Folder Still Exist? ' . file_exists($dest);
        }
    } else {
        echo "Failed to create zip\n";
    }
}

echo "Done.\n";
