<?php
session_start();
include("db.php");

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $message = "Please fill in all fields.";
        $messageType = "error";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
        $messageType = "error";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters.";
        $messageType = "error";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match.";
        $messageType = "error";
    } else {
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $message = "This email is already registered.";
            $messageType = "error";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashedPassword);

            if ($stmt->execute()) {
                $message = "Account created successfully. You can login now.";
                $messageType = "success";
            } else {
                $message = "Something went wrong. Please try again.";
                $messageType = "error";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Create Account</title>

<style>
body {
  margin: 0;
  font-family: 'Segoe UI', Arial, sans-serif;
  background: linear-gradient(135deg, #6a0dad, #a855f7);
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.auth-box {
  width: 360px;
  background: white;
  padding: 30px;
  border-radius: 22px;
  box-shadow: 0 15px 35px rgba(0,0,0,0.18);
}

.logo {
  text-align: center;
  font-size: 42px;
  margin-bottom: 5px;
}

h2 {
  text-align: center;
  color: #6a0dad;
  margin: 5px 0;
}

.subtitle {
  text-align: center;
  color: #777;
  font-size: 14px;
  margin-bottom: 20px;
}

input {
  width: 100%;
  padding: 13px;
  margin-bottom: 12px;
  border-radius: 12px;
  border: 1px solid #ddd;
  background: #f8f8f8;
  box-sizing: border-box;
  font-size: 14px;
}

input:focus {
  outline: none;
  border-color: #6a0dad;
  background: white;
}

button {
  width: 100%;
  padding: 14px;
  border: none;
  border-radius: 12px;
  background: #6a0dad;
  color: white;
  font-weight: bold;
  cursor: pointer;
  font-size: 15px;
}

button:hover {
  background: #5a0ba8;
}

.message {
  padding: 11px;
  border-radius: 10px;
  text-align: center;
  font-size: 14px;
  margin-bottom: 12px;
}

.success {
  background: #e8f8ee;
  color: #16803a;
}

.error {
  background: #fdeaea;
  color: #c62828;
}

.link {
  text-align: center;
  margin-top: 15px;
  font-size: 14px;
}

.link a {
  color: #6a0dad;
  font-weight: bold;
  text-decoration: none;
}
</style>
</head>

<body>

<div class="auth-box">
  <div class="logo">🛒</div>
  <h2>Create Account</h2>
  <div class="subtitle">Join SmartCart and start shopping smarter</div>

  <?php if ($message != ""): ?>
    <div class="message <?php echo $messageType; ?>">
      <?php echo $message; ?>
    </div>
  <?php endif; ?>

  <form method="POST">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email Address" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required>

    <button type="submit">Create Account</button>
  </form>

  <div class="link">
    Already have an account?
    <a href="login.php">Login</a>
  </div>
</div>

</body>
</html>