<?php
include "config.php";
$connection = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

if ( !$connection ) {
    throw new Exception( "Database Connection Failed" );
} else {
    $action = $_POST['action'] ?? '';
    if ( !$action ) {
        header( "Location: index.php" );
        die();
    } else {
        // Insert Task
        if( 'add' == $action ){
            $title = $_POST['title'];
            $date  = $_POST['date'];

            if ( $title && $date ) {
                $query = "INSERT INTO tasks (title, date) VALUE ('$title', '$date')";
                mysqli_query( $connection, $query );
                mysqli_close($connection);
                header( "Location: index.php?added=true" );
            }
        }elseif( 'complete' == $action ){
            $taskId = $_POST['completeTaskId'];
            if( $taskId ){
                $update = "UPDATE tasks SET complete=1 WHERE id={$taskId} LIMIT 1";
                mysqli_query($connection, $update);
                mysqli_close($connection);
            }
            header( "Location: index.php" );
        }
    }
}