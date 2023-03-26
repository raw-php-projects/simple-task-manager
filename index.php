<?php

// Database conection
include "config.php";
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if( !$connection ){
    throw new Exception("Database not connected");
}

$query = "SELECT * FROM tasks WHERE complete = 0 ORDER BY date DESC";
$results = mysqli_query($connection, $query);

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
                    while( $completeTaskData = mysqli_fetch_assoc($completeResults) ){ 
                    $timestamp = strtotime( $completeTaskData['date'] );
                    $completeDate = date( 'jS M, Y', $timestamp );
                ?>
                <tr>
                    <td><input class="label-inline" type="checkbox" value="<?php echo $data['id']; ?>"></td>
                    <td><?php echo $completeTaskData['id']; ?></td>
                    <td><?php echo $completeTaskData['title']; ?></td>
                    <td><?php echo $completeDate; ?></td>
                    <td><a class="delete" data-taskid="" href='#'>Delete</a> | <a class="incomplete" data-taskid="<?php echo $data['id']; ?>" href="#">Mar Incomplete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
    
    <!-- Upcoming Task -->
    <?php 
        if( mysqli_num_rows($results) == 0 ){
            echo "<p>No task found</p>";
        }else{
    ?>
        <h4>Upcoming Task</h4>
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
                    while( $data = mysqli_fetch_assoc($results) ){ 
                    $timestamp = strtotime( $data['date'] );
                    $date = date( 'jS M, Y', $timestamp );
                ?>
                <tr>
                    <td><input class="label-inline" type="checkbox" value="<?php echo $data['id']; ?>"></td>
                    <td><?php echo $data['id']; ?></td>
                    <td><?php echo $data['title']; ?></td>
                    <td><?php echo $date; ?></td>
                    <td><a class="delete" data-taskid="" href='#'>Delete</a> | <a class="complete" data-taskid="<?php echo $data['id']; ?>" href="#">Complete</a>
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
    <?php } ?>
    <p>..................</p>
    <h4>Add Tasks</h4>
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

<form action="tasks.php" method="post" id="complete-task">
    <input type="hidden" id="caction" name="action" value="complete">
    <input type="hidden" id="complete-task-id" name="completeTaskId">
</form>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script>
    ;(function($){
        $(document).ready(function(){
            $(".complete").on('click', function(){
                let id = $(this).data('taskid');
                $("#complete-task-id").val(id);
                $("#complete-task").submit();
            });
        });
    })(jQuery);
</script>
</body>

</html>