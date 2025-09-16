<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        <div class="card-info">
            <h3 id="totalEmployees">0</h3>
            <p>Total Employees</p>
        </div>
    </div>
    <div class="summary-card">
        <div class="card-icon"><i class="fas fa-hourglass-half"></i></div>
        <div class="card-info">
            <h3 id="pendingRequests">0</h3>
            <p>Pending Requests</p>
        </div>
    </div>
    <div class="summary-card">
        <div class="card-icon"><i class="fas fa-check-circle"></i></div>
        <div class="card-info">
            <h3 id="approvedRequests">0</h3>
            <p>Approved</p>
        </div>
    </div>
    <div class="summary-card">
        <div class="card-icon"><i class="fas fa-times-circle"></i></div>
        <div class="card-info">
            <h3 id="rejectedRequests">0</h3>
            <p>Rejected</p>
        </div>
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
// ✅ Get auth details from sessionStorage
const TOKEN = sessionStorage.getItem('api_token');
const USER_NAME = sessionStorage.getItem('user_name');
const USER_ROLE = sessionStorage.getItem('user_role');

// ✅ Block non-managers
if (!TOKEN || USER_ROLE !== 'manager') {
    window.location.href = "login.php";
}

// ✅ Personalize UI
document.querySelector('.user-name').textContent = USER_NAME || "Manager";
document.querySelector('.greeting h1').textContent = `Good Morning, ${USER_NAME || "Manager"}!`;

// ================================
// Toast function
// ================================
function showToast(message, type = 'success') {
    const toastContainer = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.classList.add('toast', type);
    toast.textContent = message;
    toastContainer.appendChild(toast);

    void toast.offsetWidth; // force reflow
    toast.classList.add('show');

    setTimeout(() => {
        toast.classList.remove('show');
        toast.classList.add('hide');
        toast.addEventListener('transitionend', () => toast.remove(), { once: true });
    }, 3000);
}

// ================================
// Load pending leave requests
// ================================
async function loadPendingRequests() {
    const tbody = document.querySelector('.pending-requests-section tbody');
    tbody.innerHTML = `<tr><td colspan="7">Loading pending requests...</td></tr>`;

    try {
        const res = await fetch('http://127.0.0.1:8000/api/manager/leave_requests', {
            headers: {
                'Authorization': `Bearer ${TOKEN}`,
                'Accept': 'application/json'
            }
        });

        const data = await res.json();

        if (!res.ok || data.success === false) {
            tbody.innerHTML = `<tr><td colspan="7">Error loading requests: ${data?.message || res.statusText}</td></tr>`;
            return;
        }

        const pendingRequests = Array.isArray(data.data) ? data.data : [];
        tbody.innerHTML = '';

        if (pendingRequests.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7">No pending requests.</td></tr>`;
            return;
        }

        pendingRequests.forEach(req => {
            tbody.innerHTML += `
                <tr data-request-id="${req.id}">
                    <td>${req.employee?.name ?? 'Unknown'}</td>
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

// ================================
// Approve / Reject actions
// ================================
function bindActionButtons() {
    document.querySelectorAll('.action-button').forEach(button => {
        button.addEventListener('click', async function() {
            const row = this.closest('tr');
            const requestId = row.dataset.requestId;
            const action = this.dataset.action;

            try {
                const res = await fetch(
                    `http://127.0.0.1:8000/api/manager/leave_requests/${requestId}/${action}`,
                    {
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${TOKEN}`,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({})
                    }
                );

                const data = await res.json();

                if (res.ok && data.success) {
                    showToast(`Request ${action}d successfully!`);
                    loadPendingRequests(); // Refresh
                    loadDashboardSummary();
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

// ================================
// Initialize dashboard
// ================================
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('currentDate').textContent =
        new Date().toLocaleDateString('en-US', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
        });

    // ✅ Load both requests and summary once
    loadPendingRequests();
    loadDashboardSummary();
});

// Animate number change in summary cards
function animateCounter(element, newValue) {
    const duration = 500; // animation duration in ms
    const frameRate = 30; // frames per second
    const totalFrames = Math.round(duration / (1000 / frameRate));

    let startValue = parseInt(element.textContent) || 0;
    let frame = 0;

    const counter = setInterval(() => {
        frame++;
        const progress = frame / totalFrames;
        const currentValue = Math.round(startValue + (newValue - startValue) * progress);
        element.textContent = currentValue;

        if (frame === totalFrames) {
            clearInterval(counter);
        }
    }, 1000 / frameRate);
}

async function loadDashboardSummary() {
    try {
        const res = await fetch('http://127.0.0.1:8000/api/manager/dashboard-summary', {
            headers: {
                'Authorization': `Bearer ${TOKEN}`,
                'Accept': 'application/json'
            }
        });

        const data = await res.json();

        if (!res.ok || data.success === false) {
            showToast(data?.message || "Error loading dashboard summary", "error");
            return;
        }

        const summary = data; // ✅ Your API already returns plain object

        animateCounter(document.getElementById('totalEmployees'), summary.total_employees);
        animateCounter(document.getElementById('pendingRequests'), summary.pending_requests);
        animateCounter(document.getElementById('approvedRequests'), summary.approved_this_month);
        animateCounter(document.getElementById('rejectedRequests'), summary.rejected_this_month);

    } catch (err) {
        console.error("Error loading summary:", err);
        showToast("Network error while loading summary", "error");
    }
}

</script>
</body>
</html>
