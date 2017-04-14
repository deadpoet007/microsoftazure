<?php
$servername = "shap2353541893.db.2353541.hostedresource.com:3313";
$username = "shap2353541893";
$password = "Ed@t=Ge-6B+K";
$dbname = "shap2353541893";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$id,$name,$text;

$sql = "INSERT INTO data_to_be_printed_custom_vase (ID, NAME, CUSTOM_TEXT_TO_BE_PRINTED)
VALUES ('$id', '$name', '$text')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?> 