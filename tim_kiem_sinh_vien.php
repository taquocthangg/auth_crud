<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tim_kiem = $_POST['tim_kiem'];

    $conn = mysqli_connect("localhost", "root", "", "d16cnpm5");

    if (!$conn) {
        die("Lỗi kết nối: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM tblSinhVien WHERE ho_ten LIKE '%$tim_kiem%'";
    $result = mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tìm kiếm Sinh viên</title>
</head>
<body>
    <h1>Tìm kiếm Sinh viên</h1>
    <form method="post" action="tim_kiem_sinh_vien.php">
        <label for="tim_kiem">Tìm kiếm theo họ tên:</label>
        <input type="text" id="tim_kiem" name="tim_kiem">
        <input type="submit" name="search" value="Tìm kiếm">
    </form>

    <?php
    if (isset($result)) {
        echo "<h1>Kết quả tìm kiếm:</h1>";
        echo "<table>";
        echo "<tr><th>Mã SV</th><th>Họ tên</th><th>Ngày sinh</th><th>Giới tính</th><th>Quê quán</th><th>Ảnh</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["masv"] . "</td>";
            echo "<td>" . $row["ho_ten"] . "</td>";
            echo "<td>" . $row["ngay_sinh"] . "</td>";
            echo "<td>" . $row["gioi_tinh"] . "</td>";
            echo "<td>" . $row["que_quan"] . "</td>";
            echo "<td><img src='uploads/" . $row["anh"] . "' width='100' height='100'></td>";
            echo "</tr>";
        }

        echo "</table>";
    }
    ?>

</body>
</html>
