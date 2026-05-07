<?php
session_start();
include("db.php");

if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION["user"]["id"];

$result = $conn->query("SELECT * FROM orders WHERE user_id='$user_id' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Receipts</title>

<style>
body {
  margin: 0;
  font-family: 'Segoe UI';
  background: #f5f5f5;
}

.header {
  background: #6a0dad;
  color: white;
  padding: 15px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.header span {
  cursor: pointer;
}

.container {
  padding: 20px;
  padding-bottom: 80px;
}

.receipt {
  background: white;
  padding: 15px;
  margin-bottom: 12px;
  border-radius: 12px;
}

.empty {
  text-align: center;
  color: #777;
  margin-top: 30px;
}

.footer {
  position: fixed;
  bottom: 0;
  width: 100%;
  background: white;
  text-align: center;
  padding: 10px;
  font-size: 14px;
  box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
}
</style>
</head>

<body>

<div class="header">
  <span onclick="location.href='home.php'">⬅️ Home</span>
  <div>Receipts</div>
  <div></div>
</div>

<div class="container">
  <h3>Previous Receipts</h3>

  <?php if ($result && $result->num_rows > 0): ?>

    <?php while($row = $result->fetch_assoc()): ?>
      <div class="receipt">
        <strong>Receipt #<?php echo $row["id"]; ?></strong>
        <p>Total: <?php echo number_format($row["total"], 2); ?> OMR</p>
        <p>Date: <?php echo $row["created_at"]; ?></p>
      </div>
    <?php endwhile; ?>

  <?php else: ?>

    <div class="empty">No receipts yet.</div>

  <?php endif; ?>
</div>

<div class="footer">
  SmartCart | support@smartcart.com
</div>

</body>
</html>