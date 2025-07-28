<?php
session_start();

// Protect page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Connect to DB (optional: only if you’re querying user details again)
$host = 'localhost';
$db   = 'smart_leave_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    // Optional: fetch full user info if needed
    $stmt = $pdo->prepare("SELECT * FROM employee WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="logo">
                <img src="https://via.placeholder.com/24" alt="Homies Lab Logo"> Homies Lab
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="#" class="nav-item active"><span class="material-icons">dashboard</span> Dashboard</a></li>
                    <li><a href="#" class="nav-item"><span class="material-icons">calendar_today</span> My Leaves</a></li>
                    <li><a href="#" class="nav-item"><span class="material-icons">policy</span> Leave Policy</a></li>
                    <li><a href="#" class="nav-item"><span class="material-icons">group</span> Team</a></li>
                    <li><a href="#" class="nav-item"><span class="material-icons">notifications</span> Announcements</a></li>
                    <li><a href="#" class="nav-item"><span class="material-icons">help_outline</span> Help & Support</a></li>
                </ul>
            </nav>
            <div class="separator"></div>
            <div class="section-title">Quick Actions</div>
            <ul class="sub-nav">
                <li><a href="#" class="nav-item"><span class="material-icons">add_circle_outline</span> Request New Leave</a></li>
                <li><a href="#" class="nav-item"><span class="material-icons">description</span> View Payslips</a></li>
                <li><a href="#" class="nav-item"><span class="material-icons">person_add</span> Update Profile</a></li>
            </ul>

            <div class="current-user">
                <img src="https://via.placeholder.com/40" alt="<?php echo $loggedInEmployeeName; ?>" class="user-avatar">
                <div class="user-info">
                    <div class="user-name"><?php echo $loggedInEmployeeName; ?></div>
                    <div class="user-role">Employee</div> </div>
                <span class="material-icons">more_vert</span>
            </div>
        </aside>

        <main class="main-content">
            <header class="dashboard-header">
                <div class="breadcrumb">Home / My Dashboard</div>
                <div class="header-right">
                    <span class="material-icons search-icon">search</span>
                    <input type="text" placeholder="Search here" class="search-input">
                    <span class="material-icons notification-icon">notifications</span>
                </div>
            </header>

            <div class="greeting-section">
                <h1>Good Morning, <?php echo $loggedInEmployeeName; ?></h1>
                <p>It's <?php echo date('l, d F Y'); ?></p>
            </div>

            <section class="info-cards">
                <div class="card">
                    <span class="material-icons icon-bg-red">pending_actions</span>
                    <div class="card-content">
                        <div class="number"><?php echo $myPendingLeaves; ?></div>
                        <div class="label">My Pending Leaves</div>
                    </div>
                </div>
                <div class="card">
                    <span class="material-icons icon-bg-green">check_circle</span>
                    <div class="card-content">
                        <div class="number"><?php echo $myApprovedLeaves; ?></div>
                        <div class="label">My Approved Leaves</div>
                    </div>
                </div>
                <div class="card">
                    <span class="material-icons icon-bg-blue">event_note</span>
                    <div class="card-content">
                        <div class="number"><?php echo $myTotalDaysUsed; ?></div>
                        <div class="label">Days Leave Used (<?php echo $currentYear; ?>)</div>
                    </div>
                </div>
                <div class="card">
                    <span class="material-icons icon-bg-purple">group</span>
                    <div class="card-content">
                        <div class="number"><?php echo count($teamUpcomingLeaves); ?></div> <div class="label">Team Members Away</div>
                    </div>
                </div>
            </section>

            <section class="main-sections-grid">
                <div class="section-card schedule-card">
                    <div class="card-header">
                        <h2>Team Leave Calendar</h2>
                        <div class="header-actions">
                            <select>
                                <option>This Month</option>
                                <option>Next Month</option>
                            </select>
                            <span class="material-icons">arrow_drop_down</span>
                        </div>
                    </div>
                    <div class="schedule-tabs">
                        <button class="tab active">Upcoming</button>
                        <button class="tab">My Team</button>
                        <button class="tab">Company Holidays</button>
                    </div>
                    <ul class="schedule-list">
                        <?php if (!empty($teamUpcomingLeaves)): ?>
                            <?php foreach ($teamUpcomingLeaves as $leave): ?>
                                <li>
                                    <div class="schedule-item">
                                        <div class="schedule-time"><?php echo $leave['time']; ?></div>
                                        <div class="schedule-details">
                                            <h3><?php echo $leave['title']; ?></h3>
                                            <p><?php echo $leave['reason']; ?></p>
                                            <div class="schedule-meta">
                                                <span class="material-icons">people</span> <?php echo htmlspecialchars($employeeDepartment); ?> Dept.
                                            </div>
                                        </div>
                                        <span class="material-icons more-options">more_vert</span>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><p>No upcoming team leaves found.</p></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="section-card leave-trend-card">
                    <div class="card-header">
                        <h2>My Leave Trend</h2>
                        <span class="material-icons info-icon">info</span>
                    </div>
                    <div class="average-kpi">70,32%</div> <div class="chart-area">
                        <img src="https://via.placeholder.com/300x150/f0f0f0/888888?text=My+Leave+Trend+Chart" alt="My Leave Trend Chart" class="chart-placeholder">
                    </div>
                    <div class="chart-labels">
                        <span>Jul</span><span>Aug</span><span>Sep</span><span>Oct</span><span>Nov</span><span>Dec</span>
                    </div>
                </div>

                <div class="section-card leave-balances-card">
                    <div class="card-header">
                        <h2>My Leave Balances</h2>
                    </div>
                    <div class="leave-balance-items">
                        <div class="balance-item">
                            <div class="balance-number"><?php echo $userLeaveBalances['annual']; ?> Days</div>
                            <div class="balance-label">Annual Leave</div>
                            <button class="request-btn">Request Leave</button>
                        </div>
                        <div class="balance-item">
                            <div class="balance-number"><?php echo $userLeaveBalances['sick']; ?> Days</div>
                            <div class="balance-label">Sick Leave</div>
                            <button class="request-btn">Request Leave</button>
                        </div>
                        <div class="balance-item">
                            <div class="balance-number"><?php echo $userLeaveBalances['casual']; ?> Days</div>
                            <div class="balance-label">Casual Leave</div>
                            <button class="request-btn">Request Leave</button>
                        </div>
                        <div class="balance-item">
                            <div class="balance-number"><?php echo $userLeaveBalances['paternity']; ?> Days</div>
                            <div class="balance-label">Paternity Leave</div>
                            <button class="request-btn">Request Leave</button>
                        </div>
                        <div class="balance-item">
                            <div class="balance-number"><?php echo $userLeaveBalances['compensatory']; ?> Days</div>
                            <div class="balance-label">Compensatory Leave</div>
                            <button class="request-btn">Request Leave</button>
                        </div>
                    </div>
                </div>

                <div class="section-card leave-distribution-card">
                    <div class="card-header">
                        <h2>Company Leave Type Distribution</h2> </div>
                    <div class="distribution-chart">
                        <div class="chart-segment segment-annual">40%</div>
                        <div class="chart-segment segment-sick">30%</div>
                        <div class="chart-segment segment-casual">30%</div>
                    </div>
                    <div class="distribution-legend">
                        <div class="legend-item"><span class="color-box annual"></span> Annual</div>
                        <div class="legend-item"><span class="color-box sick"></span> Sick</div>
                        <div class="legend-item"><span class="color-box casual"></span> Casual</div>
                        <div class="legend-item"><span class="color-box others"></span> Others (Maternity/Paternity)</div>
                    </div>
                </div>
            </section>

            <section class="list-leave-requests-section">
                <div class="card-header">
                    <h2>My Leave Requests</h2> <div class="header-actions">
                        <span class="material-icons search-icon">search</span>
                        <input type="text" placeholder="Search" class="search-input-inline">
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>LEAVE TYPE</th>
                            <th>STATUS</th>
                            <th>START DATE</th>
                            <th>END DATE</th>
                            <th>DAYS</th>
                            <th>REASON</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($myRecentLeaveRequests)): ?>
                            <?php foreach ($myRecentLeaveRequests as $request): ?>
                                <tr>
                                    <td data-label="LEAVE TYPE"><?php echo htmlspecialchars($request['leave_type']); ?></td>
                                    <td data-label="STATUS">
                                        <?php
                                        $statusClass = '';
                                        switch ($request['status']) {
                                            case 'pending': $statusClass = 'status-pending'; break;
                                            case 'approved': $statusClass = 'status-approved'; break;
                                            case 'rejected': $statusClass = 'status-rejected'; break;
                                            default: $statusClass = ''; break;
                                        }
                                        ?>
                                        <span class="status <?php echo $statusClass; ?>"><?php echo htmlspecialchars(ucfirst($request['status'])); ?></span>
                                    </td>
                                    <td data-label="START DATE"><?php echo htmlspecialchars(date('d M Y', strtotime($request['start_date']))); ?></td>
                                    <td data-label="END DATE"><?php echo htmlspecialchars(date('d M Y', strtotime($request['end_date']))); ?></td>
                                    <td data-label="DAYS"><?php echo (new DateTime($request['start_date']))->diff(new DateTime($request['end_date']))->days + 1; ?></td>
                                    <td data-label="REASON"><?php echo htmlspecialchars(substr($request['reason'], 0, 50)); ?>...</td>
                                    <td data-label="ACTION"><span class="material-icons more-options">more_horiz</span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7">No leave requests found for you.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>