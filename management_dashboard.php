<?php
session_start();

// Check the user's role before granting access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'management') {
    header('Location: login.php'); // Redirect to the login page if not logged in or not management
    exit();
}

// Database connection
 $conn = new PDO('mysql:host=localhost:3306;dbname=complainwebsite;charset=utf8mb4', 'root', '');
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Retrieve complaints from the database
$stmt = $conn->prepare("SELECT complaints.*, users.username FROM complaints JOIN users ON complaints.user_id = users.id");
$stmt->execute();
$complaints = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="flex flex-col items-center justify-center  bg-gray-100">
    <div class="flex">
        <div><div>
        <form method="POST" action="logout.php">
        <input class="mt-4 mb-5 bg-red-500 hover:bg-red-600  text-white font-bold py-2 px-4 rounded cursor-pointer" type="submit" value="Logout">
</form>
    </div>
    
    <div class="bg-white p-8">
        <h1 class="text-2xl font-bold text-center mb-4">Management Dashboard</h1>

        <h2 class="text-center text-xl font-semibold mb-4">Complaints</h2>
        <table class="w-full">
            <thead>
                <tr>
                    <th class="w-80 px-4 py-2 bg-gray-200 text-center">Complaint ID</th>
                    <th class="w-80 px-4 py-2 bg-gray-200 text-center">Student</th>
                    <th class="w-80 px-4 py-2 bg-gray-200 text-center">Subject</th>
                    <th class="w-96 px-4 py-2 bg-gray-200 text-center">Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($complaints as $complaint) : ?>
                    <tr>
                        <td class="px-4 py-2 text-center"><?php echo $complaint['id']; ?></td>
                        <td class="px-4 py-2 text-center"><?php echo $complaint['username']; ?></td>
                        <td class="px-4 py-2 text-center"><?php echo $complaint['subject']; ?></td>
                        <td class="px-4 py-2 text-center"><?php echo $complaint['description']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>




