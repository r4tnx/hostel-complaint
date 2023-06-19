<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: student_dashboard.php'); // Redirect to the student dashboard if already logged in
    exit();
}

// Process the login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Database connection
    $conn = new PDO('mysql:host=localhost:3306;dbname=complainwebsite;charset=utf8mb4', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the query to fetch user information
    $stmt = $conn->prepare("SELECT id, role FROM users WHERE username = :username AND password = :password");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);

    // Execute the query
    $stmt->execute();

    // Fetch the user information
    $user = $stmt->fetch();

    // If the query returns a matching user
    if ($user) {
        // Store the user's ID and role in the session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        // Redirect the user to the appropriate page based on their role
        if ($user['role'] === 'student') {
            header('Location: student_dashboard.php');
            exit();
        } else if ($user['role'] === 'management') {
            header('Location: management_dashboard.php');
            exit();
        }
    } else {
        // Invalid credentials, show an error message or redirect back to the login page
        echo 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-sm bg-white p-8 rounded shadow-md">
            <h1 class="text-2xl font-bold text-center mb-4">Login</h1>

            <form action="login.php" method="POST" class="space-y-4">
                <div>
                    <label for="username" class="block">Username:</label>
                    <input type="text" id="username" name="username" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label for="password" class="block">Password:</label>
                    <input type="password" id="password" name="password" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <input type="submit" value="Login" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded cursor-pointer">
                </div>
            </form>
        </div>
    </div>
</body>
</html>


