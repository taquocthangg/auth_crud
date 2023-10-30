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

    $query = "UPDATE tblSinhVien SET ho_ten = '$ho_ten', ngay_sinh = '$ngay_sinh', gioi_tinh = '$gioi_tinh', que_quan = '$que_quan', anh = '$anh' WHERE masv = $masv";

    if (mysqli_query($conn, $query)) {
        header("Location: them_moi_sinh_vien.php");
    } else {
        echo "Lỗi: " . $query . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
