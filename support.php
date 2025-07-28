<?php require 'config.php';
if($_SERVER['REQUEST_METHOD']=='POST'){
  $stmt=$pdo->prepare("INSERT INTO support_tickets(employee_id,subject,message) VALUES(?,?,?)");
  $stmt->execute([$employee_id, $_POST['subject'], $_POST['message']]);
  header('Location: support.php?sent=1');exit;
}
$tickets = $pdo->prepare("SELECT * FROM support_tickets WHERE employee_id=? ORDER BY submitted_at DESC");
$tickets->execute([$employee_id]); ?>
<!DOCTYPE html><html><head><link rel="stylesheet" href="dashboard.css"><title>Support</title></head><body>
<div class="support-form">
<?php if(isset($_GET['sent'])) echo "<p class='info'>Ticket submitted!</p>"; ?>
<h2>Submit Support Request</h2>
<form method="POST">
  <label>Subject:</label><input name="subject" required>
  <label>Message:</label><textarea name="message" rows="4" required></textarea>
  <button type="submit">Send</button>
</form>
<h3>Your Tickets</h3>
<?php if($tickets->rowCount()>0): ?><ul><?php
foreach($tickets as $t) echo "<li><strong>".htmlspecialchars($t['subject'])."</strong> – {$t['status']}</li>";
?></ul><?php else: ?><p>No tickets yet.</p><?php endif; ?>
</div></body></html>
