<?php
session_start();
include('connection.php');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Meet Our Team</title>
  <link rel="stylesheet" href="css/homepage.css">
  <link rel="stylesheet" href="css/content.css">
</head>
<body>

<?php include('header.php'); ?>

<div class="content-container">
  <h1>🤝 Meet Our Team</h1>
  <div class="content-grid">
    <?php
    $sql = "SELECT * FROM team_members ORDER BY id ASC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="content-card">';
            if (!empty($row['photo_url'])) {
                echo '<img src="' . htmlspecialchars($row['photo_url']) . '" alt="Team Member">';
            }
            echo '<h2>' . htmlspecialchars($row['name']) . '</h2>';
            echo '<p>' . htmlspecialchars($row['role']) . '</p>';
            echo '</div>';
        }
    } else {
        echo "<p>No team members yet.</p>";
    }
    ?>
  </div>
</div>

<script src="homepage.js"></script>
<script src="content.js"></script>
</body>
</html>
