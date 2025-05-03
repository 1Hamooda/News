<?php

$conn = new mysqli("localhost", "root", "", "usertable");

$conn->select_db("usertable");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id, name, email, password, role FROM gamers";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error); // Shows MySQL error message
}

?>