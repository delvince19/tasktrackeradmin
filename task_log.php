<?php
session_start();
include("config.php");

// Fetch all tasks
$query = "SELECT * FROM `tbl_tasklist`";
$result = mysqli_query($con, $query);

if(isset($_POST['deleteTask'])) {
    $taskId = $_POST['taskId'];

    $deleteQuery = "DELETE FROM `tbl_tasklist` WHERE `id`='$taskId'";
    mysqli_query($con, $deleteQuery);

    $_SESSION['status'] = "Task Deleted Successfully";
    $_SESSION['status_code'] = "success";
    header("Location: task_log.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Task Log</title>
    <link rel="stylesheet" href="style/task_log.css">
    <link rel="icon" href="./img/TaskTrackerAdmin.png" type="image/png" />
</head>
<body>
    <h1>Task Log</h1>
    <?php if (isset($_SESSION['status'])): ?>
        <div class="alert alert-<?= $_SESSION['status_code'] ?>">
            <?= $_SESSION['status'] ?>
        </div>
        <?php unset($_SESSION['status'], $_SESSION['status_code']); ?>
    <?php endif; ?>
    <table>
        <thead>
            <tr>
                <th>Task_ID</th>
                <th>Student ID</th>
                <th>Task Course</th>
                <th>Task Name</th>
                <th>Deadline</th>
                <th>Priority</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($task = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $task['id'] ?></td>
                    <td><?= $task['student_id'] ?></td>
                    <td><?= $task['task_course'] ?></td>
                    <td><?= $task['task_name'] ?></td>
                    <td><?= $task['deadline'] ?></td>
                    <td><?= $task['priority'] ?></td>
                    <td>
                        <form method="POST" action="task_log.php">
                            <input type="hidden" name="taskId" value="<?= $task['id'] ?>">
                            <button type="submit" name="deleteTask">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <button onclick="window.location.href='admin_dashboard.php'">Return to Dashboard</button>
</body>
</html>
