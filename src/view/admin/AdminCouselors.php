<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "careercouncelors";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to validate input
function validateInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Handle Add, Edit, Delete actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add') {
            $UserID = validateInput($_POST['UserID']);
            $CounselorID = validateInput($_POST['CounselorID']);
            $verified = validateInput($_POST['verified']);
            $position = validateInput($_POST['position']);
            $specialization = validateInput($_POST['specialization']);
            $location = validateInput($_POST['location']);
            $status = validateInput($_POST['status']);
            $No_of_Connections = validateInput($_POST['No_of_Connections']);

            if (empty($UserID) || empty($CounselorID) || empty($verified) || empty($position) || empty($specialization) || empty($location) || empty($status) || empty($No_of_Connections)) {
                echo "All fields are required.";
            } else {
                $stmt = $conn->prepare("INSERT INTO counselors (UserID, CounselorID, verified, position, specialization, location, status, No_of_Connections) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("iiissssi", $UserID, $CounselorID, $verified, $position, $specialization, $location, $status, $No_of_Connections);

                if ($stmt->execute()) {
                    echo "Counselor added successfully.";
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            }

        } elseif ($action === 'edit') {
            $UserID = validateInput($_POST['UserID']);
            $CounselorID = validateInput($_POST['CounselorID']);
            $verified = validateInput($_POST['verified']);
            $position = validateInput($_POST['position']);
            $specialization = validateInput($_POST['specialization']);
            $location = validateInput($_POST['location']);
            $status = validateInput($_POST['status']);
            $No_of_Connections = validateInput($_POST['No_of_Connections']);

            if (empty($UserID) || empty($CounselorID) || empty($verified) || empty($position) || empty($specialization) || empty($location) || empty($status) || empty($No_of_Connections)) {
                echo "All fields are required.";
            } else {
                $stmt = $conn->prepare("UPDATE counselors SET verified = ?, position = ?, specialization = ?, location = ?, status = ?, No_of_Connections = ? WHERE UserID = ? AND CounselorID = ?");
                $stmt->bind_param("issssiii", $verified, $position, $specialization, $location, $status, $No_of_Connections, $UserID, $CounselorID);

                if ($stmt->execute()) {
                    echo "Counselor updated successfully.";
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            }

        } elseif ($action === 'delete') {
            $UserID = validateInput($_POST['UserID']);
            $CounselorID = validateInput($_POST['CounselorID']);

            if (empty($UserID) || empty($CounselorID)) {
                echo "UserID and CounselorID are required for deletion.";
            } else {
                $stmt = $conn->prepare("DELETE FROM counselors WHERE UserID = ? AND CounselorID = ?");
                $stmt->bind_param("ii", $UserID, $CounselorID);

                if ($stmt->execute()) {
                    echo "Counselor deleted successfully.";
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            }
        }
    }
}

// Fetch counselors for display
$result = $conn->query("SELECT * FROM counselors");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Counselors</title>
</head>
<body>
    <h1>Manage Counselors</h1>

    <!-- Add Counselor Form -->
    <h2>Add Counselor</h2>
    <form method="POST">
        <input type="hidden" name="action" value="add">
        <label>UserID:</label><input type="number" name="UserID" required><br>
        <label>CounselorID:</label><input type="number" name="CounselorID" required><br>
        <label>Verified:</label><input type="number" name="verified" required><br>
        <label>Position:</label><input type="text" name="position" required><br>
        <label>Specialization:</label><input type="text" name="specialization" required><br>
        <label>Location:</label><input type="text" name="location" required><br>
        <label>Status:</label><input type="text" name="status" required><br>
        <label>No of Connections:</label><input type="number" name="No_of_Connections" required><br>
        <button type="submit">Add Counselor</button>
    </form>

    <!-- Counselors List -->
    <h2>Counselors List</h2>
    <table border="1">
        <tr>
            <th>UserID</th>
            <th>CounselorID</th>
            <th>Verified</th>
            <th>Position</th>
            <th>Specialization</th>
            <th>Location</th>
            <th>Status</th>
            <th>No of Connections</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['UserID']; ?></td>
            <td><?php echo $row['CounselorID']; ?></td>
            <td><?php echo $row['verified']; ?></td>
            <td><?php echo $row['position']; ?></td>
            <td><?php echo $row['specialization']; ?></td>
            <td><?php echo $row['location']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td><?php echo $row['No_of_Connections']; ?></td>
            <td>
                <form method="POST" style="display:inline-block;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="UserID" value="<?php echo $row['UserID']; ?>">
                    <input type="hidden" name="CounselorID" value="<?php echo $row['CounselorID']; ?>">
                    <button type="submit">Delete</button>
                </form>
                <form method="POST" action="edit_counselor.php" style="display:inline-block;">
                    <input type="hidden" name="UserID" value="<?php echo $row['UserID']; ?>">
                    <input type="hidden" name="CounselorID" value="<?php echo $row['CounselorID']; ?>">
                    <button type="submit">Edit</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>

<?php
$conn->close();
?>
