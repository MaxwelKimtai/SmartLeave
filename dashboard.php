<?php
// dashboard.php - This file contains the HTML structure and dynamic content for the simplified Employee Leave Dashboard.
// In a real application, user data and leave data would be fetched from a database or API.

// Simulating a logged-in user for demonstration purposes.
$loggedInUserName = "Max";
$userRole = "Employee"; // Or "Manager" depending on the user
$userAvatarInitials = implode('', array_map(function($n) { return $n[0]; }, explode(' ', $loggedInUserName)));
$userAvatarInitials = strtoupper($userAvatarInitials);

// Simulate dynamic date
$currentDate = date("l, d F Y"); // e.g., "Wednesday, 11 November 2024"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Leave Dashboard</title>
    <!-- Inter font from Google Fonts for a modern look -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Tailwind CSS CDN for basic utility classes (most styling is in dashboard.css) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Link to your custom dashboard.css for styling -->
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <!-- Background overlay to subtly tint the background image for better readability -->
    <div class="background-overlay"></div>

    <div class="dashboard-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-logo">SMART LEAVE</div>
            <div class="sidebar-search">
                <input type="text" placeholder="Search leave requests...">
                <i class="fas fa-search"></i>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="#" class="active"><i class="fas fa-th-large"></i> Dashboard</a></li>
                    <li><a href="#"><i class="fas fa-calendar-plus"></i> Apply Leave</a></li>
                    <li><a href="#"><i class="fas fa-history"></i> Leave History</a></li>
                    <li><a href="#"><i class="fas fa-calendar-alt"></i> Team Leave Calendar</a></li>
                    <!-- Optional: For Managers/Admins -->
                    <!-- <li><a href="#"><i class="fas fa-check-circle"></i> Leave Approvals</a></li> -->
                    <li><a href="#"><i class="fas fa-bell"></i> Notifications <span class="nav-badge">3</span></a></li>
                </ul>
            </nav>

            <!-- User Profile Summary at the bottom of the sidebar -->
            <div class="sidebar-user-profile">
                <img src="https://via.placeholder.com/48x48?text=<?php echo $userAvatarInitials; ?>" alt="User Avatar" class="sidebar-user-avatar">
                <div class="sidebar-user-info">
                    <p class="name"><?php echo $loggedInUserName; ?></p>
                    <p class="role"><?php echo $userRole; ?></p>
                </div>
                <a href="#" class="logout-icon-button ml-auto" title="Logout"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <header class="main-header">
                <div class="header-greeting">
                    <h1>Welcome, <?php echo $loggedInUserName; ?></h1>
                    <p>Today is <?php echo $currentDate; ?></p>
                </div>
                <div class="header-right-actions">
                    <a href="#" class="notification-icon-button" title="Notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </a>
                    <div class="user-profile-summary">
                        <div class="user-info-text">
                            <p class="user-name"><?php echo $loggedInUserName; ?></p>
                            <p class="user-role-header"><?php echo $userRole; ?></p>
                        </div>
                        <img src="https://via.placeholder.com/40x40?text=<?php echo $userAvatarInitials; ?>" alt="User Avatar" class="user-avatar-small" id="userAvatar">
                    </div>
                    <a href="#" class="logout-icon-button" title="Logout"><i class="fas fa-sign-out-alt"></i></a>
                </div>
            </header>

            <!-- Dashboard Content Grid - Focused on Leave Management -->
            <section class="dashboard-content-grid">

                <!-- Key Leave Statistics Section -->
                <div class="key-stats-section">
                    <div class="stat-item">
                        <p class="stat-value">15 Days</p>
                        <p class="stat-label">Remaining Leave</p>
                    </div>
                    <div class="stat-item">
                        <p class="stat-value">3</p>
                        <p class="stat-label">Pending Requests</p>
                    </div>
                    <div class="stat-item">
                        <p class="stat-value">5 Days</p>
                        <p class="stat-label">Approved This Month</p>
                    </div>
                    <div class="stat-item">
                        <p class="stat-value">Aug 15-18</p>
                        <p class="stat-label">Your Next Leave</p>
                    </div>
                </div>

                <!-- Leave Balance Breakdown Section -->
                <div class="leave-balance-breakdown-section">
                    <div class="section-header">
                        <h3>Your Leave Balance</h3>
                        <a href="#" class="view-all-link">View Full History <i class="fas fa-chevron-right"></i></a>
                    </div>
                    <div class="balance-summary">
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

                <!-- Recent Leave Applications Section -->
                <div class="recent-leave-applications-section">
                    <div class="section-header">
                        <h3>Your Recent Applications</h3>
                        <a href="#" class="view-all-link">See All <i class="fas fa-chevron-right"></i></a>
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

                <!-- Upcoming Company Holidays Section -->
                <div class="upcoming-holidays-section">
                    <div class="section-header">
                        <h3>Upcoming Holidays</h3>
                        <a href="#" class="view-all-link">Full Calendar <i class="fas fa-chevron-right"></i></a>
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

    <script>
        // JavaScript for dynamic user avatar initials (if not already handled by PHP)
        document.addEventListener('DOMContentLoaded', () => {
            const userAvatarElements = document.querySelectorAll('.user-avatar-small, .sidebar-user-avatar');
            // PHP has already inserted the name, so we just ensure consistency
            userAvatarElements.forEach(avatar => {
                if (!avatar.src.includes("text=")) { // If placeholder not already generated by PHP
                    const name = "<?php echo $loggedInUserName; ?>"; // Get name from PHP
                    const initials = name.split(' ').map(n => n[0]).join('').toUpperCase();
                    avatar.src = `https://via.placeholder.com/40x40?text=${initials}`;
                    avatar.alt = `${name} Avatar`;
                }
            });
        });
    </script>
</body>
</html>
