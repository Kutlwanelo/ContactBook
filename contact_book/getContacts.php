<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "mysql", "contact_book");

if ($conn->connect_error){
  die(json_encode(["error" => "Datatbase connection failed"]));
}

if (isset($_GET['id'])){
  $id = intval($_GET['id']);

  $stmt = $conn->prepare("SELECT * FROM contacts WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute(); 

  $result = $stmt->get_result();
  $contact = $result->fetch_assoc();

  echo json_encode($contact);
} else {
    $result = $conn->query("SELECT * FROM contacts");
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}
?>