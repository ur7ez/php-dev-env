<?php
$host = 'mariadb'; // 'php-dev-env-mariadb-1'
$dsn = "mysql:host=$host;dbname=testdb;charset=utf8mb4";
$options = [
    PDO::ATTR_EMULATE_PREPARES   => false, // Disable emulation mode for "real" prepared statements
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Disable errors in the form of exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Make the default fetch be an associative array
];
try {
    $db = new PDO($dsn, 'test_user', 'test_pwd', $options);
} catch (Exception $e) {
    error_log($e->getMessage());
    exit('Something bad happened');
}
echo 'DB connected';
phpinfo();