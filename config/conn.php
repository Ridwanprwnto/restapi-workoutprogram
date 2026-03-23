<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

function loadEnv($path)
{
    if (!file_exists($path)) {
        throw new Exception(".env file not found at path: " . $path);
    }

    // Baca file dan hapus BOM jika ada
    $content = file_get_contents($path);
    $content = str_replace("\xEF\xBB\xBF", '', $content); // hapus UTF-8 BOM

    $lines = explode("\n", $content);

    foreach ($lines as $line) {
        // Hapus whitespace & carriage return (Windows CRLF)
        $line = trim($line, "\r\n\t ");

        // Skip baris kosong dan komentar
        if (empty($line) || strpos($line, '#') === 0) {
            continue;
        }

        // Skip jika tidak ada tanda '='
        if (strpos($line, '=') === false) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $name  = trim($name);
        $value = trim($value);

        // Hapus tanda kutip jika ada
        $value = trim($value, '"\'');

        if (!empty($name)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name]    = $value;
            $_SERVER[$name] = $value;
        }
    }
}

// Load .env
try {
    loadEnv(__DIR__ . '/../.env');
} catch (Exception $e) {
    die("Error loading .env file: " . $e->getMessage());
}

// Ambil kredensial langsung dari $_ENV
$servername = $_ENV['DB_HOST']     ?? 'localhost';
$username   = $_ENV['DB_USERNAME'] ?? '';
$password   = $_ENV['DB_PASSWORD'] ?? '';
$dbname     = $_ENV['DB_NAME']     ?? '';

// Buat koneksi
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Cek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset ke UTF-8
mysqli_set_charset($conn, 'utf8mb4');
?>