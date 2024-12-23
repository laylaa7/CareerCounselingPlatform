<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "users");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($con, $_POST["username"]);
    $password = $_POST["password"]; 

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Verify the password against the hashed password in the database
        if (password_verify($password, $row["Password"])) {
            // Store user information in session
            $_SESSION["username"] = $row["username"];
            $_SESSION["Email"] = $row["Email"];
            
            // Redirect to the admin dashboard if the user is Admin
            if ($row["username"] === "Admin") {
              header("Location: ../AdminDash.php");
            } else {
                header("Location: userDashboard.php?login=success");
            }
            exit();
        } else {
            echo "Invalid username or password";
        }
    } else {
        echo "Invalid username or password";
    }
}

mysqli_close($con);
?>
 

 //SIGN UPPPPPP PHPPP
 <?php
session_start();
$con = mysqli_connect("localhost", "root", "", "users");


if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($con, $_POST["signupUsername"]);
    $email = mysqli_real_escape_string($con, $_POST["signupEmail"]);
    $password = mysqli_real_escape_string($con, $_POST["signupPassword"]);

    // Check if username or email already exists
    $check_sql = "SELECT * FROM users WHERE username = '$username' OR Email = '$email'";
    $check_result = mysqli_query($con, $check_sql);
    $userRole = 3;

    if (mysqli_num_rows($check_result) > 0) {
        echo "Username or email already exists";
    } else {
      $sql = "INSERT INTO users (username, Email, Password, userRole) VALUES ('$username', '$email', '$password', '$userRole')";
        
        if (mysqli_query($con, $sql)) {
            $_SESSION["username"] = $username;
            $_SESSION["Email"] = $email;
            $_SESSION["Password"] = $password;
            $_SESSION["userRole"] = $userRole;
            
            header("Location: index.php?signup=success");
            exit();
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
}
?>