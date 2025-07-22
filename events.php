<?php
session_start();
include('connection.php');
?>
<!DOCTYPE html>
<html>
<head>
  <title>All Events</title>
  <link rel="stylesheet" href="css/homepage.css">
  <link rel="stylesheet" href="css/content.css">
</head>
<body>

<?php include('header.php'); ?>

<div class="content-container">
  <h1>📅 All Events</h1>
  <div class="content-grid">
    <?php
    $sql = "SELECT * FROM events ORDER BY event_date DESC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="content-card">';
            if (!empty($row['image_url'])) {
                echo '<img src="' . htmlspecialchars($row['image_url']) . '" alt="Event">';
            }
            echo '<h2>' . htmlspecialchars($row['title']) . '</h2>';
            echo '<small>Date: ' . date("F d, Y", strtotime($row['event_date'])) . '</small>';
            echo '<p>' . nl2br(htmlspecialchars(substr($row['description'],0,150))) . '...</p>';
            echo '</div>';
        }
    } else {
        echo "<p>No events yet.</p>";
    }
    ?>
  </div>
</div>

<script src="homepage.js"></script>
<script src="content.js"></script>
</body>
</html>
