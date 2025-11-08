<?php
// public/index.php 
// Load path constants
require_once __DIR__ . '/../path.php';

// Load core configuration
require_once ROOT_DIR . '/config.php';

session_start();

define('REDIRECT_URI', $_SERVER['REQUEST_URI']);

// Load startup file containing the router
require_once ROOT_DIR . '/bootstrap.php';
