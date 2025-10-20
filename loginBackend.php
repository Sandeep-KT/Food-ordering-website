<?php
session_start();
include 'users.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    if ($email && $pass) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($pass, $user['password'])) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                header("Location: menu.php");
                exit();
            } else {
                echo "<script>alert('Invalid password'); window.location.href='login.php';</script>";
            }
        } else {
            echo "<script>alert('User not found'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('Please enter both fields');</script>";
    }
}
?>
