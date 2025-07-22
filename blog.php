<?php
session_start();
include('connection.php');
?>
<!DOCTYPE html>
<html>
<head>
  <title>All Blog Posts</title>
  <link rel="stylesheet" href="css/homepage.css">
  <link rel="stylesheet" href="css/content.css">
</head>
<body>

<?php include('header.php'); ?>

<div class="content-container">
  <h1>📖 All Blog Posts</h1>
  <div class="content-grid">
    <?php
    $sql = "SELECT * FROM blog_posts ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="content-card">';
            echo '<h2>' . htmlspecialchars($row['title']) . '</h2>';
            echo '<small>By ' . htmlspecialchars($row['author']) . ' on ' . date("F d, Y", strtotime($row['created_at'])) . '</small>';
            echo '<p>' . nl2br(htmlspecialchars(substr($row['content'],0,150))) . '...</p>';
            echo '<a class="read-more" href="blog_post.php?id=' . $row['id'] . '">Read More</a>';
            echo '</div>';
        }
    } else {
        echo "<p>No blog posts yet.</p>";
    }
    ?>
  </div>
</div>

<script src="homepage.js"></script>
<script src="content.js"></script>
</body>
</html>
