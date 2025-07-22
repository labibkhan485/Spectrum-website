<?php include('connection.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Spectrum - Homepage</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;600&display=swap" rel="stylesheet">

  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/homepage.css">
</head>
<body>

  <!-- NAVIGATION -->
  <header class="navbar">
    <div class="logo">
      <img src="images/spectrum_logo.png" alt="Spectrum Logo">
      <span>SPECTRUM</span>
    </div>

    <!-- Hamburger menu for mobile -->
    <div class="menu-toggle" id="menu-toggle">
      <i class="fas fa-bars"></i>
    </div>

    <nav class="nav-links" id="nav-links">
  <a href="homepage.php"><i class="fas fa-home"></i> Home</a>
  <a href="events.php"><i class="fas fa-calendar"></i> Events</a>
  <a href="blog.php"><i class="fas fa-blog"></i> Blog</a>
  <a href="team.php"><i class="fas fa-users"></i> Team</a>
  <a href="ContactPage.php"><i class="fas fa-envelope"></i> Contact</a>
</nav>

    
    <a href="login.php" class="login-btn"><i class="fas fa-sign-in-alt"></i> Login</a>
  </header>

  <!-- HERO SECTION -->
  <section id="hero" class="hero">
    <h1>Welcome to SPECTRUM</h1>
    <p>The Skill Development Club of KUET</p>
    <a href="#events" class="btn">Explore More</a>
  </section>

  <!-- LATEST EVENTS SECTION -->
  <section id="events" class="section">
    <h2>Upcoming Events</h2>
    <div class="cards">
      <?php
      $sql = "SELECT * FROM events ORDER BY event_date DESC LIMIT 3";
      $result = $conn->query($sql);
      if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo '<div class="card">';
              echo '<img src="'.$row['image_url'].'" alt="Event">';
              echo '<h3>'.$row['title'].'</h3>';
              echo '<p>'.$row['description'].'</p>';
              echo '<small>Date: '.$row['event_date'].'</small>';
              echo '</div>';
          }
      } else {
          echo "<p>No events yet.</p>";
      }
      ?>
    </div>
  </section>

  <!-- BLOG SECTION -->
  <section id="blog" class="section">
    <h2>Latest Blog Posts</h2>
    <div class="cards">
      <?php
      $sql = "SELECT * FROM blog_posts ORDER BY created_at DESC LIMIT 3";
      $result = $conn->query($sql);
      if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo '<div class="card">';
              echo '<h3>'.$row['title'].'</h3>';
              echo '<p>'.substr($row['content'],0,100).'...</p>';
              echo '<small>By '.$row['author'].' on '.$row['created_at'].'</small>';
              echo '</div>';
          }
      } else {
          echo "<p>No blog posts yet.</p>";
      }
      ?>
    </div>
  </section>

  <!-- TEAM SECTION -->
  <section id="team" class="section">
    <h2>Meet Our Team</h2>
    <div class="cards">
      <?php
      $sql = "SELECT * FROM team_members LIMIT 3";
      $result = $conn->query($sql);
      if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo '<div class="card">';
              echo '<img src="'.$row['photo_url'].'" alt="Team Member">';
              echo '<h3>'.$row['name'].'</h3>';
              echo '<p>'.$row['role'].'</p>';
              echo '</div>';
          }
      } else {
          echo "<p>No team members added yet.</p>";
      }
      ?>
    </div>
  </section>

  <!-- CONTACT SECTION -->
  <section id="contact" class="section contact">
    <h2>Contact Us</h2>
    <p>Email us at <strong>contact@spectrum.com</strong></p>
  </section>

  <!-- FOOTER -->
  <footer class="footer">
    <p>&copy; <?php echo date("Y"); ?> Spectrum Club. All rights reserved.</p>
  </footer>

  <!-- JavaScript for menu toggle -->
  <script src="homepage.js"></script>
</body>
</html>
