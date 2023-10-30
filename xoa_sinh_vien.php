<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['masv'])) {
    $masv = $_GET['masv'];
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Xóa Sinh viên</title>
    </head>
    <body>
        <h1>Xác nhận xóa Sinh viên</h1>
        <p>Bạn có chắc muốn xóa Sinh viên này?</p>
        <form method="post" action="process_xoa_sinh_vien.php">
            <input type="hidden" name="masv" value="<?php echo $masv; ?>">
            <input type="submit" value="Xóa">
        </form>
    </body>
    </html>
    <?php
}
?>
