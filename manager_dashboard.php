<?php
session_start();

// ✅ Check if logged in
if (!isset($_SESSION['api_token'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard - Smart Leave</title>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts for Inter and Playfair Display -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <!-- Link to the manager dashboard CSS -->
    <link rel="stylesheet" href="css/manager_dashboard.css">
</head>
<body>
    <div class="dashboard-layout">
        <aside class="sidebar">
            <div class="logo">
                <img src="assets/logo.png" alt="Homies Lab Logo">
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
                <a href="#" class="logout-button"><i class="fas fa-sign-out-alt"></i> Logout</a>
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
                <div class="summary-card"><div class="card-icon"><i class="fas fa-users"></i></div><div class="card-info"><h3>85</h3><p>Total Employees</p></div></div>
                <div class="summary-card"><div class="card-icon"><i class="fas fa-hourglass-half"></i></div><div class="card-info"><h3>1</h3><p>Pending Requests</p></div></div>
                <div class="summary-card"><div class="card-icon"><i class="fas fa-check-circle"></i></div><div class="card-info"><h3>29</h3><p>Approved This Month</p></div></div>
                <div class="summary-card"><div class="card-icon"><i class="fas fa-times-circle"></i></div><div class="card-info"><h3>3</h3><p>Rejected This Month</p></div></div>
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
// Store API token
localStorage.setItem('token', <?php echo json_encode($apiToken); ?>);

// Toast notification function
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

// Load pending leave requests safely
async function loadPendingRequests() {
    const tbody = document.querySelector('.pending-requests-section tbody');
    tbody.innerHTML = `<tr><td colspan="7">Loading pending requests...</td></tr>`;

    try {
        // Fetch pending requests via PHP proxy
       const res = await fetch('http://localhost/smart_leave_management_system/manager_dashboard.php?fetch_pending');

        const contentType = res.headers.get("content-type");
        let data = null;

        // Attempt JSON parse if content type is JSON
        if (contentType && contentType.includes("application/json")) {
            try {
                data = await res.json();
            } catch (jsonErr) {
                console.error("Failed to parse JSON:", jsonErr);
                tbody.innerHTML = `<tr><td colspan="7">Invalid server response. Please contact admin.</td></tr>`;
                return;
            }
        } else {
            const text = await res.text();
            console.error("Unexpected response from server:", text);
            tbody.innerHTML = `<tr><td colspan="7">Unexpected server response. Check backend logs.</td></tr>`;
            return;
        }

        // Handle HTTP errors
        if (!res.ok) {
            const msg = data?.message || `Server error (${res.status})`;
            tbody.innerHTML = `<tr><td colspan="7">${msg}</td></tr>`;
            console.error("Backend error details:", data);
            return;
        }

        // Populate table
        tbody.innerHTML = '';
        if (!Array.isArray(data) || data.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7">No pending requests.</td></tr>`;
            return;
        }

        data.forEach(req => {
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
        console.error("Network or fetch error:", err);
        tbody.innerHTML = `<tr><td colspan="7">Network error. Please try again later.</td></tr>`;
    }
}

// Bind approve/reject buttons safely
function bindActionButtons() {
    document.querySelectorAll('.action-button').forEach(button => {
        button.addEventListener('click', async function() {
            const row = this.closest('tr');
            const requestId = row.dataset.requestId;
            const action = this.dataset.action;
            const token = localStorage.getItem('token');

            try {
                const res = await fetch(`http://localhost/api/manager/leave_requests/${requestId}/${action}`, {
                    method: "POST",
                    headers: { "Accept": "application/json", "Authorization": "Bearer " + token }
                });

                const contentType = res.headers.get("content-type");
                let data = {};

                if (contentType?.includes("application/json")) {
                    try { data = await res.json(); } 
                    catch (jsonErr) { console.error("Failed to parse JSON:", jsonErr); }
                } else {
                    const text = await res.text();
                    console.error("Unexpected response:", text);
                }

                if (res.ok) {
                    showToast(`Request ${action}ed successfully!`);
                    row.remove();
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

// Initialize page
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('currentDate').textContent =
        new Date().toLocaleDateString('en-US', { weekday:'long', year:'numeric', month:'long', day:'numeric' });

    loadPendingRequests();
});
<script/>

</body>
</html>
