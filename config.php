<?php

$conn = new mysqli("localhost", "root", "", "usertable");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


?>