<?php
// Simple .env loader function to parse .env file and set environment variables
function loadEnv($path)
{
    if (!file_exists($path)) {
        throw new Exception(".env file not found at path: " . $path);
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue; // skip comments
        }
        // parse key=value lines
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        if (!getenv($name)) { // prevent overwriting existing env vars
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

// Load .env variables
try {
    loadEnv(__DIR__ . '../../.env');
} catch (Exception $e) {
    die("Error loading .env file: " . $e->getMessage());
}

// Retrieve environment variables for DB connection
$servername = getenv('DB_HOST') ?: 'localhost';
$username = getenv('DB_USERNAME') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';
$dbname = getenv('DB_NAME') ?: 'workout';

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>