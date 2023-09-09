<?php
// Connect to your MySQL database
$host = "localhost";
$username = "root";
$password = "";
$database = "fsd_lab";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate the user's input (you can add more validation)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
    } else {
        // Check if the user exists in the database
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            // User exists, fetch the user's data
            $row = mysqli_fetch_assoc($result);
            $hashed_password = $row["password"];

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                // Password is correct, you can redirect to a success page or perform other actions
                header("Location: index2.html");
            } else {
                echo "Incorrect password";
            }
        } else {
            echo "User not found. Please check your email.";
        }
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
