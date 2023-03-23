<?php

include 'config.php';

$con = @mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

if ( !$con ) {
    throw new Exception( "Database Connection Failed" );
} else {
    echo "Connected </br>";

    // $addTask = mysqli_query( $con, "INSERT into tasks (title, date) VALUE ('Make your bed', '2023-05-19')" );
    // echo $addTask ? "Task added successfully" : "Task didn't add something wrong";

    $results = mysqli_query( $con, "SELECT * FROM tasks" );

    while ( $data = mysqli_fetch_assoc( $results ) ) {
        print_r( $data );
    }

    mysqli_close( $con );
}