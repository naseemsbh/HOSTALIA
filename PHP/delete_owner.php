<?php
include 'connection.php'; 

session_start();
if (!isset($_SESSION['email'])) {
    header("Location:admin-login.php");
    exit();
}

if (isset($_GET['id'])) {
    $hostel_id = $_GET['id'];

   
    $query = "DELETE FROM owners WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $hostel_id);
    
    if ($stmt->execute()) {
       
        header("Location: Hadmin.php?message=Hostel deleted successfully");
    } else {
      
        header("Location: Hadmin.php?message=Error deleting hostel");
    }
    
    $stmt->close();
    $con->close();
} else {
   
    header("Location: Hadmin.php");
}
?>
