<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Leave Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css' rel='stylesheet' />
</head>
<body>
    <div class="dashboard-container">
        <aside class="left-panel">
            <div class="logo">
                <i class="fas fa-home"></i> SMART LEAVE
            </div>
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search policies...">
            </div>
            <nav class="main-nav">
                <h3 class="nav-section-title">MAIN NAVIGATION</h3>
                <ul>
                    <li class="active"><a href="#"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                    <li><a href="#"><i class="fas fa-calendar-plus"></i> Request Leave</a></li>
                    <li><a href="#"><i class="fas fa-history"></i> My Leave History</a></li>
                    <li><a href="#"><i class="fas fa-book"></i> Leave Policies</a></li>
                    <li><a href="#"><i class="fas fa-users"></i> Team Calendar</a></li>
                    <li><a href="#"><i class="fas fa-user-circle"></i> My Profile</a></li>
                </ul>
            </nav>

            <!-- ✅ User Profile -->
<div class="user-profile">
    <img src="assets/profile.png" alt="User Profile" class="profile-pic" id="profilePic">
    <div class="user-info">
        <div class="user-name" id="userName">
            <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Guest'); ?>
        </div>
        <div class="user-role" id="userRole">
            <?php echo ucfirst($_SESSION['user_role'] ?? 'employee'); ?>
        </div>
    </div>
    <i class="fas fa-bell notification-icon"></i>
</div>
            <button class="logout-button" id="logoutButton">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <div class="header-left">
                    <span class="breadcrumbs">Home / My Leave Dashboard</span>
                    <h1 id="greeting">Good Morning</h1>
                    <p class="date">It's Wednesday, July 30, 2025</p>
                </div>
                <a href="request_leave.php" class="request-new-leave-button">
                    <i class="fas fa-plus"></i> Request New Leave
                </a>
            </header>

           <section class="metrics-grid">
    <div class="metric-card" data-leave-type="Annual Leave">
        <i class="fas fa-calendar-alt metric-icon"></i>
        <span class="metric-value">0 Days</span>
        <span class="metric-label">Annual Leave Balance</span>
    </div>
    <div class="metric-card" data-leave-type="Sick Leave">
        <i class="fas fa-hospital-user metric-icon"></i>
        <span class="metric-value">0 Days</span>
        <span class="metric-label">Sick Leave Balance</span>
    </div>
    <div class="metric-card" data-leave-type="Casual Leave">
        <i class="fas fa-briefcase metric-icon"></i>
        <span class="metric-value">0 Days</span>
        <span class="metric-label">Casual Leave Balance</span>
    </div>
    <div class="metric-card" id="leaves-taken-this-year">
        <i class="fas fa-sign-out-alt metric-icon"></i>
        <span class="metric-value">0 Days</span>
        <span class="metric-label">Leaves Taken This Year</span>
    </div>
</section>


            <section class="bottom-row-grid">
                <div class="card upcoming-leaves-card">
                    <div class="card-header">
                        <span>My Upcoming Leaves</span>
                        <span class="date-filter"><i class="far fa-calendar-alt"></i> This Month <i class="fas fa-chevron-down"></i></span>
                    </div>
                    <div class="leave-list">
                        <div class="leave-item">
                            <div class="leave-details">
                                <span class="item-title">Annual Leave: Nov 20 - Nov 25, 2024</span>
                                <span class="item-status approved-status">Approved</span>
                            </div>
                            <i class="fas fa-ellipsis-h leave-options"></i>
                        </div>
                        <div class="leave-item">
                            <div class="leave-details">
                                <span class="item-title">Sick Leave: Dec 1 - Dec 1, 2024</span>
                                <span class="item-status approved-status">Approved</span>
                            </div>
                            <i class="fas fa-ellipsis-h leave-options"></i>
                        </div>
                        <div class="leave-item">
                            <div class="leave-details">
                                <span class="item-title">Casual Leave: Jan 5 - Jan 5, 2025</span>
                                <span class="item-status approved-status">Approved</span>
                            </div>
                            <i class="fas fa-ellipsis-h leave-options"></i>
                        </div>
                        <div class="leave-item">
                            <div class="leave-details">
                                <span class="item-title">Annual Leave: Feb 10 - Feb 15, 2025</span>
                                <span class="item-status approved-status">Approved</span>
                            </div>
                            <i class="fas fa-ellipsis-h leave-options"></i>
                        </div>
                        <div class="leave-item">
                            <div class="leave-details">
                                <span class="item-title">Sick Leave: Mar 3 - Mar 3, 2025</span>
                                <span class="item-status approved-status">Approved</span>
                            </div>
                            <i class="fas fa-ellipsis-h leave-options"></i>
                        </div>
                        <div class="leave-item">
                            <div class="leave-details">
                                <span class="item-title">Casual Leave: Apr 1 - Apr 1, 2025</span>
                                <span class="item-status approved-status">Approved</span>
                            </div>
                            <i class="fas fa-ellipsis-h leave-options"></i>
                        </div>
                    </div>
                </div>

                <div class="card calendar-card">
                    <div id="fullcalendar" style="width: 100%; height: 100%;"></div> 
                </div>

                <div class="card pending-requests-card">
                    <div class="card-header">
                        <span>Pending Leave Requests</span>
                        <i class="fas fa-ellipsis-h"></i>
                    </div>
                    <div class="request-list">
                        <div class="request-item">
                            <span class="request-title">Annual Leave: Jan 5 - Jan 10, 2025</span>
                            <span class="request-status pending-status">Pending Approval</span>
                            <div class="request-actions">
                                <button class="view-details-button">View Details</button>
                                <button class="cancel-request-button">Cancel Request</button>
                            </div>
                        </div>
                        <div class="request-item">
                            <span class="request-title">Sick Leave: Feb 1 - Feb 2, 2025</span>
                            <span class="request-status pending-status">Pending Approval</span>
                            <div class="request-actions">
                                <button class="view-details-button">View Details</button>
                                <button class="cancel-request-button">Cancel Request</button>
                            </div>
                        </div>
                        <div class="request-item no-pending-requests" style="display: none;">
                            <p>No pending leave requests at the moment.</p>
                        </div>
                    </div>
                </div>

               <div class="card detailed-balances-card">
                    <div class="card-header">
                        <span>Detailed Leave Balances</span>
                        <i class="fas fa-ellipsis-h"></i>
                    </div>
                    <div class="balance-item">
                        <span class="balance-type">Annual Leave</span>
                        <div class="balance-numbers">
                            <span class="entitlement">Entitlement: 15</span>
                            <span class="taken">Taken: 3</span>
                            <span class="remaining">Remaining: 12</span>
                        </div>
                    </div>
                    <div class="balance-item">
                        <span class="balance-type">Sick Leave</span>
                        <div class="balance-numbers">
                            <span class="entitlement">Entitlement: 10</span>
                            <span class="taken">Taken: 5</span>
                            <span class="remaining">Remaining: 5</span>
                        </div>
                        </div>
                    <div class="balance-item">
                        <span class="balance-type">Casual Leave</span>
                        <div class="balance-numbers">
                            <span class="entitlement">Entitlement: 5</span>
                            <span class="taken">Taken: 2</span>
                            <span class="remaining">Remaining: 3</span>
                        </div>
                    </div>
                    <div class="balance-item">
                        <span class="balance-type">Maternity Leave</span>
                        <div class="balance-numbers">
                            <span class="entitlement">Entitlement: 90</span>
                            <span class="taken">Taken: 0</span>
                            <span class="remaining">Remaining: 90</span>
                        </div>
                    </div>
                    <div class="balance-item">
                        <span class="balance-type">Paternity Leave</span>
                        <div class="balance-numbers">
                            <span class="entitlement">Entitlement: 7</span>
                            <span class="taken">Taken: 0</span>
                            <span class="remaining">Remaining: 7</span>
                        </div>
                    </div>
                    <div class="balance-item">
                        <span class="balance-type">Compassionate Leave</span>
                        <div class="balance-numbers">
                            <span class="entitlement">Entitlement: 5</span>
                            <span class="taken">Taken: 0</span>
                            <span class="remaining">Remaining: 5</span>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    // ✅ Protect the page
    const token = sessionStorage.getItem('api_token');
    const name  = sessionStorage.getItem('user_name');
    const role  = sessionStorage.getItem('user_role');

    if (!token) {
        window.location.href = "login.php";
        return;
    }

    // ✅ Update UI
    document.getElementById('userName').textContent = name || "Unknown";
    document.getElementById('userRole').textContent = role || "";
    // Determine greeting based on current hour
const now = new Date();
const hour = now.getHours();
let greetingText;

if (hour < 12) {
    greetingText = 'Good Morning';
} else if (hour < 18) {
    greetingText = 'Good Afternoon';
} else {
    greetingText = 'Good Evening';
}

// Update greeting with username
document.getElementById('greeting').textContent = `${greetingText}, ${name}!`;


    // ✅ Dynamic date
    const today = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    document.querySelector('.main-header .date').textContent =
        `It's ${today.toLocaleDateString('en-US', options)}`;

    // ✅ Logout
    document.getElementById('logoutButton').addEventListener('click', () => {
        sessionStorage.clear();
        window.location.href = "login.php";
    });
    
            
        // --- FullCalendar Initialization ---
            const calendarEl = document.getElementById('fullcalendar');
            if (calendarEl) {
                console.log('FullCalendar element found. Initializing calendar.');
                try {
                    const calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth', // Monthly view
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth' // Only month view button
                        },
                        // Customize button text (optional)
                        buttonText: {
                            today: 'Today',
                            month: 'Month',
                            week: 'Week',
                            day: 'Day'
                        },
                        // Events (example events from your upcoming leaves)
                        events: [
                            {
                                title: 'Annual Leave',
                                start: '2024-11-20',
                                end: '2024-11-26', // FullCalendar end is exclusive, so +1 day
                                color: '#FFC107', // Yellow background for event
                                textColor: '#333333' // Dark text for readability
                            },
                            {
                                title: 'Sick Leave',
                                start: '2024-12-01',
                                end: '2024-12-02', // +1 day
                                color: '#FFC107',
                                textColor: '#333333'
                            },
                            {
                                title: 'Casual Leave',
                                start: '2025-01-05',
                                end: '2025-01-06', // +1 day
                                color: '#FFC107',
                                textColor: '#333333'
                            },
                            {
                                title: 'Annual Leave',
                                start: '2025-02-10',
                                end: '2025-02-16', // +1 day
                                color: '#FFC107',
                                textColor: '#333333'
                            },
                            {
                                title: 'Sick Leave',
                                start: '2025-03-03',
                                end: '2025-03-04', // +1 day
                                color: '#FFC107',
                                textColor: '#333333'
                            }
                        ],
                        // Customizing rendering
                        eventDidMount: function(info) {
                            // Example: Add a custom class to all events
                            info.el.classList.add('my-custom-event'); 
                        }
                    });
                    calendar.render(); // This is crucial for FullCalendar to display
                    console.log('FullCalendar initialized and rendered successfully.');
                } catch (error) {
                    console.error('Error initializing FullCalendar:', error);
                }
            } else {
                console.warn('FullCalendar element with ID "fullcalendar" not found!');
            }
        });


async function loadMyLeaveRequests() {
    const token = sessionStorage.getItem("api_token");

    try {
        const res = await fetch("http://127.0.0.1:8000/api/employee/my_leave_requests", {
            headers: {
                "Authorization": `Bearer ${token}`,
                "Accept": "application/json"
            }
        });

        const data = await res.json();

        if (!res.ok || !data.success) {
            console.error("Error fetching leave requests:", data);
            return;
        }

        // Render into dashboard
        renderPendingRequests(data.pending);
        renderUpcomingLeaves(data.upcoming);
        renderLeaveHistory(data.history);
        
                // ✅ Populate balances dynamically
        if (data.balances) {
            renderLeaveBalances(data.balances);
        }


    } catch (err) {
        console.error("Network error fetching leave requests:", err);
    }
}

// Render PENDING
function renderPendingRequests(pending) {
    const container = document.querySelector(".pending-requests-card .request-list");
    container.innerHTML = ""; // clear

    if (pending.length === 0) {
        container.innerHTML = `<div class="request-item"><p>No pending leave requests.</p></div>`;
        return;
    }

    pending.forEach(req => {
        const item = document.createElement("div");
        item.className = "request-item";
        item.innerHTML = `
            <span class="request-title">${req.leave_type}: ${req.start_date} - ${req.end_date}</span>
            <span class="request-status pending-status">Pending Approval</span>
            <div class="request-actions">
                <button class="view-details-button">View Details</button>
                <button class="cancel-request-button">Cancel Request</button>
            </div>
        `;
        container.appendChild(item);
    });
}

// Render UPCOMING
function renderUpcomingLeaves(upcoming) {
    const container = document.querySelector('.upcoming-leaves-card .leave-list'); // ✅ declare it
    container.innerHTML = '';

    if (!upcoming || upcoming.length === 0) {
        const placeholder = document.createElement('div');
        placeholder.className = 'leave-item no-upcoming';
        placeholder.innerHTML = `
            <div class="leave-details">
                <p>No upcoming approved leaves.</p>
            </div>
            <i class="fas fa-ellipsis-h leave-options" style="visibility:hidden;"></i>
        `;
        container.appendChild(placeholder);
        return;
    }

    upcoming.forEach(req => {
        const item = document.createElement('div');
        item.className = 'leave-item';
        item.innerHTML = `
            <div class="leave-details">
                <span class="item-title">${req.leave_type}: ${req.start_date} - ${req.end_date}</span>
                <span class="item-status approved-status">Approved</span>
            </div>
            <i class="fas fa-ellipsis-h leave-options"></i>
        `;
        container.appendChild(item);
    });
}


// Render HISTORY
function renderLeaveHistory(history) {
    const container = document.querySelector(".leave-history-card .request-list");
    container.innerHTML = "";

    if (history.length === 0) {
        container.innerHTML = `<div class="request-item"><p>No leave history yet.</p></div>`;
        return;
    }

    history.forEach(req => {
        const item = document.createElement("div");
        item.className = "request-item";
        const statusClass = req.status === "approved" ? "approved-status" : "rejected-status";
        item.innerHTML = `
            <span class="request-title">${req.leave_type}: ${req.start_date} - ${req.end_date}</span>
            <span class="request-status ${statusClass}">${req.status}</span>
        `;
        container.appendChild(item);
    });
}
// Define fixed entitlements for each leave type
const leaveEntitlements = {
    "Casual Leave": 5,
    "Sick Leave": 10,
    "Annual Leave": 15,
    "Maternity Leave": 90,
    "Paternity Leave": 7,
    "Compassionate Leave": 5
};

function renderLeaveBalances(balances) {
    const container = document.querySelector(".detailed-balances-card");
    
    // Remove old balance items (keep the header)
    container.querySelectorAll(".balance-item").forEach(item => item.remove());

    balances.forEach(policy => {
        const remaining = policy.remaining_days ?? 0;
        const entitlement = leaveEntitlements[policy.leave_type] ?? remaining;
        const taken = entitlement - remaining;

        const item = document.createElement("div");
        item.className = "balance-item";
        item.innerHTML = `
            <span class="balance-type">${policy.leave_type}</span>
            <div class="balance-numbers">
                <span class="entitlement">Entitlement: ${entitlement}</span>
                <span class="taken">Taken: ${taken}</span>
                <span class="remaining">Remaining: ${remaining}</span>
            </div>
        `;
        container.appendChild(item);
    });
}

function updateMetricsGrid(balances) {
    // Update each leave type card
    balances.forEach(policy => {
        const card = document.querySelector(`.metric-card[data-leave-type="${policy.leave_type}"]`);
        if (card) {
            card.querySelector(".metric-value").textContent = `${policy.remaining_days} Days`;
        }
    });

    // Optional: calculate total leaves taken this year
    const totalTaken = balances.reduce((sum, policy) => {
        const entitlement = leaveEntitlements[policy.leave_type] ?? policy.remaining_days;
        const taken = entitlement - policy.remaining_days;
        return sum + taken;
    }, 0);

    document.getElementById("leaves-taken-this-year")
        .querySelector(".metric-value").textContent = `${totalTaken} Days`;
}


// Fetch employee-specific leave balances
async function loadLeaveBalances() {
    const token = sessionStorage.getItem("api_token");

    try {
        const res = await fetch("http://127.0.0.1:8000/api/employee/leave_balances", {
            headers: {
                "Authorization": `Bearer ${token}`,
                "Accept": "application/json"
            }
        });

        const data = await res.json();

        if (!data.success) { 
            console.error("Error fetching leave balances:", data);
            return;
        }

        // Render dynamically in the detailed balances card
        renderLeaveBalances(data.balances);
        updateMetricsGrid(data.balances);

    } catch (err) {
        console.error("Network error fetching leave balances:", err);
    }
}


document.addEventListener("DOMContentLoaded", () => {
    loadMyLeaveRequests(); // fetch pending/upcoming/history
    loadLeaveBalances();   // fetch dynamic balances
});
            // ✅ PHP to JS Session Storage
            // This part remains correct, ensuring PHP session data is transferred to sessionStorage.
            <?php if (isset($_SESSION['api_token'])): ?>
                sessionStorage.setItem('api_token', <?php echo json_encode($_SESSION['api_token']); ?>);
                sessionStorage.setItem('user_name', <?php echo json_encode($_SESSION['user_name'] ?? 'Guest'); ?>);
                sessionStorage.setItem('user_role', <?php echo json_encode($_SESSION['user_role'] ?? 'employee'); ?>);
            <?php endif; ?>

    </script>
</body>
</html>