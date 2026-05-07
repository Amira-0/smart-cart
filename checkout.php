<?php
session_start();
include("db.php");

$products = [
  ["name" => "Milk", "price" => 1.50],
  ["name" => "Bread", "price" => 0.80],
  ["name" => "Apple Juice", "price" => 1.20]
];

$total = 0;
foreach ($products as $product) {
  $total += $product["price"];
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $payment = $_POST["payment"] ?? "";

  if ($payment == "") {
    $message = "⚠️ Please select a payment method.";
  } else {
    if (isset($_SESSION["user"])) {
      $user_id = $_SESSION["user"]["id"];
      $sql = "INSERT INTO orders (user_id, total) VALUES ('$user_id', '$total')";
      $conn->query($sql);
    }

    $message = "✅ Payment confirmed successfully!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout</title>

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
  padding-bottom: 90px;
}

.product {
  background: white;
  padding: 15px;
  margin-bottom: 12px;
  border-radius: 12px;
  display: flex;
  justify-content: space-between;
}

.total {
  background: white;
  padding: 15px;
  margin: 20px 0;
  border-radius: 12px;
  text-align: center;
  font-weight: bold;
  color: #6a0dad;
}

.payment-option {
  background: white;
  padding: 15px;
  margin-bottom: 12px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  gap: 15px;
  cursor: pointer;
  border: 2px solid transparent;
}

.payment-option.selected {
  border-color: #6a0dad;
}

.payment-option img {
  width: 40px;
  height: 40px;
  object-fit: contain;
}

.confirm-btn {
  width: 100%;
  padding: 14px;
  background: #6a0dad;
  color: white;
  border: none;
  border-radius: 12px;
  font-weight: bold;
  cursor: pointer;
}

.message {
  padding: 12px;
  background: white;
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
  <div>Checkout</div>
  <div></div>
</div>

<div class="container">

  <?php if ($message != ""): ?>
    <div class="message"><?php echo $message; ?></div>
  <?php endif; ?>

  <h3>Products</h3>

  <?php foreach ($products as $product): ?>
    <div class="product">
      <span><?php echo $product["name"]; ?></span>
      <strong><?php echo number_format($product["price"], 2); ?> OMR</strong>
    </div>
  <?php endforeach; ?>

  <div class="total">
    Total: <?php echo number_format($total, 2); ?> OMR
  </div>

  <h3>Payment Method</h3>

  <form method="POST">

    <div class="payment-option" onclick="selectPayment(this, 'Apple Pay')">
      <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg">
      <span>Apple Pay</span>
    </div>

    <div class="payment-option" onclick="selectPayment(this, 'Credit Card')">
      <img src="https://cdn-icons-png.flaticon.com/512/633/633611.png">
      <span>Credit Card</span>
    </div>

    <input type="hidden" name="payment" id="payment">

    <button type="submit" class="confirm-btn">
      Confirm Payment
    </button>

  </form>

</div>

<div class="footer">
  SmartCart | support@smartcart.com
</div>

<script>
function selectPayment(element, method) {
  document.querySelectorAll(".payment-option").forEach(option => {
    option.classList.remove("selected");
  });

  element.classList.add("selected");
  document.getElementById("payment").value = method;
}
</script>

</body>
</html>