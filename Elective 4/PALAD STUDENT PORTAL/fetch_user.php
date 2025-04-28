<?php
include("cn.php");

if (isset($_POST["id"])) {
    $id = $_POST["id"];
    $stmt = $connection->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("s", id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["error" => "User not found"]);
    }

    $stmt->close();
}
?>