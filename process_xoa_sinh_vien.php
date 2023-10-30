<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = mysqli_connect("localhost", "root", "", "d16cnpm5");

    if (!$conn) {
        die("Lỗi kết nối: " . mysqli_connect_error());
    }


    $masv = $_POST['masv'];


    $query = "DELETE FROM tblSinhVien WHERE masv = $masv";

    if (mysqli_query($conn, $query)) {
        header("Location: add_sinhVien.php");
    } else {
        echo "Lỗi: " . $query . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
