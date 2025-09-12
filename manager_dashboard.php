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
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="logo">
                <img src="assets/logo.png" alt="Homies Lab Logo"> <!-- Adjust path to your logo -->
                <span>SMART LEAVE</span>
            </div>
            <nav class="main-nav">
                <ul>
                    <li class="nav-item active">
                        <a href="#"><i class="fas fa-th-large"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="#"><i class="fas fa-calendar-check"></i> Manage Leaves</a>
                    </li>
                    <li class="nav-item">
                        <a href="#"><i class="fas fa-users"></i> Employees</a>
                    </li>
                    <li class="nav-item">
                        <a href="#"><i class="fas fa-chart-line"></i> Reports</a>
                    </li>
                    <li class="nav-item">
                        <a href="#"><i class="fas fa-cog"></i> Settings</a>
                    </li>
                </ul>
            </nav>
            <div class="logout-section">
                <a href="#" class="logout-button"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <header class="top-header">
                <div class="greeting">
                    <h1>Good Morning, Manager!</h1>
                    <p id="currentDate"></p>
                </div>
                <div class="user-profile">
                    <!-- Placeholder for user image/avatar -->
                    <img src="https://placehold.co/40x40/FFC107/333333?text=M" alt="Manager Avatar" class="avatar">
                    <span class="user-name">Manager</span>
                    <i class="fas fa-bell notification-icon"></i>
                </div>
            </header>

            <!-- Dashboard Summary Cards -->
            <section class="dashboard-summary">
                <div class="summary-card">
                    <div class="card-icon"><i class="fas fa-users"></i></div>
                    <div class="card-info">
                        <h3>85</h3>
                        <p>Total Employees</p>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="card-icon"><i class="fas fa-hourglass-half"></i></div>
                    <div class="card-info">
                        <h3>1</h3>
                        <p>Pending Requests</p>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="card-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="card-info">
                        <h3>29</h3>
                        <p>Approved This Month</p>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="card-icon"><i class="fas fa-times-circle"></i></div>
                    <div class="card-info">
                        <h3>3</h3>
                        <p>Rejected This Month</p>
                    </div>
                </div>
            </section>

            <!-- Pending Leave Requests Table -->
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
                            <!-- Dummy Data -->
                            <tr data-request-id="1">
                                <td>Jane Smith</td>
                                <td>Sick Leave</td>
                                <td>2025-08-01</td>
                                <td>2025-08-03</td>
                                <td>3</td>
                                <td>Fever and flu</td>
                                <td class="actions">
                                    <button class="action-button approve-button" data-action="approve"><i class="fas fa-check"></i> Approve</button>
                                    <button class="action-button reject-button" data-action="reject"><i class="fas fa-times"></i> Reject</button>
                                </td>
                            </tr>
                            <tr data-request-id="2">
                                <td>Maxwel Kimtai</td>
                                <td>Casual Leave</td>
                                <td>2025-08-08</td>
                                <td>2025-08-31</td>
                                <td>16</td>
                                <td>Family vacation</td>
                                <td class="actions">
                                    <button class="action-button approve-button" data-action="approve"><i class="fas fa-check"></i> Approve</button>
                                    <button class="action-button reject-button" data-action="reject"><i class="fas fa-times"></i> Reject</button>
                                </td>
                            </tr>
                             <tr data-request-id="3">
                                <td>Emily White</td>
                                <td>Bereavement</td>
                                <td>2025-08-05</td>
                                <td>2025-08-07</td>
                                <td>3</td>
                                <td>Family emergency</td>
                                <td class="actions">
                                    <button class="action-button approve-button" data-action="approve"><i class="fas fa-check"></i> Approve</button>
                                    <button class="action-button reject-button" data-action="reject"><i class="fas fa-times"></i> Reject</button>
                                </td>
                            </tr>
                             <tr data-request-id="4">
                                <td>David Green</td>
                                <td>Casual Leave</td>
                                <td>2025-08-12</td>
                                <td>2025-08-12</td>
                                <td>1</td>
                                <td>Personal appointment</td>
                                <td class="actions">
                                    <button class="action-button approve-button" data-action="approve"><i class="fas fa-check"></i> Approve</button>
                                    <button class="action-button reject-button" data-action="reject"><i class="fas fa-times"></i> Reject</button>
                                </td>
                            </tr>
                            <!-- Add more rows as needed to test scrolling -->
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <!-- Toast Notification Area -->
    <div id="toast-container"></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Display current date
            const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('currentDate').textContent = new Date().toLocaleDateString('en-US', dateOptions);

            const toastContainer = document.getElementById('toast-container');

            // --- Toast Notification Functionality ---
            const showToast = (message, type = 'success') => {
                const toast = document.createElement('div');
                toast.classList.add('toast', type);
                toast.textContent = message;
                toastContainer.appendChild(toast);

                void toast.offsetWidth; // Trigger reflow for CSS transition
                toast.classList.add('show');

                setTimeout(() => {
                    toast.classList.remove('show');
                    toast.classList.add('hide');
                    toast.addEventListener('transitionend', () => {
                        toast.remove();
                    }, { once: true });
                }, 3000);
            };

            // --- Handle Approve/Reject Actions ---
            document.querySelectorAll('.action-button').forEach(button => {
                button.addEventListener('click', (event) => {
                    const row = event.target.closest('tr');
                    const requestId = row.dataset.requestId;
                    const action = event.target.dataset.action;
                    const employeeName = row.querySelector('td:first-child').textContent;

                    // In a real application, you would send an AJAX request to your backend
                    // to update the leave status in the database.
                    console.log(`Request ID: ${requestId}, Action: ${action}`);

                    // Simulate backend response
                    const success = Math.random() > 0.2; // 80% success rate for demo

                    if (success) {
                        showToast(`Leave request for ${employeeName} ${action}ed successfully!`, 'success');
                        row.remove(); // Remove the row from the table on success
                    } else {
                        showToast(`Failed to ${action} leave request for ${employeeName}. Please try again.`, 'error');
                    }
                });
            });
        });
    </script>
</body>
</html>