<?php
session_start();
include("db.php");

$message = "";

if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $message = "Please enter your email and password.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {
                $_SESSION["user"] = $user;
                header("Location: home.php");
                exit();
            } else {
                $message = "Incorrect email or password.";
            }
        } else {
            $message = "Incorrect email or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>

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
  width: 350px;
  background: white;
  padding: 30px;
  border-radius: 22px;
  box-shadow: 0 15px 35px rgba(0,0,0,0.18);
}

.logo {
  text-align: center;
  font-size: 45px;
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
  background: #fdeaea;
  color: #c62828;
  padding: 11px;
  border-radius: 10px;
  text-align: center;
  font-size: 14px;
  margin-bottom: 12px;
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
  <h2>Welcome Back</h2>
  <div class="subtitle">Login to continue to SmartCart</div>

  <?php if ($message != ""): ?>
    <div class="message"><?php echo $message; ?></div>
  <?php endif; ?>

  <form method="POST">
    <input type="email" name="email" placeholder="Email Address" required>
    <input type="password" name="password" placeholder="Password" required>

    <button type="submit">Login</button>
  </form>

  <div class="link">
    Don’t have an account?
    <a href="register.php">Create Account</a>
  </div>
</div>

</body>
</html>