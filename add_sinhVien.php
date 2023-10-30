<!DOCTYPE html>
<html>
<head>
    <title>Thêm mới Sinh viên</title>
    <script type="text/javascript">
        function previewImage() {
            var fileInput = document.getElementById('anh');
            var imageContainer = document.getElementById('imageContainer');
            var image = document.createElement('img');

            imageContainer.innerHTML = '';

            if (fileInput.files.length > 0) {
                var file = fileInput.files[0];
                image.src = URL.createObjectURL(file);
                image.width = 100;
                image.height = 100;
                imageContainer.appendChild(image);
            }
        }
    </script>
</head>
<body>
    <h1>Thêm mới Sinh viên</h1>
    <form method="post" action="process_them_moi_sinh_vien.php" enctype="multipart/form-data">
        <label for="ho_ten">Họ tên:</label>
        <input type="text" id="ho_ten" name="ho_ten" required><br>

        <label for="ngay_sinh">Ngày sinh:</label>
        <input type="date" id="ngay_sinh" name="ngay_sinh" required><br>

        <label for="gioi_tinh">Giới tính:</label>
        <input type="radio" id="gioi_tinh" name="gioi_tinh" value="Nam" required> Nam
        <input type="radio" id="gioi_tinh" name="gioi_tinh" value="Nữ" required> Nữ<br>

        <label for="que_quan">Quê quán:</label>
        <input type="text" id="que_quan" name="que_quan" required><br>

        <label for="anh">Ảnh:</label>
        <input type="file" id="anh" name="anh" onchange="previewImage(); required"><br>
        <div id="imageContainer"></div>
        <input type="submit" value="Thêm mới">
    </form>
    <h2>Danh sách sinh viên:</h2>
    <?php

    $conn = mysqli_connect("localhost", "root", "", "d16cnpm5");

    if (!$conn) {
        die("Lỗi kết nối: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM tblSinhVien";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th>Mã SV</th><th>Họ tên</th><th>Ngày sinh</th><th>Giới tính</th><th>Quê quán</th><th>Ảnh</th><th>Thao tác</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["masv"] . "</td>";
            echo "<td>" . $row["ho_ten"] . "</td>";
            echo "<td>" . $row["ngay_sinh"] . "</td>";
            echo "<td>" . $row["gioi_tinh"] . "</td>";
            echo "<td>" . $row["que_quan"] . "</td>";
            echo "<td><img src='uploads/" . $row["anh"] . "' width='100' height='100'></td>";
            echo "<td>
                    <a href='sua_sinh_vien.php?masv=" . $row["masv"] . "'>Sửa</a> |
                    <a href='xoa_sinh_vien.php?masv=" . $row["masv"] . "'>Xóa</a>
                  </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Không có sinh viên.";
    }

    mysqli_close($conn);
    ?>
</body>
</html>
