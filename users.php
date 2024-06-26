<?php
session_start();
include("config.php");

$unbanned_users_query = "SELECT * FROM `tbl_users` WHERE `ban_end` IS NULL OR `ban_end` < NOW()";
$unbanned_users_result = mysqli_query($con, $unbanned_users_query);

$banned_users_query = "SELECT * FROM `tbl_users` WHERE `ban_end` IS NOT NULL AND `ban_end` > NOW()";
$banned_users_result = mysqli_query($con, $banned_users_query);

if(isset($_POST['banUser'])) {
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

if(isset($_POST['unbanUser'])) {
    $studentId = $_POST['studentId'];

    $unbanQuery = "UPDATE `tbl_users` SET `ban_end`=NULL WHERE `student_id`='$studentId'";
    mysqli_query($con, $unbanQuery);

    $_SESSION['status'] = "User Unbanned";
    $_SESSION['status_code'] = "success";
    header("Location: users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Users</title>
    <link rel="stylesheet" href="style/users.css">
    <link rel="icon" href="./img/TaskTrackerAdmin.png" type="image/png" />
</head>
<body>
    <h1>Users</h1>
    <?php if (isset($_SESSION['status'])): ?>
        <div class="alert alert-<?= $_SESSION['status_code'] ?>">
            <?= $_SESSION['status'] ?>
        </div>
        <?php unset($_SESSION['status'], $_SESSION['status_code']); ?>
    <?php endif; ?>

    <h2>Unbanned Users</h2>
    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($user = mysqli_fetch_assoc($unbanned_users_result)): ?>
                <tr>
                    <td><?= $user['student_id'] ?></td>
                    <td><?= $user['firstname'] . ' ' . $user['lastname'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td>
                        <form method="POST" action="users.php">
                            <input type="hidden" name="studentId" value="<?= $user['student_id'] ?>">
                            <select name="banDuration">
                                <option value="24 hours">24 Hours</option>
                                <option value="3 days">3 Days</option>
                                <option value="1 week">1 Week</option>
                                <option value="1 month">1 Month</option>
                                <option value="1 year">1 Year</option>
                            </select>
                            <button type="submit" name="banUser">Ban</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h2>Banned Users</h2>
    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Ban Duration</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($user = mysqli_fetch_assoc($banned_users_result)): ?>
                <tr>
                    <td><?= $user['student_id'] ?></td>
                    <td><?= $user['firstname'] . ' ' . $user['lastname'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td>
                        <?php
                            $banEnd = strtotime($user['ban_end']);
                            $now = time();
                            $duration = $banEnd - $now;
                            $duration_text = '';

                            if ($duration > 0) {
                                $days = floor($duration / (60 * 60 * 24));
                                $hours = floor(($duration % (60 * 60 * 24)) / (60 * 60));
                                $minutes = floor(($duration % (60 * 60)) / 60);

                                if ($days > 0) {
                                    $duration_text .= "$days days ";
                                }
                                if ($hours > 0) {
                                    $duration_text .= "$hours hours ";
                                }
                                if ($minutes > 0) {
                                    $duration_text .= "$minutes minutes ";
                                }
                            } else {
                                $duration_text = 'Expired';
                            }

                            echo $duration_text;
                        ?>
                    </td>
                    <td>
                        <form method="POST" action="users.php">
                            <input type="hidden" name="studentId" value="<?= $user['student_id'] ?>">
                            <button type="submit" name="unbanUser">Unban</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <button onclick="window.location.href='admin_dashboard.php'">Return to Dashboard</button>
</body>
</html>
