<?php
function renderHeader($title) {
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $title; ?></title>

<style>
body {
  margin: 0;
  font-family: 'Segoe UI';
  background: #f5f5f5;
}

/* 🔝 Header */
.header {
  background: linear-gradient(135deg, #6a0dad, #a855f7);
  color: white;
  padding: 15px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.back {
  font-size: 22px;
  cursor: pointer;
}

.menu-icon {
  font-size: 22px;
  cursor: pointer;
}

/* 📦 Content */
.container {
  padding: 20px;
  padding-bottom: 80px;
}

/* 📱 Cards */
.card {
  background: white;
  padding: 15px;
  margin-bottom: 10px;
  border-radius: 12px;
  cursor: pointer;
}

/* 🔻 Footer */
.footer {
  position: fixed;
  bottom: 0;
  width: 100%;
  background: white;
  display: flex;
  justify-content: space-around;
  padding: 10px;
  box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
}

.nav-item {
  font-size: 22px;
  cursor: pointer;
}
</style>
</head>

<body>

<div class="header">
  <div class="back" onclick="history.back()">⬅️</div>
  <div><?php echo $title; ?></div>
  <div></div>
</div>

<div class="container">
<?php
}

function renderFooter() {
?>
</div>

<div class="footer">
  <div class="nav-item" onclick="location.href='home.php'">🏠</div>
  <div class="nav-item" onclick="location.href='cart.html'">🛒</div>
  <div class="nav-item" onclick="location.href='checkout.php'">💳</div>
  <div class="nav-item" onclick="location.href='profile.php'">👤</div>
</div>

</body>
</html>
<?php
}
?>