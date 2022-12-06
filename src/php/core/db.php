<?php

function establish() {
    $host = 'mariadb';
    $user = 'kmatest';
    $password = 'kmatest';

    $conn = new mysqli($host, $user, $password);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function createPredefinedTables($connection) {
    $query = "CREATE TABLE IF NOT EXISTS kmatest.logs (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                url VARCHAR(255) NOT NULL,
                method VARCHAR(30) NOT NULL,
                response_status_code INT(3) UNSIGNED NULL,
                response_headers TEXT NULL,
                response_content JSON NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
    )";

    if (!mysqli_query($connection, $query)) {
        echo 'Error while creating table: ' . mysqli_error($connection);
    }
}

function insertToLogs($url, $method, $statusCode, $headers, $content) {
    $connection = establish();

    $query = 'INSERT INTO kmatest.logs (url, method, response_status_code, response_headers, response_content)
              VALUES (
                      "' . $url . '", ' .
                      '"' . $method . '", ' .
                      $statusCode . ', ' .
                      '"' . $headers . '", ' .
                      '\'' . $content . '\')';


    if (!mysqli_query($connection, $query)) {
        echo 'Error when insert: ' . $connection->connect_errno;

        var_dump($query);
    }

    $connection->close();
}

function getRequestCount() {
    $connection = establish();

    $query = 'SELECT count(*) from kmatest.logs';
    $subQuery = 'SELECT count(*) from kmatest.logs where response_headers like "%content-type: text/html%"';

    $result = mysqli_query($connection, $query);
    $result = mysqli_fetch_row($result);

    $subResult = mysqli_query($connection, $subQuery);
    $subResult = mysqli_fetch_row($subResult);
    

    echo 'Requests Total: ' . $result[0] . '<br>';
    echo 'Requests with specific headers: ' . $subResult[0];
}