<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Trang chủ</title>
</head>

<body>
    <h1>Trang chủ</h1>
    <p>Xin chào, <?php echo $username; ?> !</p>
    <ul>
        <li><a href="add_sinhVien.php">Quản lý Sinh viên</a></li>
        <li><a href="edit_profile.php">Quản lý người dùng</a></li>
        <li><a href="tim_kiem_sinh_vien.php">Tìm kiếm sinh viên</a></li>
    </ul>
    <a href="logout.php">Đăng xuất</a>
</body>

</html>