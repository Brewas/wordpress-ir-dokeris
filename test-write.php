<?php
$log_file = __DIR__ . '/wp-content/debug.log';

// Test 1: Can we write directly?
$result1 = file_put_contents($log_file, date('Y-m-d H:i:s') . " - Direct write test\n", FILE_APPEND);

// Test 2: Can we use error_log?
error_log("Error log test message");

// Test 3: Check permissions
echo "Log file: $log_file<br>";
echo "File exists: " . (file_exists($log_file) ? 'Yes' : 'No') . "<br>";
echo "File writable: " . (is_writable($log_file) ? 'Yes' : 'No') . "<br>";
echo "Direct write result: " . ($result1 !== false ? 'Success' : 'Failed') . "<br>";

// Show file contents
if (file_exists($log_file)) {
    echo "<br>File contents:<br><pre>";
    echo file_get_contents($log_file);
    echo "</pre>";
}
?>
