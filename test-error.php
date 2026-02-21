<?php
// Force error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('error_log', __DIR__ . '/wp-content/php-errors.log');

// Test error logging
error_log("Test error message from PHP");

// Test file writing
$log_file = __DIR__ . '/wp-content/test-write.log';
file_put_contents($log_file, date('Y-m-d H:i:s') . " - Test write\n", FILE_APPEND);

echo "Error log path: " . ini_get('error_log') . "<br>";
echo "Log file writable: " . (is_writable(dirname($log_file)) ? 'Yes' : 'No') . "<br>";
echo "Test completed. Check the files.";
?>
