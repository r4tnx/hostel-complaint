<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: student_dashboard.php'); // Redirect to the student dashboard if already logged in
    exit();
}

// Process the registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Database connection
    $conn = new PDO('mysql:host=localhost:3306;dbname=complainwebsite;charset=utf8mb4', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the query to insert user information
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':role', $role);

    // Execute the query
    $stmt->execute();

    // Redirect the user to the login page or display a success message
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-sm bg-white p-8 rounded shadow-md">
            <h1 class="text-2xl font-bold text-center mb-4">Register</h1>

            <form action="register.php" method="POST" class="space-y-4">
                <div>
                    <label for="username" class="block">Username:</label>
                    <input type="text" id="username" name="username" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label for="password" class="block">Password:</label>
                    <input type="password" id="password" name="password" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label for="confirm_password" class="block">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label for="role" class="block">Role:</label>
                    <select id="role" name="role" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                        <option value="student">Student</option>
                        <option value="management">Management</option>
                    </select>
                </div>

                <div>
                    <input type="submit" value="Register" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded cursor-pointer">
                </div>
            </form>
        </div>
    </div>
</body>
</html>

