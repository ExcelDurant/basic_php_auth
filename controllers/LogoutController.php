<?php

session_start();
// remove all session variables
session_unset();

session_destroy();

header("Location: http://localhost:8080/index.php");