<?php
require 'config.php';
$stmt = $pdo->prepare("SELECT leave_type, start_date, end_date FROM leave_requests WHERE employee_id = ? AND status='Approved'");
$stmt->execute([$employee_id]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$events = [];
foreach($rows as $r){
  $events[] = [
    'title'=>$r['leave_type'],
    'start'=>$r['start_date'],
    'end'=>date('Y-m-d', strtotime($r['end_date'].' +1 day'))
  ];
}
header('Content-Type: application/json');
echo json_encode($events);
