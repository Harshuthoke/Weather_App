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
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password
    $contact = $_POST["contact"];
    $address = $_POST["address"];

    // Validate the user's input (you can add more validation)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
    } else {
        // Check if the user already exists in the database
        $check_query = "SELECT * FROM users WHERE email = '$email'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            echo "Email already exists. Please use a different email address.";
        } else {
            // Insert the user's information into the database
            $insert_query = "INSERT INTO users (name, email, password, contact, address) VALUES ('$name', '$email', '$password', '$contact', '$address')";

            if (mysqli_query($conn, $insert_query)) {
                // Registration successful, you can redirect to a success page or perform other actions
                header("Location: index2.html");
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
