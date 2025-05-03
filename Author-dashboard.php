<?php
include 'config.php'; // Include database connection

// Placeholder author_id (replace with session-based ID later)
$author_id = 1; // Temporary for demo purposes

// Fetch news items by this author
$query = "SELECT id, title, dateposted, status FROM newstable WHERE author_id = $author_id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Author Dashboard</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .add-btn { margin: 10px 0; padding: 10px; background-color: #4CAF50; color: white; text-decoration: none; }
    </style>
</head>
<body>
    <h1>Author Dashboard</h1>
    <a href="add_news.php" class="add-btn">Add New News Item</a>
    
    <h2>My News Items</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Date Posted</th>
            <th>Status</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['dateposted']; ?></td>
                <td><?php echo $row['status']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php mysqli_close($conn); ?>
