<?php
include "db.php";

echo "<h2>Reset Password Admin</h2>";
echo "<style>";
echo "body { font-family: Arial, sans-serif; margin: 20px; }";
echo "form { background: #f4f4f4; padding: 20px; border-radius: 5px; max-width: 400px; }";
echo "input { width: 100%; padding: 8px; margin: 5px 0; box-sizing: border-box; }";
echo "input[type=submit] { background: #007cba; color: white; border: none; padding: 10px; cursor: pointer; }";
echo "</style>";

// Proses reset password
if(isset($_POST['reset'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password_baru = $_POST['password_baru'];
    $password_hash = md5($password_baru);
    
    // Cek apakah username ada
    $cek = mysqli_query($conn, "SELECT * FROM tb_admin WHERE username = '$username'");
    
    if(mysqli_num_rows($cek) > 0){
        // Update password
        $update = mysqli_query($conn, "UPDATE tb_admin SET password = '$password_hash' WHERE username = '$username'");
        
        if($update){
            echo "<div style='color: green; padding: 10px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; margin: 10px 0;'>";
            echo "Password berhasil direset!<br>";
            echo "Username: <strong>$username</strong><br>";
            echo "Password baru: <strong>$password_baru</strong><br>";
            echo "MD5 Hash: <strong>$password_hash</strong>";
            echo "</div>";
        } else {
            echo "<div style='color: red; padding: 10px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; margin: 10px 0;'>";
            echo "Gagal reset password: " . mysqli_error($conn);
            echo "</div>";
        }
    } else {
        echo "<div style='color: red; padding: 10px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; margin: 10px 0;'>";
        echo "Username tidak ditemukan!";
        echo "</div>";
    }
}
?>

<form method="POST">
    <h3>Reset Password</h3>
    <label>Username:</label>
    <input type="text" name="username" placeholder="Masukkan username admin" required>
    
    <label>Password Baru:</label>
    <input type="password" name="password_baru" placeholder="Masukkan password baru" required>
    
    <input type="submit" name="reset" value="Reset Password">
</form>

<br>
<h3>Atau gunakan password default ini:</h3>
<div style="background: #e7f3ff; padding: 15px; border-radius: 5px; border-left: 5px solid #007cba;">
    <strong>Username:</strong> admin<br>
    <strong>Password:</strong> admin123<br>
    <small>MD5 Hash: <?php echo md5('admin123'); ?></small>
</div>

<br>
<a href="login.php">Kembali ke Login</a> | 
<a href="lihat_password.php">Lihat Data Admin</a>

<?php
// Auto-create default admin jika belum ada
$cek_admin = mysqli_query($conn, "SELECT * FROM tb_admin WHERE username = 'admin'");
if(mysqli_num_rows($cek_admin) == 0){
    echo "<br><br><strong>Membuat admin default...</strong><br>";
    
    $insert_default = mysqli_query($conn, "INSERT INTO tb_admin (username, password, admin_name, admin_telp, admin_email, admin_address) VALUES ('admin', '" . md5('admin123') . "', 'Administrator', '', '', '')");
    
    if($insert_default){
        echo "<div style='color: green; padding: 10px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; margin: 10px 0;'>";
        echo "Admin default berhasil dibuat!<br>";
        echo "Username: <strong>admin</strong><br>";
        echo "Password: <strong>admin123</strong>";
        echo "</div>";
    }
}
?>