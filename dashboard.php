<?php
session_start();

// Redirect to login page if the admin is NOT logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "enrollment_db");


// Fetch student data
$sql = "SELECT * FROM students ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="LOGO STA. CRUZ.png" image="image/x-icon">
    <title>Admin Dashboard</title>
    <style>
        /* General Page Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #eef2f3, #8e9eab);
            display: flex;
        }

        /* Sidebar with 3D Effect */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: linear-gradient(145deg, #2e2e2e, #3a3a3a);
            color: white;
            position: fixed;
            padding: 20px;
            box-shadow: 8px 8px 15px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 12px;
            margin: 10px 0;
            background: linear-gradient(145deg, #393939, #2e2e2e);
            text-align: center;
            border-radius: 8px;
            box-shadow: 3px 3px 6px rgba(0, 0, 0, 0.3), 
                        -3px -3px 6px rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .sidebar a:hover {
            background: #444;
            transform: translateY(-2px);
        }

        /* Main Content */
        .content {
            margin-left: 280px;
            padding: 20px;
            width: calc(100% - 280px);
        }

        h1 {
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* Search Box with Glassmorphism */
        .search-box {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            box-shadow: inset 4px 4px 8px rgba(0, 0, 0, 0.2),
                        inset -4px -4px 8px rgba(255, 255, 255, 0.3);
            font-size: 16px;
            color: #333;
        }

        /* Table with 3D Row Effects */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: linear-gradient(145deg, #222, #333);
            color: white;
        }

        tr {
            transition: all 0.3s ease;
        }

        tr:hover {
            background: rgba(0, 0, 0, 0.05);
            transform: scale(1.02);
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Action Buttons */
        .btn {
            text-decoration: none;
            padding: 8px 12px;
            background: linear-gradient(145deg, #28a745, #23963b);
            color: white;
            border-radius: 5px;
            box-shadow: 3px 3px 6px rgba(0, 0, 0, 0.2), 
                        -3px -3px 6px rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: #1e7a34;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="logout.php">Logout</a>
        <a href="section.php">Sections</a>
    </div>

    <div class="content">
        <h1>Welcome, Admin</h1>
        <input type="text" id="searchBox" class="search-box" placeholder="Search by name or LRN..." onkeyup="searchTable()">
        
        <h2>Student Enrollment Records</h2>
        <table id="studentTable">
            <thead>
                <tr>
                    <th>LRN</th>
                    <th>Name</th>
                    <th>Grade</th>
                    <th>Track</th>
                    <th>Strand</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['lrn']; ?></td>
                        <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                        <td><?php echo $row['grade']; ?></td>
                        <td><?php echo $row['track']; ?></td>
                        <td><?php echo $row['strand']; ?></td>
                        <td>
                            <a href="print.php?lrn=<?php echo $row['lrn']; ?>" class="btn">Print</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        function searchTable() {
            let input = document.getElementById("searchBox").value.toLowerCase();
            let rows = document.querySelectorAll("#studentTable tbody tr");

            rows.forEach(row => {
                let name = row.cells[1].textContent.toLowerCase();
                let lrn = row.cells[0].textContent.toLowerCase();
                row.style.display = (name.includes(input) || lrn.includes(input)) ? "" : "none";
            });
        }
    </script>

</body>
</html>
