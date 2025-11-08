<?php
require_once __DIR__ . '/../src/Starter.php';

use YourNamespace\Starter;

// Initialize the Starter class
$starter = new Starter();

// Configure the developer pack
$starter->configure([
    'option1' => 'value1',
    'option2' => 'value2',
]);

// Start the developer pack
$starter->start();

// Output a message indicating that the developer pack has started
echo "Developer pack has been initialized and started successfully.\n";
?>