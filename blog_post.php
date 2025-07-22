<?php
session_start();
include('connection.php');

// Get blog ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid blog post ID.");
}
$id = intval($_GET['id']);

// Fetch blog post
$sql = "SELECT * FROM blog_posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $post = $result->fetch_assoc();
} else {
    die("Blog post not found.");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo htmlspecialchars($post['title']); ?> - Blog Post</title>
  <link rel="stylesheet" href="css/homepage.css">
  <link rel="stylesheet" href="css/content.css">
</head>
<body>

<?php include('header.php'); ?>

<div class="content-container">
  <h1><?php echo htmlspecialchars($post['title']); ?></h1>
  <small>By <?php echo htmlspecialchars($post['author']); ?> on <?php echo date("F d, Y", strtotime($post['created_at'])); ?></small>
  <div class="content-card">
    <!-- ✅ DON'T escape HTML completely or line breaks will vanish -->
    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
  </div>
  <a class="back-btn" href="blog.php">⬅ Back to All Blogs</a>
</div>

<script src="content.js"></script>
</body>
</html>
