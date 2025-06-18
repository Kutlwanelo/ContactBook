<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "mysql", "contact_book");

if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

$id = $_POST["id"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$mobile = $_POST["mobile"];
$email = $_POST["email"];


$avatar = '';
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $avatar = basename($_FILES["avatar"]["name"]);
    $targetDir = "uploads/";
    $targetFile = $targetDir . $avatar;
    move_uploaded_file($_FILES["avatar"]["tmp_name"], $targetFile);
    
 
    $sql = "UPDATE contacts SET firstname=?, lastname=?, mobile=?, email=?, avatar=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $firstname, $lastname, $mobile, $email, $avatar, $id);
} else {
  
    $sql = "UPDATE contacts SET firstname=?, lastname=?, mobile=?, email=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $firstname, $lastname, $mobile, $email, $id);
}

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Contact updated"]);
} else {
    echo json_encode(["error" => "Failed to update contact"]);
}
?>
