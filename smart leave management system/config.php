<?php
// Database credentials
define('DB_SERVER', 'localhost'); // Usually 'localhost' for local development (XAMPP/WAMP/MAMP)
define('DB_USERNAME', 'root');   // Your MySQL username (commonly 'root' for local setups)
define('DB_PASSWORD', '');       // Your MySQL password (often empty '' for 'root' on XAMPP/WAMP without a set password)
define('DB_NAME', 'leave_system_db'); // The name of the database you created for the leave system

// Attempt to connect to MySQL database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . $conn->connect_error);
}

// --- Temporary debugging line (you can remove this once connection is confirmed) ---
// echo "Database connected successfully!";

?>