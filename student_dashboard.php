<?php
session_start();

// Check the user's role before granting access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php'); // Redirect to the login page if not logged in or not a student
    exit();
}

// Process the complaint creation form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'];
    $description = $_POST['description'];

    // Database connection
    $conn = new PDO('mysql:host=localhost:3306;dbname=complainwebsite;charset=utf8mb4', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the query to insert the complaint
    $stmt = $conn->prepare("INSERT INTO complaints (user_id, subject, description) VALUES (:user_id, :subject, :description)");
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->bindParam(':subject', $subject);
    $stmt->bindParam(':description', $description);

    // Execute the query
    $stmt->execute();

    // Redirect the user to a page confirming the complaint creation
    header('Location: student_dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
</head>

<form method="POST" action="logout.php">
        <input class="mt-4 bg-red-500 hover:bg-red-600 mx-5 text-white font-bold py-2 px-4 rounded cursor-pointer" type="submit" value="Logout">
</form>

<h1 class="mt-10 flex justify-center w-full text-2xl font-bold">Student Dashboard</h1>

<h2 class="flex justify-center w-full text-xl font-semibold mt-4">File a Complaint</h2>
<form method="POST" action="student_dashboard.php" class="mt-2 mx-20">
    <label for="subject" class="block">Subject:</label>
    <input type="text" name="subject" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
    <br>
    <label for="description" class="block">Description:</label>
    <textarea name="description" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"></textarea>
    <br>
    <div class="flex justify-center items-center">
        <input type="submit" value="Submit Complaint" class="flex justify-center items-center mx-40 mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded cursor-pointer">
    </div>
    
</form>


