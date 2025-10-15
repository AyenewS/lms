<?php
$host = "https://auth-db430.hstgr.io/index.php?db=u376937047_anbes_lms_db";
$user = "u376937047_anbes";
$pass = "BoA@12345!";
$dbname = "u376937047_anbes_lms_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

