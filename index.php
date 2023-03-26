<?php
// Database conection
include "config.php";
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check if database connectd else throw an error
if( !$connection ){
    throw new Exception("Database not connected");
}

// Select all in completed tasks
$query = "SELECT * FROM tasks WHERE complete = 0 ORDER BY date DESC";
$results = mysqli_query($connection, $query);

// Select all completed tasks
$queryCompleteTask = "SELECT * FROM tasks WHERE complete = 1 ORDER BY date DESC";
$completeResults = mysqli_query($connection, $queryCompleteTask);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Todo/Tasks</title>
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
    <style>
        body {
            margin-top: 30px;
        }

        #main {
            padding: 0px 150px 0px 150px;;
        }

        #action {
            width: 150px;
        }
    </style>
</head>
<body>
<div class="container" id="main">
    <h1>Tasks Manager</h1>
    <p>This is a sample project for managing our daily tasks. We're going to use HTML, CSS, PHP, JavaScript and MySQL
        for this project</p>

    <!-- Completed Tasks -->
    <?php if( mysqli_num_rows($completeResults) > 0 ){ ?>
        <h4>Complete Task</h4>
        <table>
            <thead>
            <tr>
                <th></th>
                <th>Id</th>
                <th>Task</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                <?php
                    // Query Completed Taks
                    while( $completeTaskData = mysqli_fetch_assoc($completeResults) ){ 
                    $timestamp = strtotime( $completeTaskData['date'] );
                    $completeDate = date( 'jS M, Y', $timestamp );
                ?>
                <tr>
                    <td><input class="label-inline" type="checkbox" value="<?php echo $data['id']; ?>"></td>
                    <td><?php echo $completeTaskData['id']; ?></td>
                    <td><?php echo $completeTaskData['title']; ?></td>
                    <td><?php echo $completeDate; ?></td>
                    <td><a class="delete" data-taskid="<?php echo $completeTaskData['id']; ?>" href='#'>Delete</a> | <a class="incomplete" data-taskid="<?php echo $completeTaskData['id']; ?>" href="#">Mark Incomplete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
    
    <!-- Upcoming Task -->
    <?php 
        if( mysqli_num_rows($results) == 0 ){
            echo "<h4>Upcoming Task</h4><p>No task found</p>";
        }else{
    ?>  
        <hr>
        <h4>Upcoming Task</h4>
        <form action="tasks.php" method="post">
            <table>
                <thead>
                <tr>
                    <th></th>
                    <th>Id</th>
                    <th>Task</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                        // Query In Completed Taks
                        while( $data = mysqli_fetch_assoc($results) ){ 
                        $timestamp = strtotime( $data['date'] );
                        $date = date( 'jS M, Y', $timestamp );
                    ?>
                    <tr>
                        <td><input name="taskids[]" class="label-inline" type="checkbox" value="<?php echo $data['id']; ?>"></td>
                        <td><?php echo $data['id']; ?></td>
                        <td><?php echo $data['title']; ?></td>
                        <td><?php echo $date; ?></td>
                        <td><a class="delete" data-taskid="<?php echo $data['id']; ?>" href='#'>Delete</a> | <a class="complete" data-taskid="<?php echo $data['id']; ?>" href="#">Complete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <select id="action" name="action" >
                <option value="0">With Selected</option>
                <option value="bulkdelete">Delete</option>
                <option value="bulkcomplete">Mark As Complete</option>
            </select>
            <input class="button-primary" id="bulksubmit" type="submit" value="Submit">
        </form>
    <?php } ?>

    <!-- Add Task Form-->
    <p>..................</p>
    <h4>Add Task</h4>
    <?php
        if ( !empty( $_GET['added'] ) ) {
            $added = $_GET['added'];
            echo '<p style="color:green">Task successfully added</p>';
        }
        ?>
        <form method="post" action="tasks.php">
            <fieldset>
                <label for="title">Task Title</label>
                <input type="text" placeholder="Task Title" id="title" name="title">
                <label for="date">Date</label>
                <input type="date" placeholder="Task Date" id="date" name="date">
                <input class="button-primary" type="submit" value="Add Task">
                <input type="hidden" name="action" value="add">
            </fieldset>
        </form>
    </div>

<!-- Task Complete form /hidden -->
<form action="tasks.php" method="post" id="complete-task">
    <input type="hidden" id="caction" name="action" value="complete">
    <input type="hidden" id="complete-task-id" name="completeTaskId">
</form>

<!-- Task In Complete form /hidden -->
<form action="tasks.php" method="post" id="in-complete-task">
    <input type="hidden" id="in-complete-action" name="action" value="incomplete">
    <input type="hidden" id="in-complete-task-id" name="inCompleteTaskId">
</form>

<!-- Task Delete form /hidden -->
<form action="tasks.php" method="post" id="delete-task">
    <input type="hidden" id="delete-action" name="action" value="delete">
    <input type="hidden" id="delete-task-id" name="deleteTaskId">
</form>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="./assets/js/task.js"></script>
</body>

</html>