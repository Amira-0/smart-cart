<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Home</title>

<style>
body {
  margin: 0;
  font-family: 'Segoe UI';
  background: #f5f5f5;
}

/* Header */
.header {
  background: linear-gradient(135deg, #6a0dad, #a855f7);
  color: white;
  padding: 15px;
  position: relative;
}

.top {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.username {
  font-size: 14px;
  margin-top: 5px;
}

/* Settings */
.menu-icon {
  font-size: 22px;
  cursor: pointer;
}

/* Dropdown */
.dropdown {
  position: absolute;
  right: 10px;
  top: 60px;
  background: white;
  border-radius: 12px;
  width: 250px;
  display: none;
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.menu-item {
  padding: 15px;
  border-bottom: 1px solid #eee;
  cursor: pointer;
}

.menu-item:hover {
  background: #f3e8ff;
}

/* Content */
.container {
  padding: 20px;
  padding-bottom: 80px;
}

/* Cards */
.card {
  background: white;
  padding: 15px;
  margin-bottom: 12px;
  border-radius: 12px;
  cursor: pointer;
}

/* Footer */
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

  <div class="top">
    <div>🏠 Home</div>
    <div class="menu-icon" onclick="toggleMenu()">⚙️</div>
  </div>

  <div class="username">
    Welcome, <?php echo $_SESSION['user']['name']; ?>
  </div>

</div>

<!-- Dropdown -->
<div id="menu" class="dropdown">
  <div class="menu-item" onclick="location.href='card.php'">💳 Card</div>
  <div class="menu-item" onclick="location.href='preferences.html'">⭐ Favorites</div>
  <div class="menu-item" onclick="location.href='support.html'">🎧 Support</div>
  <div class="menu-item" onclick="location.href='receipts.php'">🧾 Receipts</div>
  <div class="menu-item" onclick="location.href='logout.php'" style="color:red;">🚪 Logout</div>
</div>

<div class="container">

  <div class="card" onclick="location.href='cart.html'">🛒 My Cart</div>
  <div class="card" onclick="location.href='offers.html'">💸 Offers</div>
  <div class="card" onclick="location.href='list.html'">📋 List</div>
  <div class="card" onclick="location.href='health.html'">❤️ Health</div>
  <div class="card" onclick="location.href='map.html'">🗺️ Map</div>
  <div class="card" onclick="location.href='checkout.php'">💳 Checkout</div>

</div>

<div class="footer">
  SmartCart | support@smartcart.com
</div>

<script>
function toggleMenu(){
  let m = document.getElementById("menu");
  m.style.display = (m.style.display==="block") ? "none" : "block";
}

document.addEventListener("click", function(e){
  let m = document.getElementById("menu");
  let icon = document.querySelector(".menu-icon");

  if (!m.contains(e.target) && !icon.contains(e.target)) {
    m.style.display = "none";
  }
});
</script>

</body>
</html>