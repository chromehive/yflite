<?php
// config.php
// Internationalisation Settings
define('DEFAULT_LANG', 'en-us');
define('ALT_LANG', 'fr-fr');

// === Environment Mode ===
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    // development environment
    define('DEBUG', true);
} elseif ($_SERVER['SERVER_NAME'] == 'dev.mychromehive.com') {
    // staging environment
    define('DEBUG', true);
} else {
    // production environment
    define('DEBUG', false);
}


// === Environment Settings ===
if (DEBUG === true) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    ini_set('display_errors', 0);
}

// === Base URL ===
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    // development environment
    define('BASE_URL', 'http://localhost:7777'); //8000
} elseif ($_SERVER['SERVER_NAME'] == 'dev.mychromehive.com') {
    // staging environment
    define('BASE_URL', 'https://dev.mychromehive.com'); //8000
} else {
    // production environment
    define('BASE_URL', 'https://dev.mychromehive.com'); //8000
}

define('AUTH_URL', BASE_URL . '/auth');
define('ADMIN_URL', BASE_URL . '/admin');

define('APP_NAME', 'CHHVDevkit');
define('APP_NAME_SHORT', 'CHHVDevkit');

// === MySQLi Database Connection ===
// $conn = new mysqli('localhost', 'u921471634_vbadmin', ']y|o$QLT6', 'u921471634_vbdb');
$conn = new mysqli('localhost', 'root', '', 'u921471634_vbdb'); // cdk
// $conn = new mysqli('localhost', 'u921471634_vbtestadmin', 'N&[8>9iB', 'u921471634_vbtestdb');

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset('utf8mb4');
