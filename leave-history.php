<?php
require 'config.php';
$employee_id = 1; // simulate logged in user

$stmt = $pdo->prepare("SELECT * FROM leave_requests WHERE employee_id = ? ORDER BY submitted_at DESC");
$stmt->execute([$employee_id]);
$leaves = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Leave History</title>
  <link rel="stylesheet" href="css/dashboard.css">
</head>
<body class="dark-mode">
  <div class="history-container">
    <h2>Your Leave History</h2>
    <?php if (count($leaves) > 0): ?>
    <table>
      <thead>
        <tr>
          <th>Type</th><th>Start</th><th>End</th><th>Status</th><th>Submitted</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($leaves as $leave): ?>
          <tr>
            <td><?= htmlspecialchars($leave['leave_type']) ?></td>
            <td><?= $leave['start_date'] ?></td>
            <td><?= $leave['end_date'] ?></td>
            <td><?= $leave['status'] ?></td>
            <td><?= $leave['submitted_at'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php else: ?>
      <p>No leave records found.</p>
    <?php endif; ?>
  </div>
</body>
</html>
