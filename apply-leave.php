<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = 1; // hardcoded for now; later from session
    $leave_type = $_POST['leave_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $reason = $_POST['reason'];

    $stmt = $pdo->prepare("INSERT INTO leave_requests (employee_id, leave_type, start_date, end_date, reason) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$employee_id, $leave_type, $start_date, $end_date, $reason]);

    header("Location: leave-history.php?submitted=1");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Apply for Leave</title>
  <link rel="stylesheet" href="dashboard.css">
</head>
<body class="dark-mode">
  <div class="form-container">
    <h2>Apply for Leave</h2>
    <form method="POST">
      <label>Leave Type:</label>
      <select name="leave_type" required>
        <option value="Annual">Annual</option>
        <option value="Sick">Sick</option>
        <option value="Maternity">Maternity</option>
        <option value="Paternity">Paternity</option>
      </select>

      <label>Start Date:</label>
      <input type="date" name="start_date" required>

      <label>End Date:</label>
      <input type="date" name="end_date" required>

      <label>Reason:</label>
      <textarea name="reason" rows="4" required></textarea>

      <button type="submit">Submit Leave</button>
    </form>
  </div>
</body>
</html>
