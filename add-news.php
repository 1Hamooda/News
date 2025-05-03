<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $body = mysqli_real_escape_string($conn, $_POST['body']);
    $image = mysqli_real_escape_string($conn, $_POST['image']); // URL or placeholder for now
    $category_id = (int)$_POST['category_id'];
    $author_id = 1; // Placeholder, replace with session ID later
    $dateposted = date('Y-m-d H:i:s');
    $status = 'pending';

    $query = "INSERT INTO news (title, body, image, dateposted, category_id, author_id, status) 
              VALUES ('$title', '$body', '$image', '$dateposted', $category_id, $author_id, '$status')";
    mysqli_query($conn, $query);
    header('Location: author_dashboard.php'); // Redirect back to dashboard
    exit;
}

// Fetch categories for dropdown
$categories = mysqli_query($conn, "SELECT id, name FROM category");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add News Item</title>
    <style>
        form { max-width: 600px; margin: 20px; }
        label { display: block; margin: 10px 0 5px; }
        input, textarea, select { width: 100%; padding: 8px; margin-bottom: 10px; }
        button { padding: 10px 20px; background-color: #4CAF50; color: white; border: none; }
    </style>
</head>
<body>
    <h1>Add New News Item</h1>
    <form method="POST">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        
        <label for="body">Body:</label>
        <textarea id="body" name="body" rows="5" required></textarea>
        
        <label for="image">Image URL:</label>
        <input type="text" id="image" name="image">
        
        <label for="category_id">Category:</label>
        <select id="category_id" name="category_id" required>
            <?php while ($cat = mysqli_fetch_assoc($categories)) { ?>
                <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
            <?php } ?>
        </select>
        
        <button type="submit">Submit</button>
    </form>
    <a href="author_dashboard.php">Back to Dashboard</a>
</body>
</html>

<?php mysqli_close($conn); ?>