<?php
$host = "localhost"; /* Host name */
$user = "root"; /* User */
$password = ""; /* Password */
$dbname = "member"; /* Database name */

//get connection
$mysqli = new mysqli($host, $user, $password, $dbname);

if(!$mysqli){
    die("Connection failed: " . $mysqli->error);
}

?>