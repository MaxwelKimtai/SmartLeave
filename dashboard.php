<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Leave Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/dashboard.css?v=<?php echo time(); ?>">  
 </head>
<body>
    <div class="background-overlay"></div> <div class="dashboard-container">
        <main class="main-content">
            <header class="main-header">
                <div class="header-left">
                    <div class="header-logo-text">LeaveFlow</div> <nav class="floating-nav">
                        <ul>
                            <li class="active"><a href="#"><i class="fas fa-th-large"></i> Dashboard</a></li>
                            <li><a href="#"><i class="fas fa-calendar-plus"></i> Apply Leave</a></li>
                            <li><a href="#"><i class="fas fa-history"></i> Leave History</a></li>
                            <li><a href="#"><i class="fas fa-bell"></i> Notifications <span class="nav-badge">3</span></a></li>
                        </ul>
                    </nav>
                </div>
                <div class="header-right">
                    <div class="search-bar">
                        <input type="text" placeholder="Search...">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="user-profile-summary">
                        <div class="user-info-text">
                            <p class="user-name">Maxwel Kimtai</p>
                            <p class="user-role-header">Employee</p>
                        </div>
                        <img src="https://via.placeholder.com/35x35?text=MX" alt="User Avatar" class="user-avatar-small">
                    </div>
                    <a href="#" class="logout-icon-button" title="Logout"><i class="fas fa-sign-out-alt"></i></a>
                </div>
            </header>

            <section class="dashboard-grid">

                <div class="grid-item stat-card remaining-leave">
                    <div class="stat-icon-wrap yellow-bg"><i class="fas fa-calendar-day"></i></div>
                    <p class="stat-title">Remaining Leave</p>
                    <p class="stat-value">15 Days</p>
                </div>
                <div class="grid-item stat-card leave-requests-pending">
                    <div class="stat-icon-wrap blue-bg"><i class="fas fa-clock"></i></div>
                    <p class="stat-title">Requests Pending</p>
                    <p class="stat-value">2</p>
                </div>
                 <div class="grid-item stat-card next-meeting">
                    <div class="stat-icon-wrap purple-bg"><i class="fas fa-comments"></i></div>
                    <p class="stat-title">Next Meeting</p>
                    <p class="stat-value">2:00 PM (Team Sync)</p>
                </div>

                <div class="grid-item card monthly-leave-usage">
                    <div class="card-header">
                        <h3 class="card-title">Monthly Leave Usage</h3>
                        <div class="card-actions">
                            <span class="view-all-link">View statistics for all time</span>
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                    <div class="chart-area">
                        <img src="https://via.placeholder.com/600x200/F0F2F5/A0A3A6?text=Leave+Usage+Chart" alt="Monthly Leave Usage Chart" style="width:100%; height:auto; border-radius:10px;">
                        </div>
                </div>

                <div class="grid-item card leave-balance-breakdown">
                     <div class="card-header">
                        <h3 class="card-title">Leave Balance</h3>
                        <select class="filter-dropdown">
                            <option>Annual</option>
                            <option>Sick</option>
                            <option>Casual</option>
                            <option>Emergency</option>
                        </select>
                    </div>
                    <div class="balance-chart-summary">
                        <div class="total-balance">
                            <p class="total-value">20</p>
                            <p class="total-label">Total Days</p>
                        </div>
                        <ul class="balance-list">
                            <li><span class="dot annual"></span> Annual: 10 Days</li>
                            <li><span class="dot sick"></span> Sick: 5 Days</li>
                            <li><span class="dot casual"></span> Casual: 3 Days</li>
                            <li><span class="dot emergency"></span> Emergency: 2 Days</li>
                        </ul>
                    </div>
                </div>

                <div class="grid-item card recent-leave-applications">
                    <div class="card-header">
                        <h3 class="card-title">Recent Leave Applications</h3>
                        <a href="#" class="view-all-link">See All</a>
                    </div>
                    <ul class="application-list">
                        <li>
                            <div class="app-details">
                                <p class="app-name">Annual Leave (5 days)</p>
                                <span class="app-date">Submitted on Jul 25, 2025</span>
                            </div>
                            <span class="app-status pending">Pending</span>
                        </li>
                        <li>
                            <div class="app-details">
                                <p class="app-name">Sick Leave (1 day)</p>
                                <span class="app-date">Submitted on Jul 20, 2025</span>
                            </div>
                            <span class="app-status approved">Approved</span>
                        </li>
                        <li>
                            <div class="app-details">
                                <p class="app-name">Casual Leave (2 days)</p>
                                <span class="app-date">Submitted on Jul 18, 2025</span>
                            </div>
                            <span class="app-status approved">Approved</span>
                        </li>
                        <li>
                            <div class="app-details">
                                <p class="app-name">Emergency Leave (1 day)</p>
                                <span class="app-date">Submitted on Jul 10, 2025</span>
                            </div>
                            <span class="app-status rejected">Rejected</span>
                        </li>
                    </ul>
                </div>

                 <div class="grid-item card upcoming-holidays">
                     <div class="card-header">
                        <h3 class="card-title">Upcoming Holidays</h3>
                        <a href="#" class="view-all-link">Full Calendar</a>
                    </div>
                    <ul class="holiday-list">
                        <li>
                            <div class="holiday-date">Aug 15</div>
                            <div class="holiday-name">National Heroes' Day</div>
                        </li>
                        <li>
                            <div class="holiday-date">Sep 01</div>
                            <div class="holiday-name">Labor Day</div>
                        </li>
                        <li>
                            <div class="holiday-date">Oct 20</div>
                            <div class="holiday-name">Mashujaa Day</div>
                        </li>
                    </ul>
                </div>

            </section>
        </main>
    </div>
</body>
</html>