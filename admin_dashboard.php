<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style/admin_dashboard.css">
    <link rel="icon" href="./img/TaskTrackerAdmin.png" type="image/png" />
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>

        <!-- Users Section -->
        <div class="section">
            <h2>Users</h2>
            <div class="dashboard-info">
                <?php
                session_start();
                include("config.php");

                // Total Users
                $totalUsersQuery = "SELECT COUNT(*) AS totalUsers FROM `tbl_users`";
                $totalUsersResult = mysqli_query($con, $totalUsersQuery);
                $totalUsers = mysqli_fetch_assoc($totalUsersResult)['totalUsers'];

                // Total Online Users
                $totalOnlineUsersQuery = "SELECT COUNT(*) AS totalOnlineUsers FROM `tbl_users` WHERE `is_online` = 1";
                $totalOnlineUsersResult = mysqli_query($con, $totalOnlineUsersQuery);
                $totalOnlineUsers = mysqli_fetch_assoc($totalOnlineUsersResult)['totalOnlineUsers'];

                // Total Offline Users
                $totalOfflineUsersQuery = "SELECT COUNT(*) AS totalOfflineUsers FROM `tbl_users` WHERE `is_online` = 0";
                $totalOfflineUsersResult = mysqli_query($con, $totalOfflineUsersQuery);
                $totalOfflineUsers = mysqli_fetch_assoc($totalOfflineUsersResult)['totalOfflineUsers'];

                // Banned Users
                $bannedUsersQuery = "SELECT COUNT(*) AS bannedUsers FROM `tbl_users` WHERE `ban_end` > NOW()";
                $bannedUsersResult = mysqli_query($con, $bannedUsersQuery);
                $bannedUsers = mysqli_fetch_assoc($bannedUsersResult)['bannedUsers'];

                // Outputting the user dashboard information
                ?>
                
                <!-- Display user information -->
                <p>Total Users: <?php echo $totalUsers; ?></p>
                <p>Total Online Users: <?php echo $totalOnlineUsers; ?></p>
                <p>Total Offline Users: <?php echo $totalOfflineUsers; ?></p>
                <p>Banned Users: <?php echo $bannedUsers; ?></p>
            </div>
            <button onclick="window.location.href='users.php'">View Users</button>
        </div>

        <!-- Tasks Section -->
        <div class="section">
            <h2>Tasks</h2>
            <div class="dashboard-info">
                <?php
                // Total Tasks
                $totalTasksQuery = "SELECT COUNT(*) AS totalTasks FROM `tbl_tasklist`";
                $totalTasksResult = mysqli_query($con, $totalTasksQuery);
                $totalTasks = mysqli_fetch_assoc($totalTasksResult)['totalTasks'];

                // Total Active Tasks
                $totalActiveTasksQuery = "SELECT COUNT(*) AS totalActiveTasks FROM `tbl_tasklist` WHERE `mark_as_done` = 0 AND `deadline` > NOW()";
                $totalActiveTasksResult = mysqli_query($con, $totalActiveTasksQuery);
                $totalActiveTasks = mysqli_fetch_assoc($totalActiveTasksResult)['totalActiveTasks'];

                // Total Expired Tasks
                $totalExpiredTasksQuery = "SELECT COUNT(*) AS totalExpiredTasks FROM `tbl_tasklist` WHERE `deadline` < NOW()";
                $totalExpiredTasksResult = mysqli_query($con, $totalExpiredTasksQuery);
                $totalExpiredTasks = mysqli_fetch_assoc($totalExpiredTasksResult)['totalExpiredTasks'];

                // Total Finished Tasks
                $totalFinishedTasksQuery = "SELECT COUNT(*) AS totalFinishedTasks FROM `tbl_tasklist` WHERE `mark_as_done` = 1";
                $totalFinishedTasksResult = mysqli_query($con, $totalFinishedTasksQuery);
                $totalFinishedTasks = mysqli_fetch_assoc($totalFinishedTasksResult)['totalFinishedTasks'];

                // Total High Priority Tasks
                $totalHighPriorityTasksQuery = "SELECT COUNT(*) AS totalHighPriorityTasks FROM `tbl_tasklist` WHERE `priority` = 'High'";
                $totalHighPriorityTasksResult = mysqli_query($con, $totalHighPriorityTasksQuery);
                $totalHighPriorityTasks = mysqli_fetch_assoc($totalHighPriorityTasksResult)['totalHighPriorityTasks'];

                // Total Medium Priority Tasks
                $totalMediumPriorityTasksQuery = "SELECT COUNT(*) AS totalMediumPriorityTasks FROM `tbl_tasklist` WHERE `priority` = 'Medium'";
                $totalMediumPriorityTasksResult = mysqli_query($con, $totalMediumPriorityTasksQuery);
                $totalMediumPriorityTasks = mysqli_fetch_assoc($totalMediumPriorityTasksResult)['totalMediumPriorityTasks'];

                // Total Low Priority Tasks
                $totalLowPriorityTasksQuery = "SELECT COUNT(*) AS totalLowPriorityTasks FROM `tbl_tasklist` WHERE `priority` = 'Low'";
                $totalLowPriorityTasksResult = mysqli_query($con, $totalLowPriorityTasksQuery);
                $totalLowPriorityTasks = mysqli_fetch_assoc($totalLowPriorityTasksResult)['totalLowPriorityTasks'];

                // Outputting the task dashboard information
                ?>
                
                <!-- Display task information -->
                <p>Total Tasks: <?php echo $totalTasks; ?></p>
                <p>Total Active Tasks: <?php echo $totalActiveTasks; ?></p>
                <p>Total Expired Tasks: <?php echo $totalExpiredTasks; ?></p>
                <p>Total Finished Tasks: <?php echo $totalFinishedTasks; ?></p>
                <p>Total High Priority Tasks: <?php echo $totalHighPriorityTasks; ?></p>
                <p>Total Medium Priority Tasks: <?php echo $totalMediumPriorityTasks; ?></p>
                <p>Total Low Priority Tasks: <?php echo $totalLowPriorityTasks; ?></p>
            </div>
            <button onclick="window.location.href='task_log.php'">View Task Log</button>
        </div>

    </div>
</body>
</html>
