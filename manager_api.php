<?php
session_start();

header("Content-Type: application/json");

// ✅ Check login
$apiToken = $_SESSION['api_token'] ?? null;
if (!$apiToken) {
    http_response_code(401);
    echo json_encode(['message' => 'Not logged in']);
    exit;
}

/**
 * Helper function to call Laravel API
 */
function callApi($method, $url, $token, $payload = null) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ]);

    if ($payload) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    }

    $response = curl_exec($ch);
    $status   = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        http_response_code(500);
        echo json_encode(['message' => "cURL error: $error"]);
        exit;
    }

    curl_close($ch);

    $data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(500);
        echo json_encode([
            'message' => 'Invalid JSON returned from API',
            'raw_response' => $response
        ]);
        exit;
    }

    http_response_code($status);
    return $data;
}

// ✅ Handle API endpoints

// 1. Fetch pending leave requests
if (isset($_GET['fetch_pending'])) {
    $data = callApi('GET', 'http://127.0.0.1:8000/api/manager/leave_requests', $apiToken);

    echo isset($data['data']) ? json_encode($data['data']) : json_encode($data);
    exit;
}

// 2. Approve or reject leave request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['leave_id'])) {
    $leaveId = intval($_POST['leave_id']);
    $action  = $_POST['action'];

    if (!in_array($action, ['approve', 'reject'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid action. Must be approve or reject']);
        exit;
    }

    $endpoint = "http://127.0.0.1:8000/api/manager/leave_requests/{$leaveId}/$action";
    $data = callApi('POST', $endpoint, $apiToken);

    echo json_encode($data);
    exit;
}

// 3. Default: no valid request
http_response_code(400);
echo json_encode([
    'message' => 'Invalid request. Use ?fetch_pending=1 (GET) or send POST with action + leave_id.'
]);
exit;
?>