<?php
session_start();
include("config.php");

// Ban user
if (isset($_POST['banUser'])) {
    $studentId = $_POST['studentId'];
    $banDuration = $_POST['banDuration'];

    $banEnd = date('Y-m-d H:i:s', strtotime("+$banDuration"));

    $banQuery = "UPDATE `tbl_users` SET `ban_end`='$banEnd' WHERE `student_id`='$studentId'";
    mysqli_query($con, $banQuery);

    $_SESSION['status'] = "User Banned for $banDuration";
    $_SESSION['status_code'] = "success";
    header("Location: users.php");
    exit();
}

// Delete task
if (isset($_POST['deleteTask'])) {
    $taskId = $_POST['taskId'];

    $deleteQuery = "DELETE FROM `tbl_tasklist` WHERE `id`='$taskId'";
    mysqli_query($con, $deleteQuery);

    $_SESSION['status'] = "Task Deleted Successfully";
    $_SESSION['status_code'] = "success";
    header("Location: task_log.php");
    exit();
}   
?>
