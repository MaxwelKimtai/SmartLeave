<?php
session_start();
require_once __DIR__ . '/config.php';

// ✅ Check login
$apiToken = $_SESSION['api_token'] ?? null;
if (!$apiToken) {
    header("Location: login.php");
    exit;
}

// ✅ Handle AJAX fetch (proxy to Laravel)
if (isset($_GET['fetch_pending'])) {
    header('Content-Type: application/json');
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");

    $ch = curl_init(API_BASE_URL . '/manager/leave_requests');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Authorization: Bearer ' . $apiToken
    ]);

    $response = curl_exec($ch);
    if ($response === false) {
        http_response_code(500);
        echo json_encode(['message' => curl_error($ch)]);
        exit;
    }
    curl_close($ch);

    echo $response;
    exit;
}

// ✅ Handle Approve/Reject (proxy)
if (isset($_POST['action'], $_POST['request_id'])) {
    $action = $_POST['action']; // approve or reject
    $id = $_POST['request_id'];

    $ch = curl_init(API_BASE_URL . "/manager/leave_requests/$id/$action");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Authorization: Bearer ' . $apiToken
    ]);

    $response = curl_exec($ch);
    if ($response === false) {
        http_response_code(500);
        echo json_encode(['message' => curl_error($ch)]);
        exit;
    }
    curl_close($ch);

    header('Content-Type: application/json');
    echo $response;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard - Smart Leave</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/manager_dashboard.css">
</head>
<body>
<div class="dashboard-layout">
    <aside class="sidebar">
        <div class="logo">
            <img src="assets/logo.png" alt="Logo">
            <span>SMART LEAVE</span>
        </div>
        <nav class="main-nav">
            <ul>
                <li class="nav-item active"><a href="#"><i class="fas fa-th-large"></i> Dashboard</a></li>
                <li class="nav-item"><a href="#"><i class="fas fa-calendar-check"></i> Manage Leaves</a></li>
                <li class="nav-item"><a href="#"><i class="fas fa-users"></i> Employees</a></li>
                <li class="nav-item"><a href="#"><i class="fas fa-chart-line"></i> Reports</a></li>
                <li class="nav-item"><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
            </ul>
        </nav>
        <div class="logout-section">
            <a href="logout.php" class="logout-button"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </aside>

    <main class="main-content">
        <header class="top-header">
            <div class="greeting">
                <h1>Good Morning, Manager!</h1>
                <p id="currentDate"></p>
            </div>
            <div class="user-profile">
                <img src="https://placehold.co/40x40/FFC107/333333?text=M" alt="Manager Avatar" class="avatar">
                <span class="user-name">Manager</span>
                <i class="fas fa-bell notification-icon"></i>
            </div>
        </header>

        <section class="dashboard-summary">
            <div class="summary-card">
                <div class="card-icon"><i class="fas fa-users"></i></div>
                <div class="card-info"><h3>85</h3><p>Total Employees</p></div>
            </div>
            <div class="summary-card">
                <div class="card-icon"><i class="fas fa-hourglass-half"></i></div>
                <div class="card-info"><h3>1</h3><p>Pending Requests</p></div>
            </div>
            <div class="summary-card">
                <div class="card-icon"><i class="fas fa-check-circle"></i></div>
                <div class="card-info"><h3>29</h3><p>Approved This Month</p></div>
            </div>
            <div class="summary-card">
                <div class="card-icon"><i class="fas fa-times-circle"></i></div>
                <div class="card-info"><h3>3</h3><p>Rejected This Month</p></div>
            </div>
        </section>

        <section class="pending-requests-section">
            <h2><i class="fas fa-list-alt"></i> Pending Leave Requests</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Employee Name</th>
                            <th>Leave Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Days</th>
                            <th>Reason</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td colspan="7" style="text-align:center; color:#888;">Loading pending requests...</td></tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>

<div id="toast-container"></div>

<script>
// ✅ Use PHP constant inside JS
const API_BASE_URL = "<?php echo API_BASE_URL; ?>";
localStorage.setItem('token', <?php echo json_encode($apiToken); ?>);

// Toast function
function showToast(message, type = 'success') {
    const toastContainer = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.classList.add('toast', type);
    toast.textContent = message;
    toastContainer.appendChild(toast);

    void toast.offsetWidth;
    toast.classList.add('show');

    setTimeout(() => {
        toast.classList.remove('show');
        toast.classList.add('hide');
        toast.addEventListener('transitionend', () => toast.remove(), { once: true });
    }, 3000);
}

// ✅ Load pending leave requests (through PHP proxy)
async function loadPendingRequests() {
    const tbody = document.querySelector('.pending-requests-section tbody');
    tbody.innerHTML = `<tr><td colspan="7">Loading pending requests...</td></tr>`;

    try {
        const res = await fetch('manager_dashboard.php?fetch_pending=1');
        const text = await res.text();

        if (!res.ok) {
            tbody.innerHTML = `<tr><td colspan="7">Error loading requests</td></tr>`;
            console.error('Error fetching requests:', text);
            return;
        }

        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            console.error('Invalid JSON received:', text.substring(0, 300) + '...');
            tbody.innerHTML = `<tr><td colspan="7">Server returned invalid data.</td></tr>`;
            return;
        }

        const pendingRequests = data.pending ?? [];

        tbody.innerHTML = '';
        if (!Array.isArray(pendingRequests) || pendingRequests.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7">No pending requests.</td></tr>`;
            return;
        }

        pendingRequests.forEach(req => {
            const employeeName = req.employee?.name || 'Unknown';
            tbody.innerHTML += `
                <tr data-request-id="${req.id}">
                    <td>${employeeName}</td>
                    <td>${req.leave_type ?? '-'}</td>
                    <td>${req.start_date ?? '-'}</td>
                    <td>${req.end_date ?? '-'}</td>
                    <td>${req.number_of_days ?? '-'}</td>
                    <td>${req.reason ?? '-'}</td>
                    <td class="actions">
                        <button class="action-button approve-button" data-action="approve">✅ Approve</button>
                        <button class="action-button reject-button" data-action="reject">❌ Reject</button>
                    </td>
                </tr>
            `;
        });

        bindActionButtons();

    } catch (err) {
        console.error('Network error:', err);
        tbody.innerHTML = `<tr><td colspan="7">Network error. Please try again later.</td></tr>`;
    }
}

// ✅ Approve/Reject button binding
function bindActionButtons() {
    document.querySelectorAll('.action-button').forEach(button => {
        button.addEventListener('click', async function() {
            const row = this.closest('tr');
            const requestId = row.dataset.requestId;
            const action = this.dataset.action;

            try {
                const formData = new FormData();
                formData.append('action', action);
                formData.append('request_id', requestId);

                const res = await fetch('manager_dashboard.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await res.json();
                if (res.ok) {
                    // Disable buttons immediately for smoother UX
                    row.querySelectorAll('.action-button').forEach(btn => btn.disabled = true);
                    showToast(`Request ${action}ed successfully!`);
                    loadPendingRequests(); // refresh the list
                } else {
                    showToast(data?.message || `Failed to ${action} request.`, 'error');
                }

            } catch (err) {
                console.error(`Error during ${action}:`, err);
                showToast(`Error trying to ${action}.`, 'error');
            }
        });
    });
}

// ✅ Initialize dashboard
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('currentDate').textContent =
        new Date().toLocaleDateString('en-US', { weekday:'long', year:'numeric', month:'long', day:'numeric' });

    loadPendingRequests();
});
</script>
</body>
</html>
