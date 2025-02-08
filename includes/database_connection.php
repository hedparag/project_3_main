<?php
    $host = "localhost";
    $port = "5432";
    $dbname = "regdb";
    $user = "postgres";
    $password = "1234";

    $conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

    $conn = pg_connect($conn_string);

    $connection_msg = null;

    if (!$conn) {
        $connection_msg = "Error: Unable to open database\n";
    } else {
        $connection_msg = "Connected to the database successfully!\n";
    }
?>