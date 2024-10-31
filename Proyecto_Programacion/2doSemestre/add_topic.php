<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    // Handle file upload
    $target_dir = "pdfs/";
    $target_file = $target_dir . basename($_FILES["pdf"]["name"]);
    
    if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $target_file)) {
        // File uploaded successfully
        // Here you would typically add the new topic to a database
        // For this example, we'll just redirect back to the index page
        header("Location: index.php");
        exit();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>