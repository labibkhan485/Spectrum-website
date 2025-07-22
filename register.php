<?php
session_start();
include('connection.php');
include('config.php'); // where ADMIN_REG_KEY & MEMBER_REG_KEY are defined

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $roll = trim($_POST['roll']);
    $position = trim($_POST['position']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $reg_key = trim($_POST['reg_key']);
    
    // Image upload (optional)
    $image_url = NULL;
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "images/profiles/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $image_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_url = $target_file;
        }
    }

    // Validate passwords
    if ($password !== $confirm_password) {
        $message = "❌ Passwords do not match!";
    } else {
        // Determine role from registration key
        $role = "";
        if ($reg_key === ADMIN_REG_KEY) {
            $role = "admin";
        } elseif ($reg_key === MEMBER_REG_KEY) {
            $role = "member";
        } else {
            $message = "❌ Invalid registration key!";
        }

        if ($role) {
            // Check if username/email already exists
            $check_sql = "SELECT * FROM users WHERE username=? OR email=?";
            $stmt = $conn->prepare($check_sql);
            $stmt->bind_param("ss", $username, $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $message = "❌ Username or Email already exists!";
            } else {
                // Hash password (for now MD5, later bcrypt)
                $password_hash = md5($password);

                // Insert user
                $sql = "INSERT INTO users (username, email, post, password_hash, role, image_url) VALUES (?,?,?,?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssss", $username, $email, $position, $password_hash, $role, $image_url);

                if ($stmt->execute()) {
                    $message = "✅ Registration successful! <a href='LogIn.php'>Login now</a>";
                } else {
                    $message = "❌ Error registering user!";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;600&display=swap" rel="stylesheet">
  
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  
  <!-- CSS Files -->
  <link rel="stylesheet" href="css/homepage.css">
  <link rel="stylesheet" href="css/register.css">
</head>
<body>
  <?php include('header.php'); ?>
  
  <div class="register-page">
    <div class="register-container">
      <h1>Register</h1>
      <?php if($message) echo "<p class='message'>$message</p>"; ?>
      <form method="POST" enctype="multipart/form-data">

      <label>Username</label>
      <input type="text" name="username" required>

      <label>Email</label>
      <input type="email" name="email" required>

      <label>Roll</label>
      <input type="text" name="roll" required>

      <label>Position in Club</label>
      <input type="text" name="position" required>

      <label>Password</label>
      <input type="password" name="password" required>

      <label>Confirm Password</label>
      <input type="password" name="confirm_password" required>

      <label>Profile Image (optional)</label>
      <input type="file" name="image" accept="image/*">

      <label>Registration Key</label>
      <input type="text" name="reg_key" required placeholder="Enter Admin or Member key">

      <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="LogIn.php">Login here</a></p>
    </div>
  </div>
</body>
</html>
