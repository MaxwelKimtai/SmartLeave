<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_role'])) {
    echo json_encode([
        'logged_in' => false,
        'message'   => 'No active session'
    ]);
    exit;
}

echo json_encode([
    'logged_in' => true,
    'id'        => $_SESSION['user_id'],
    'name'      => $_SESSION['user_name'],
    'role'      => $_SESSION['user_role']
]);
