<?php

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from form
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $food = $_POST['food'];
    $quantity = $_POST['quantity'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "order_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO orders (name, phone, email, address, food, quantity) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $name, $phone, $email, $address, $food, $quantity);

        // Execute the statement
        if ($stmt->execute()) {
            session_start();
            $_SESSION['success_message'] = "New record created successfully";
            header("Location: index.php");
            exit();
            
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
} else {
    echo "Invalid request method.";
}
?>