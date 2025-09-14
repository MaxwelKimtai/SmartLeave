<?php
session_start();

if (isset($_SESSION['api_token'])) {
    echo "API Token: " . $_SESSION['api_token'];
} else {
    echo "No token found in session.";
}
