<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "mysql", "contact_book");

if($conn->connect_error){
  echo json_encode(["error" => "Database connection failed"]);
  exit();
}
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$mobile= $_POST["mobile"];
$email = $_POST["email"];
$avatar = $_FILES["avatar"]["name"];

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["avatar"]["name"]);
move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);

$sql = "INSERT INTO contacts (firstname, lastname, mobile, email, avatar) VALUES ('$firstname', '$lastname', '$mobile', '$email', '$avatar')";
if ($conn->query($sql) === TRUE){
  echo json_encode(["message" => "Contact added successfully"]);
 
} else{
  echo json_encode(["error" => "Failed to add contact"]);
}

?>