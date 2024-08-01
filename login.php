<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password_hash'])) {
            echo "Login successful";
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
        } else {
            echo "Invalid email or password";
        }
    } else {
        echo "Invalid email or password";
    }

    $stmt->close();
    $conn->close();
}
?>

<!--  Saves information of user -->