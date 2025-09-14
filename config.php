<?php
// Database credentials (only needed if your frontend still uses the DB directly)
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'smart_leave_db');

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn === false) {
    die("ERROR: Could not connect. " . $conn->connect_error);
}

// Backend API base URL (Laravel server)
define('API_BASE_URL', 'http://127.0.0.1:8000/api');
