<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List | Gondar Health Insurance</title>
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('images/bg14.jpg');
            background-size: cover;
            background-position: center;
            color: #333;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .back-to-home {
            position: absolute;
            top: 20px;
            right: 20px;
            text-decoration: none;
            color: #fff;
            background: #007bff;
            border-radius: 8px;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background 0.3s, transform 0.3s;
        }

        .back-to-home:hover {
            background: #0056b3;
            transform: scale(1.1);
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            padding: 30px;
            max-width: 800px;
            width: 100%;
        }

        h2 {
            text-align: center;
            color: #444;
            font-size: 24px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .delete-btn {
            color: #fff;
            background-color: #dc3545;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        /* Confirmation Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 300px;
            border-radius: 10px;
            text-align: center;
        }

        .modal-header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .modal-footer {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .modal-btn {
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            border: none;
            font-size: 14px;
        }

        .btn-confirm {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-cancel {
            background-color: #6c757d;
            color: #fff;
        }

        .btn-confirm:hover {
            background-color: #c82333;
        }

        .btn-cancel:hover {
            background-color: #5a6268;
        }
    </style>

    <script>
        function confirmDelete(username) {
            var modal = document.getElementById("confirmModal");
            var confirmBtn = document.getElementById("confirmDeleteBtn");

            // Display the modal
            modal.style.display = "flex";

            // Set the username to be deleted
            confirmBtn.onclick = function() {
                document.getElementById("deleteUserForm").submit();
            };
        }

        function closeModal() {
            var modal = document.getElementById("confirmModal");
            modal.style.display = "none";
        }
    </script>
</head>
<body>

<a href="admin.php" class="back-to-home"><i class="fas fa-home"></i><span>Back to Home</span></a>

<div class="container">
    <h2>Users List</h2>

    <?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "final_project";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("<p class='status-message error'>Connection failed: " . $conn->connect_error . "</p>");
    }

    // Handle user deletion
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_user'])) {
        $userToDelete = $_POST['delete_user'];

        // Prepare the SQL statement to delete user
        $stmt = $conn->prepare("DELETE FROM Users WHERE Username = ?");
        $stmt->bind_param("s", $userToDelete);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>User '" . htmlspecialchars($userToDelete) . "' deleted successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error deleting user: " . $conn->error . "</p>";
        }

        $stmt->close();
    }

    // Fetch users from the Users table
    $sql = "SELECT Username, FirstName, Email, UserType, Status FROM Users WHERE UserType = 'user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Username</th><th>First Name</th><th>Email</th><th>User Type</th><th>Status</th><th>Actions</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['Username']) . "</td>
                    <td>" . htmlspecialchars($row['FirstName']) . "</td>
                    <td>" . htmlspecialchars($row['Email']) . "</td>
                    <td>" . htmlspecialchars($row['UserType']) . "</td>
                    <td>" . htmlspecialchars($row['Status']) . "</td>
                    <td>
                        <form id='deleteUserForm' method='POST' style='display:inline;'>
                            <input type='hidden' name='delete_user' value='" . htmlspecialchars($row['Username']) . "'>
                            <button type='button' class='delete-btn' onclick='confirmDelete(\"" . htmlspecialchars($row['Username']) . "\")'>Delete</button>
                        </form>
                    </td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No users found.</p>";
    }

    $conn->close();
    ?>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">Are you sure?</div>
        <p>You are about to delete this user account. This action cannot be undone.</p>
        <div class="modal-footer">
            <button class="modal-btn btn-confirm" id="confirmDeleteBtn">Yes, Delete</button>
            <button class="modal-btn btn-cancel" onclick="closeModal()">Cancel</button>
        </div>
    </div>
</div>

</body>
</html>
