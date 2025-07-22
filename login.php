<?php
session_start();
include('connection.php');

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // For now using MD5 (later replace with bcrypt)
        if (md5($password) === $user['password_hash']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'admin') {
                header("Location: admin_panel.php");
            } else {
                header("Location: member_panel.php");
            }
            exit;
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>
<?php include('header.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="css/homepage.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>


<div class="login-page">
<div class="login-container">
    <h1>Login</h1>
    <?php if($error) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>

    <p>Not registered? <a href="register.php">Register here</a></p>
</div>
</div>
 <script src="homepage.js"></script>
</body>
</html>
