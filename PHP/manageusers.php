<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List | Gondar Health Insurance</title>
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Body and Background Styling */
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

        .back-to-home i {
            margin-right: 8px;
            font-size: 18px;
        }

        .back-to-home span {
            font-size: 14px;
            font-weight: 500;
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

        .status-dropdown {
            padding: 6px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            text-align: center;
            background-color: #f9f9f9;
            width: 100px;
            color: #333;
        }

        .status-dropdown.active {
            background-color: #28a745;
            color: white;
        }

        .status-dropdown.deactivated {
            background-color: #dc3545;
            color: white;
        }
    </style>
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

    // Query to fetch Username, First_Name, UserType, Email, and Status from registered users where UserType is 'user'
    $sql = "SELECT Username, First_Name, UserType, Email, Status FROM registered_user WHERE UserType = 'user'"; 
    $result = $conn->query($sql);

    if (!$result) {
        die("<p class='status-message error'>Error in query execution: " . $conn->error . "</p>");
    }

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Username</th><th>First Name</th><th>Email</th><th>User Type</th><th>Status</th></tr>";

        while($row = $result->fetch_assoc()) {
            $statusClass = $row["Status"] === 'Active' ? 'active' : 'deactivated';

            echo "<tr>
                    <td>" . htmlspecialchars($row["Username"]) . "</td>
                    <td>" . htmlspecialchars($row["First_Name"]) . "</td>
                    <td>" . htmlspecialchars($row["Email"]) . "</td>
                    <td>" . htmlspecialchars($row["UserType"]) . "</td>
                    <td>
                        <select class='status-dropdown $statusClass' onchange='changeStatus(this, \"" . htmlspecialchars($row["Username"]) . "\")'>
                            <option value='Active'" . ($row["Status"] === 'Active' ? ' selected' : '') . ">Active</option>
                            <option value='Deactivated'" . ($row["Status"] === 'Deactivated' ? ' selected' : '') . ">Deactivated</option>
                        </select>
                    </td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "<p class='status-message error'>No users found.</p>";
    }

    $conn->close();
    ?>

</div>

<script>
    function changeStatus(selectElement, username) {
        var status = selectElement.value;
        
        // Remove existing active/deactivated class
        selectElement.classList.remove('active', 'deactivated');
        
        // Add new class based on selected value
        if (status === 'Active') {
            selectElement.classList.add('active');
        } else {
            selectElement.classList.add('deactivated');
        }

        // Send AJAX request to update the status in the database
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_status.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log('Status updated successfully');
            } else {
                console.error('Failed to update status');
            }
        };
        xhr.send('username=' + encodeURIComponent(username) + '&status=' + encodeURIComponent(status));
    }
</script>

</body>
</html>
