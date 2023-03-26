<?php
include "config.php";
$connection = @mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

if ( !$connection ) {
    throw new Exception( "Database Connection Failed" );
} else {
    $action = $_POST['action'] ?? '';
    if ( !$action ) {
        header( "Location: index.php" );
        die();
    } else {
        if( 'add' == $action ){
            // Insert Task
            $title = $_POST['title'];
            $date  = $_POST['date'];

            if ( $title && $date ) {
                $query = "INSERT INTO tasks (title, date) VALUE ('$title', '$date')";
                mysqli_query( $connection, $query );
                header( "Location: index.php?added=true" );
            }
        }else if( 'complete' == $action ){
            // Complete Task
            $taskId = $_POST['completeTaskId'];
            if( $taskId ){
                $update = "UPDATE tasks SET complete=1 WHERE id={$taskId} LIMIT 1";
                mysqli_query($connection, $update);
            }
            header( "Location: index.php" );
        }else if ( 'incomplete' == $action ) {
            // In Complete task            
            $taskId = $_POST['inCompleteTaskId'];
            if( $taskId ){
                $update = "UPDATE tasks SET complete=0 WHERE id={$taskId} LIMIT 1";
                mysqli_query($connection, $update);
            }
            header( "Location: index.php" );
        }else if ( 'delete' == $action ) {
            // Delete task            
            $taskId = $_POST['deleteTaskId'];
            if( $taskId ){
                $delete = "DELETE FROM tasks WHERE id={$taskId} LIMIT 1";
                mysqli_query($connection, $delete);
            }
            header( "Location: index.php" );
        }
    }
}
mysqli_close( $connection );