<?php
include 'connection.php'; 

session_start();
if (!isset($_SESSION['email'])) {
    header("Location:login-ownr.php");
    exit();
}

if (isset($_GET['id'])) {
    $hostel_id = $_GET['id'];

    $query = "DELETE FROM users WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $hostel_id);
    
    if ($stmt->execute()) {
        header("Location: std-List.php?message=Hostel deleted successfully");
    } else {
        header("Location: std-List.php?message=Error deleting hostel");
    }
    
    $stmt->close();
    $con->close();
} else {
  
    header("Location: std-List.php");
}
?>
