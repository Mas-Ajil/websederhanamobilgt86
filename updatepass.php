<?php
    session_start();
    $conn = mysqli_connect('localhost', 'root', '', 'jualmobil');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Webkita</title>
    <link rel="stylesheet" type="text/css" href="login/login.css">
</head>
<body>
<?php
// Fungsi untuk mengupdate password pada database
function updatePassword($conn, $username, $newPassword) {
    $sql = "UPDATE users SET password = '$newPassword' WHERE nama_user = '$username'";

    if ($conn->query($sql) === TRUE) {
        return true; // Berhasil update password
    } else {
        return false; // Gagal update password
    }
}

// Fungsi untuk memeriksa apakah username ada di database
function isUsernameExists($conn, $username) {
    $sql = "SELECT * FROM users WHERE nama_user = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return true; // Username ditemukan
    } else {
        return false; // Username tidak ditemukan
    }
}

// Cek apakah form telah disubmit
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $newPassword = $_POST['new_password'];
    $confirmNewPassword = $_POST['confirm_new_password'];

    // Validasi username
    if (isUsernameExists($conn, $username)) {
        // Validasi password baru
        if ($newPassword === $confirmNewPassword) {
            // Lakukan validasi lainnya jika diperlukan sebelum mengupdate password
            if (updatePassword($conn, $username, $newPassword)) {
                // Password berhasil diupdate, arahkan ke halaman home
                header("Location: home.html");
                exit();
            } else {
                ?>
            <script language="javascript">
                alert('Gagal update password');
            </script>
    <?php
            }
        } else {
            ?>
            <script language="javascript">
                alert('Gagal update password');
            </script>
    <?php
        }
    } else {
        ?>
        <script language="javascript">
            alert('Gagal update password');
        </script>
<?php
    }
}

$conn->close();
?>
    <div class="container">
        <?php if (isset($error_message)) { ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php } ?>
        <form method="POST" action=''>
            <div class="form-group">
                <h1><img src="login/logobg.png" alt="logo"></h1>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password baru:</label>
                <input type="password" id="password" name="new_password" required>
                <label>Confirm New Password:</label>
                <input type="password" id='password' name="confirm_new_password" required><br>
            </div>
            <div class="form-group">
                <input type="submit" name="submit" id="login" value="Update password">
            </div>
        </form>
    </div>
</body>
</html>
