<?php
if (!isset($_SESSION)) {
    session_start();
}

// remove all session variables
session_unset();

// connection to database
include_once '../db.php';

$invalid_form = false;
$email = format_input($_POST['email']);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['email_err'] = "Invalid email format";
    $invalid_form = true;
}
$password = format_input($_POST['password']);

if ($invalid_form == true) {
    // header('WWW-Authenticate: Basic realm="Top Secret Files"');
    header("HTTP/1.1 401 Unauthorized");
    // http_response_code(401);
    header("Location: http://localhost:8080/pages/login.php");
    
    // header("HTTP/1.0 401 Unauthorized");
    exit;
    // header("HTTP/1.0 401 Unauthorized");
} else {
    $sql = "SELECT id, username, email, password FROM users WHERE email='$email'";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['password'] = $row['password'];
                header("Location: http://localhost:8080/pages/home.php");
            } else {
                $_SESSION['pass_err'] = 'invalid credentials';
                // header('WWW-Authenticate: Basic realm="Top Secret Files"');
                header("HTTP/1.1 401 Unauthorized");
                // http_response_code(401);
                header("Location: http://localhost:8080/pages/login.php");
                // header("HTTP/1.0 401 Unauthorized");
                exit;
            }
        }
    } else {
        $_SESSION['pass_err'] = 'invalid credentials';
        // header('WWW-Authenticate: Basic realm="Top Secret Files"');
        header("HTTP/1.1 401 Unauthorized");
        // http_response_code(401);
        header("Location: http://localhost:8080/pages/login.php");
        // header("HTTP/1.0 401 Unauthorized");
        exit;
    }

    mysqli_close($connection);
}


function format_input($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}
