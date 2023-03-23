<?php
include "config.php";
$action = $_POST['action'] ?? '';

if ( !$action ) {
    header( "Location: index.php" );
} else {

    $connection = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
    if ( !$connection ) {
        throw new Exception( "Database Connection Failed" );
    } else {
        $title = $_POST['title'];
        $date  = $_POST['date'];

        if ( $title && $date ) {
            $query = "INSERT INTO tasks (title, date) VALUE ('$title', '$date')";
            mysqli_query( $connection, $query );
            header( "Location: index.php?added=true" );
        }
        mysqli_close($connection);
    }
}