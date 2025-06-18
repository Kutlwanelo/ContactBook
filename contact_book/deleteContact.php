<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli("localhost", "root", "mysql", "contact_book");


if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

$id = $_GET["id"] ?? "";
if (empty($id) || !is_numeric($id)) {
    echo json_encode(["error" => "Invalid or missing contact ID"]);
    exit();
}

$stmt = $conn->prepare("DELETE FROM contacts WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["message" => "Contact deleted successfully"]);
} else {
    echo json_encode(["error" => "Failed to delete contact: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
