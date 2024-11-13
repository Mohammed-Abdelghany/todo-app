<?php
global $conn;
include 'db.php';

// Add task
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task'])) {
    $task = $_POST['task'];
    if (!empty($task)) {
        $stmt = $conn->prepare("INSERT INTO tasks (task) VALUES (:task)");
        $stmt->bindParam(':task', $task, PDO::PARAM_STR);
        $stmt->execute();
    }
}

// Delete task
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

// Retrieve all tasks
$stmt = $conn->query("SELECT * FROM tasks");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>My To-Do List</h1>

    <form method="POST" action="index.php">
        <input type="text" name="task" placeholder="Enter a new task" required>
        <button type="submit">Add Task</button>
    </form>

    <ul class="task-list">
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <li>
                <?php echo htmlspecialchars($row['task']); ?>
                <a href="index.php?delete=<?php echo $row['id']; ?>" class="delete-btn">Delete</a>
            </li>
        <?php endwhile; ?>
    </ul>
</div>
</body>
</html>

<?php
// Unset the connection at the end (optional)
$conn = null;
?>
