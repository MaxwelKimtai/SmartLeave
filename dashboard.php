<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="logo">
                <i class="fas fa-home"></i> SMART LEAVE
            </div>
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search policies, colleagues...">
            </div>
            <nav class="main-nav">
                <h3 class="nav-section-title">Main Navigation</h3>
                <ul>
                    <li class="active"><a href="#"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                    <li><a href="#"><i class="fas fa-calendar-plus"></i> Request Leave</a></li>
                    <li><a href="#"><i class="fas fa-history"></i> My Leave History</a></li>
                    <li><a href="#"><i class="fas fa-book"></i> Leave Policies</a></li>
                    <li><a href="#"><i class="fas fa-users-viewfinder"></i> Team Calendar</a></li>
                    <li><a href="#"><i class="fas fa-user-circle"></i> My Profile</a></li>
                </ul>
            </nav>

            <div class="nav-section quick-links">
                <h3 class="nav-section-title">Quick Links</h3>
                <ul>
                    <li><a href="#"><i class="fas fa-calendar-alt"></i> Holiday Calendar</a></li>
                    <li><a href="#"><i class="fas fa-headset"></i> Contact HR</a></li>
                </ul>
            </div>

            <div class="user-profile">
                <img src="/assets/profile.png"  class="profile-pic">
                <div class="user-info">
                    <div class="user-name">Maxwel</div>
                    <div class="user-role">Employee</div>
                </div>
                <i class="fas fa-bell notification-icon"></i>
            </div>
        </aside>

     <main class="main-content">
    <header class="main-header">
        <div class="header-left">
            <span class="breadcrumbs">Home / My Leave Dashboard</span>
            <h1>Good Morning</h1>
            <p class="date">It's Tuesday, July 29 2025</p>
        </div>
        <a href="request_leave.php" class="request-new-leave-button">
            <i class="fas fa-plus"></i> Request New Leave
        </a>
        </header>

            <section class="metrics-grid">
                <div class="metric-card">
                    <i class="fas fa-calendar-alt metric-icon"></i>
                    <span class="metric-value">12 Days</span>
                    <span class="metric-label">Annual Leave Balance</span>
                </div>
                <div class="metric-card">
                    <i class="fas fa-hospital-user metric-icon"></i>
                    <span class="metric-value">5 Days</span>
                    <span class="metric-label">Sick Leave Balance</span>
                </div>
                <div class="metric-card">
                    <i class="fas fa-briefcase metric-icon"></i>
                    <span class="metric-value">3 Days</span>
                    <span class="metric-label">Casual Leave Balance</span>
                </div>
                <div class="metric-card">
                    <i class="fas fa-sign-out-alt metric-icon"></i>
                    <span class="metric-value">7 Days</span>
                    <span class="metric-label">Leaves Taken This Year</span>
                </div>
            </section>

            <section class="middle-row-grid">
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
                    </div>
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
                        <div class="request-item no-pending-requests" style="display: none;">
                            <p>No pending leave requests at the moment.</p>
                        </div>
                    </div>
                    <div class="request-summary-chart">
                        <img src="https://via.placeholder.com/200x100/f0f0f0/888888?text=Leave+Status+Chart" alt="Leave Status Chart" class="chart-placeholder">
                    </div>
                </div>

                <div class="right-column-stack">
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
                    </div>

                    <div class="card recent-history-card">
                        <div class="card-header">
                            <span>My Recent Leave History</span>
                            <i class="fas fa-ellipsis-h"></i>
                        </div>
                        <div class="history-list">
                            <div class="history-item">
                                <span class="history-details">Annual Leave: Oct 10 - Oct 12, 2024</span>
                                <span class="history-status approved-status">Approved</span>
                            </div>
                            <div class="history-item">
                                <span class="history-details">Sick Leave: Sep 5, 2024</span>
                                <span class="history-status approved-status">Approved</span>
                            </div>
                            <div class="history-item">
                                <span class="history-details">Casual Leave: Aug 1, 2024</span>
                                <span class="history-status approved-status">Approved</span>
                            </div>
                            <div class="history-item">
                                <span class="history-details">Annual Leave: May 15 - May 17, 2024</span>
                                <span class="history-status approved-status">Approved</span>
                            </div>
                        </div>
                        <button class="view-full-history-button">View Full History</button>
                    </div>
                </div>
            </section>

            <section class="card policies-announcements-card">
                <div class="card-header policies-header">
                    <h2>Company Leave Policies & Announcements</h2>
                    <div class="search-policy">
                        <input type="text" placeholder="Search policies...">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
                <div class="policy-list">
                    <div class="policy-item">
                        <i class="fas fa-file-alt"></i>
                        <a href="#">Annual Leave Policy Guidelines 2024</a>
                        <span class="policy-date">Updated: Jan 1, 2024</span>
                    </div>
                    <div class="policy-item">
                        <i class="fas fa-file-alt"></i>
                        <a href="#">Sick Leave & Medical Certificate Requirements</a>
                        <span class="policy-date">Updated: Feb 15, 2024</span>
                    </div>
                    <div class="policy-item">
                        <i class="fas fa-file-alt"></i>
                        <a href="#">Parental & Bereavement Leave Policies</a>
                        <span class="policy-date">Updated: Mar 10, 2024</span>
                    </div>
                    <div class="policy-item">
                        <i class="fas fa-bullhorn"></i>
                        <a href="#">Upcoming Public Holidays & Office Closures</a>
                        <span class="policy-date announcement-tag">Announcement: Nov 1, 2024</span>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>