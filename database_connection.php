<?php
    $host = "localhost";
    $port = "5432";
    $dbname = "regdb";
    $user = "postgres";
    $password = "1234";

    $conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

    $conn = pg_connect($conn_string);

    if (!$conn) {
        echo "Error: Unable to open database\n";
    } else {
        echo "Connected to the database successfully!\n";
    }
?>