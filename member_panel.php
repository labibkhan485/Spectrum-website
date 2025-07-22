<?php
session_start();
include('connection.php');

// Protect page for members
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'member') {
    header("Location: LogIn.php");
    exit;
}

$message = "";

// Handle Blog Post Submission (members can only post blogs)
if (isset($_POST['add_blog'])) {
    $title = $_POST['blog_title'];
    $content = $_POST['blog_content'];
    $author = "Member"; // can use $_SESSION['username'] if stored
    
    $sql = "INSERT INTO blog_posts (title, content, author) VALUES (?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $content, $author);
    $stmt->execute();
    $message = "✅ Blog post added!";
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Member Panel</title>
  <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
  <div class="dashboard-container">
    <h1>Member Panel</h1>
    <p>Welcome, Member!</p>
    <a class="logout" href="logout.php">Logout</a>
    <?php if($message) echo "<p class='message'>$message</p>"; ?>

    <!-- BLOG POST FORM -->
    <section>
      <h2>Post a Blog</h2>
      <form method="POST">
        <label>Blog Title</label>
        <input type="text" name="blog_title" required>
        <label>Blog Content</label>
        <textarea name="blog_content" rows="4" required></textarea>
        <button type="submit" name="add_blog">Add Blog</button>
      </form>
    </section>
  </div>
</body>
</html>
