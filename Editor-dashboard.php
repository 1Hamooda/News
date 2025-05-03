<?php
include 'config.php';

if (isset($_POST['action']) && isset($_POST['news_id'])) {
    $news_id = (int)$_POST['news_id'];
    if ($_POST['action'] == 'approve') {
        mysqli_query($conn, "UPDATE news SET status = 'approved' WHERE id = $news_id");
    } elseif ($_POST['action'] == 'deny') {
        mysqli_query($conn, "UPDATE news SET status = 'denied' WHERE id = $news_id");
    } elseif ($_POST['action'] == 'delete') {
        mysqli_query($conn, "DELETE FROM news WHERE id = $news_id");
    }
    header('Location: editor_dashboard.php');
    exit;
}

$query = "SELECT n.id, n.title, n.dateposted, n.status, u.name AS author 
          FROM newstable n JOIN gamers u ON n.author_id = u.id 
          ORDER BY n.dateposted DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editor Dashboard</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        button { padding: 5px; margin: 2px; }
    </style>
</head>
<body>
    <h1>Editor Dashboard</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Date Posted</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['author']; ?></td>
                <td><?php echo $row['dateposted']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="news_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="action" value="approve">Approve</button>
                        <button type="submit" name="action" value="deny">Deny</button>
                        <button type="submit" name="action" value="delete">Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php mysqli_close($conn); ?>
