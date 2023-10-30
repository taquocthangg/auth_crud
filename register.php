<?php
session_start();

$message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST["fullname"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $conn = new mysqli("localhost", "root", "", "d16cnpm5");

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    $check_username_sql = "SELECT username FROM tbluser WHERE username = '$username'";
    $result = $conn->query($check_username_sql);

    if ($result->num_rows > 0) {
        $message = "Tài khoản đã tồn tại. Vui lòng chọn một tên người dùng khác.";
    } else {

        $sql = "INSERT INTO tbluser (fullname, username, password) VALUES ('$fullname', '$username', '$hashed_password')";
        if ($conn->query($sql) === TRUE) {
            $message = "Đăng ký thành công. Đang chuyển hướng đến trang đăng nhập...";
            header("refresh:2;url=login.php"); 
        } else {
            $message = "Lỗi: " . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Đăng ký</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container mt-5">
        <h2>Đăng ký tài khoản</h2>
        <form method="post">
            <div class="mb-3">
                <label for="fullname" class="form-label">Họ và tên</label>
                <input type="text" name="fullname" required class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Tên đăng nhập</label>
                <input type="text" name="username" required class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật Khẩu</label>
                <input name="password" required type="password" class="form-control" id="exampleInputPassword1">
            </div>
            <button type="submit" value="Đăng Ký" class="btn btn-primary">Đăng Ký</button>

        </form>
        <div><?php echo $message; ?></div>
    </div>
</body>

</html>