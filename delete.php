<?php
$conn = new mysqli("localhost", "root", "", "enrollment_db");
$lrn = $_GET['lrn'];
$sql = "DELETE FROM students WHERE lrn = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $lrn);
$stmt->execute();
header("Location: dashboard.php");
?>
