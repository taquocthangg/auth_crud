<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $conn = new mysqli("localhost", "root", "", "d16cnpm5");

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM tbluser WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        echo "Mật khẩu nhập: " . $password . "<br>";
        echo "Mật khẩu lưu trữ: " . $row["password"] . "<br>";
        if (password_verify($password, $row["password"])) {
            $_SESSION["username"] = $username;

            header("Location: index.php");
        } else {
            echo "Sai mật khẩu.";
        }
    } else {
        echo "Tài khoản không tồn tại.";
    }

    $conn->close();
}
