<?php
require 'config.php';
$stmt = $pdo->prepare("SELECT leave_type, SUM(DATEDIFF(end_date,start_date)+1) AS days FROM leave_requests WHERE employee_id=? AND status='Approved' GROUP BY leave_type");
$stmt->execute([$employee_id]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html><head><link rel="stylesheet" href="css/dashboard.css"></head><body>
<div class="balance-container">
  <h2>Your Leave Balance</h2>
  <ul>
    <?php foreach($data as $d): ?>
      <li><?=htmlspecialchars($d['leave_type'])?>: <strong><?= $d['days'] ?> days</strong></li>
    <?php endforeach; ?>
  </ul>
</div></body></html>
