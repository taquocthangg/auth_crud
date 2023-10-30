<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['masv'])) {
    $masv = $_GET['masv'];

    $conn = mysqli_connect("localhost", "root", "", "d16cnpm5");

    if (!$conn) {
        die("Lỗi kết nối: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM tblSinhVien WHERE masv = $masv";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $ho_ten = $row["ho_ten"];
        $ngay_sinh = $row["ngay_sinh"];
        $gioi_tinh = $row["gioi_tinh"];
        $que_quan = $row["que_quan"];
        $anh = $row["anh"];
    } else {
        echo "Không tìm thấy sinh viên.";
        exit;
    }

    mysqli_close($conn);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $conn = mysqli_connect("localhost", "root", "", "d16cnpm5");

    if (!$conn) {
        die("Lỗi kết nối: " . mysqli_connect_error());
    }

    $query = "UPDATE tblSinhVien SET ho_ten = '$ho_ten', ngay_sinh = '$ngay_sinh', gioi_tinh = '$gioi_tinh', que_quan = '$que_quan', anh = '$anh' WHERE masv = $masv";

    if (mysqli_query($conn, $query)) {
        header("Location: add_sinhVien.php");
    } else {
        echo "Lỗi: " . $query . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sửa Sinh viên</title>
    <script type="text/javascript">
        function previewImage() {
            var fileInput = document.getElementById('anh');
            var imageContainer = document.getElementById('imageContainer');
            var image = document.createElement('img');

            imageContainer.innerHTML = ''; // Xóa hình ảnh hiển thị trước nếu có

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
    <h1>Sửa Sinh viên</h1>
    <form method="post" action="sua_sinh_vien.php" enctype="multipart/form-data">
        <input type="hidden" name="masv" value="<?php echo $masv; ?>">
        <label for="ho_ten">Họ tên:</label>
        <input type="text" id="ho_ten" name="ho_ten" value="<?php echo $ho_ten; ?>" required><br>

        <label for="ngay_sinh">Ngày sinh:</label>
        <input type="date" id="ngay_sinh" name="ngay_sinh" value="<?php echo $ngay_sinh; ?>" required><br>

        <label for="gioi_tinh">Giới tính:</label>
        <input type="radio" id="gioi_tinh" name="gioi_tinh" value="Nam" <?php if ($gioi_tinh === 'Nam') echo 'checked'; ?> required> Nam
        <input type="radio" id="gioi_tinh" name="gioi_tinh" value="Nữ" <?php if ($gioi_tinh === 'Nữ') echo 'checked'; ?> required> Nữ<br>

        <label for="que_quan">Quê quán:</label>
        <input type="text" id="que_quan" name="que_quan" value="<?php echo $que_quan; ?>" required><br>

        <label for="anh">Ảnh:</label>
        <input type="file" id="anh" name="anh" onchange="previewImage(); required">
        <img src="uploads/<?php echo $anh; ?>" width="100" height="100">
        <div id="imageContainer">
            
        </div>
        <p>Ảnh sau khi chỉnh sửa</p>
        <br>

        <input type="submit" value="Lưu chỉnh sửa">
    </form>
</body>
</html>
