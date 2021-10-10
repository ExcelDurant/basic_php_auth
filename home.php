<?php
session_start();
if(!isset($_SESSION['username'])) {
    header("Location: http://localhost:8080/index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        <?php include './style.css'; ?>
    </style>
</head>

<body>
    <h1>
        Hello <?php echo $_SESSION['username']; ?> Welcome Home
    </h1>

    <form action="LogoutController.php" method="POST" class="logout-form">
        <input type="submit" value="logout" class="logout-btn">
    </form>
</body>

</html>