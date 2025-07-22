<?php
session_start();
include('connection.php');

// Protect page for admins only
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: LogIn.php");
    exit;
}

$message = "";

// Handle Blog Post Submission
if (isset($_POST['add_blog'])) {
    $title = $_POST['blog_title'];
    $content = $_POST['blog_content'];
    $author = "Admin"; // Can also use logged-in username
    
    $sql = "INSERT INTO blog_posts (title, content, author) VALUES (?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $content, $author);
    $stmt->execute();
    $message = "✅ Blog post added!";
}

// Handle Event Submission
if (isset($_POST['add_event'])) {
    $title = $_POST['event_title'];
    $description = $_POST['event_description'];
    $event_date = $_POST['event_date'];
    $image_url = NULL;

    // Image upload for event
    if (!empty($_FILES['event_image']['name'])) {
        $target_dir = "images/events/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $image_name = time() . "_" . basename($_FILES["event_image"]["name"]);
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES["event_image"]["tmp_name"], $target_file)) {
            $image_url = $target_file;
        }
    }

    $sql = "INSERT INTO events (title, description, event_date, image_url) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $title, $description, $event_date, $image_url);
    $stmt->execute();
    $message = "✅ Event added!";
}

// Fetch all members
$members_sql = "SELECT username, email, post, role FROM users ORDER BY role DESC";
$members_result = $conn->query($members_sql);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Panel</title>
  <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
  <div class="dashboard-container">
    <h1>Admin Panel</h1>
    <p>Welcome, Admin!</p>
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

    <!-- EVENT POST FORM -->
    <section>
      <h2>Post an Event</h2>
      <form method="POST" enctype="multipart/form-data">
        <label>Event Title</label>
        <input type="text" name="event_title" required>
        <label>Event Description</label>
        <textarea name="event_description" rows="3" required></textarea>
        <label>Event Date</label>
        <input type="date" name="event_date" required>
        <label>Event Image</label>
        <input type="file" name="event_image" accept="image/*">
        <button type="submit" name="add_event">Add Event</button>
      </form>
    </section>

    <!-- MEMBER LIST -->
    <section>
      <h2>All Members</h2>
      <table>
        <tr>
          <th>Username</th>
          <th>Email</th>
          <th>Position</th>
          <th>Role</th>
        </tr>
        <?php 
        if ($members_result && $members_result->num_rows > 0) {
            while ($row = $members_result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['username']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['post']}</td>
                        <td>{$row['role']}</td>
                      </tr>";
            }
        }
        ?>
      </table>
    </section>
  </div>
</body>
</html>
