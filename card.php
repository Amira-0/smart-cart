<?php
session_start();
include("db.php");

if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user_id = $_SESSION["user"]["id"];
  $card = $_POST["card"] ?? "";
  $expiry = $_POST["expiry"] ?? "";
  $cvv = $_POST["cvv"] ?? "";

  if (!preg_match("/^[0-9]{16}$/", $card)) {
    $message = "❌ Card number must be exactly 16 digits.";
  } elseif ($expiry == "") {
    $message = "❌ Please select expiry date.";
  } elseif (!preg_match("/^[0-9]{3}$/", $cvv)) {
    $message = "❌ CVV must be exactly 3 digits.";
  } else {
    $sql = "INSERT INTO cards (user_id, card_number, expiry, cvv)
            VALUES ('$user_id', '$card', '$expiry', '$cvv')";

    if ($conn->query($sql)) {
      $message = "✅ Card saved successfully!";
    } else {
      $message = "❌ Error saving card.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Credit Card</title>

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

.card-preview {
  background: linear-gradient(135deg, #6a0dad, #a855f7);
  color: white;
  padding: 20px;
  border-radius: 18px;
  margin-bottom: 20px;
  box-shadow: 0 8px 18px rgba(0,0,0,0.15);
}

.card-number {
  font-size: 20px;
  letter-spacing: 2px;
  margin: 25px 0 10px;
}

.form-box {
  background: white;
  padding: 20px;
  border-radius: 15px;
}

input {
  width: 100%;
  padding: 12px;
  margin: 10px 0;
  border-radius: 10px;
  border: 1px solid #ccc;
}

.save-btn {
  width: 100%;
  padding: 14px;
  border: none;
  border-radius: 12px;
  background: #6a0dad;
  color: white;
  font-weight: bold;
  cursor: pointer;
}

.message {
  background: white;
  padding: 12px;
  border-radius: 12px;
  margin-bottom: 15px;
  text-align: center;
  font-weight: bold;
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
  <div>Credit Card</div>
  <div></div>
</div>

<div class="container">

  <?php if ($message != ""): ?>
    <div class="message"><?php echo $message; ?></div>
  <?php endif; ?>

  <div class="card-preview">
    <div>SmartCart Card</div>
    <div class="card-number">**** **** **** ****</div>
    <div>Expiry: MM/YYYY</div>
  </div>

  <div class="form-box">
    <form method="POST">
      <input
        type="text"
        name="card"
        placeholder="Card Number (16 digits)"
        maxlength="16"
        pattern="[0-9]{16}"
        required>

      <input
        type="month"
        name="expiry"
        required>

      <input
        type="text"
        name="cvv"
        placeholder="CVV (3 digits)"
        maxlength="3"
        pattern="[0-9]{3}"
        required>

      <button type="submit" class="save-btn">Save Card</button>
    </form>
  </div>

</div>

<div class="footer">
  SmartCart | support@smartcart.com
</div>

</body>
</html>