<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Profile</title>

<style>
body { margin:0; font-family:'Segoe UI'; background:#f5f5f5; }

.header {
  background:#6a0dad;
  color:white;
  padding:15px;
  display:flex;
  justify-content:space-between;
}

.back { cursor:pointer; }

.container { padding:20px; padding-bottom:80px; }

.footer {
  position:fixed;
  bottom:0;
  width:100%;
  background:white;
  text-align:center;
  padding:10px;
  box-shadow:0 -2px 10px rgba(0,0,0,0.1);
}
</style>

</head>

<body>

<div class="header">
  <div class="back" onclick="location.href='home.php'">⬅️ Home</div>
  <div>Profile</div>
</div>

<div class="container">
  <p>Name: <?php echo $_SESSION['user']['name']; ?></p>
  <p>Email: <?php echo $_SESSION['user']['email']; ?></p>
</div>

<div class="footer">
  SmartCart | support@smartcart.com
</div>

</body>
</html>