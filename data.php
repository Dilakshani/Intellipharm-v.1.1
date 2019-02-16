<?php
//setting header to json
header('Content-Type: application/json');

include 'config.php';

if(isset($_POST['selectyear'])){
    $selected_year = $_POST['selectyear'];
} else {
    $selected_year = 2007;
}
                
//query to get data from the table
$query = sprintf("SELECT YEAR(`joined_date`) as Year,COUNT(`joined_date`) as NewSignUps FROM `members` GROUP BY YEAR(`joined_date`)");

//execute query
$result = $mysqli->query($query);

//loop through the returned data
$data = array();
foreach ($result as $row) {
    $data[] = $row;
}

//free memory associated with result
$result->close();

//close connection
$mysqli->close();

//now print the data
print json_encode($data);