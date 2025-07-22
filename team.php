<?php
session_start();
include('connection.php');
?>
<!DOCTYPE html>
<html>
<head>
  <title>🤝 Meet Our Team</title>
  <link rel="stylesheet" href="css/homepage.css">
  <link rel="stylesheet" href="css/team.css">
</head>
<body>

<?php include('header.php'); ?>

<div class="team-container">
  <h1>🤝 Meet Our Team</h1>

  <?php
  $sql = "SELECT username, full_name, post, role, image_url FROM users ORDER BY role DESC, username ASC";
  $result = $conn->query($sql);

  if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          echo '<div class="team-member">';
          
          // Profile Image
          $imgPath = (!empty($row['image_url'])) ? htmlspecialchars($row['image_url']) : "images/profiles/default.png";
          echo '<div class="image-box">';
          echo '<img src="'.$imgPath.'" alt="Profile">';
          echo '</div>';

          // Info Section
          echo '<div class="member-info">';
          echo '<h2>'.htmlspecialchars($row['full_name'] ?? $row['username']).'</h2>';
          echo '<p class="position">'.htmlspecialchars($row['post']).'</p>';
          echo '<small class="role">Role: '.ucfirst($row['role']).'</small>';
          echo '</div>';

          echo '</div>'; // end team-member
      }
  } else {
      echo "<p>No team members yet.</p>";
  }
  ?>
</div>

<script src="homepage.js"></script>
</body>
</html>
