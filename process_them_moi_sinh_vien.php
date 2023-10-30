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


    $ho_ten = $_POST['ho_ten'];
    $ngay_sinh = $_POST['ngay_sinh'];
    $gioi_tinh = $_POST['gioi_tinh'];
    $que_quan = $_POST['que_quan'];


    if (isset($_FILES['anh']) && $_FILES['anh']['error'] == 0) {
        $anh = $_FILES['anh']['name'];
        $anh_tmp = $_FILES['anh']['tmp_name'];
        move_uploaded_file($anh_tmp, "uploads/" . $anh);
    } else {
        $anh = null;
    }


    $query = "INSERT INTO tblSinhVien (ho_ten, ngay_sinh, gioi_tinh, que_quan, anh) VALUES ('$ho_ten', '$ngay_sinh', '$gioi_tinh', '$que_quan', '$anh')";

    if (mysqli_query($conn, $query)) {
        header("Location: add_sinhVien.php");
    } else {
        echo "Lỗi: " . $query . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
