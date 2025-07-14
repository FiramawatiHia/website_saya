<?php
include "db.php";

echo "<h2>Data Admin di Database</h2>";
echo "<style>";
echo "table { border-collapse: collapse; width: 100%; }";
echo "th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }";
echo "th { background-color: #f2f2f2; }";
echo "body { font-family: Arial, sans-serif; margin: 20px; }";
echo "</style>";

// Ambil semua data admin
$query = mysqli_query($conn, "SELECT * FROM tb_admin");

if($query){
    echo "<table>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Username</th>";
    echo "<th>Password (MD5)</th>";
    echo "<th>Nama</th>";
    echo "<th>Telepon</th>";
    echo "<th>Email</th>";
    echo "<th>Alamat</th>";
    echo "</tr>";
    
    while($data = mysqli_fetch_array($query)){
        echo "<tr>";
        echo "<td>" . (isset($data['admin_id']) ? $data['admin_id'] : 'N/A') . "</td>";
        echo "<td>" . (isset($data['username']) ? $data['username'] : 'N/A') . "</td>";
        echo "<td>" . (isset($data['password']) ? $data['password'] : 'N/A') . "</td>";
        echo "<td>" . (isset($data['admin_name']) ? $data['admin_name'] : 'N/A') . "</td>";
        echo "<td>" . (isset($data['admin_telp']) ? $data['admin_telp'] : 'N/A') . "</td>";
        echo "<td>" . (isset($data['admin_email']) ? $data['admin_email'] : 'N/A') . "</td>";
        echo "<td>" . (isset($data['admin_address']) ? $data['admin_address'] : 'N/A') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<br><h3>Informasi Password:</h3>";
    echo "<p><strong>Password disimpan dalam bentuk MD5 Hash</strong></p>";
    echo "<p>Untuk login, Anda perlu tahu password asli, bukan MD5 hash-nya.</p>";
    echo "<p>Contoh: Jika password asli adalah 'admin123', maka MD5 hash-nya adalah: " . md5('admin123') . "</p>";
    
} else {
    echo "Error: " . mysqli_error($conn);
}

echo "<br><br>";
echo "<h3>Buat Admin Baru (Jika Belum Ada):</h3>";
echo "<form method='POST'>";
echo "Username: <input type='text' name='username' required><br><br>";
echo "Password: <input type='password' name='password' required><br><br>";
echo "Nama: <input type='text' name='nama' required><br><br>";
echo "<input type='submit' name='buat_admin' value='Buat Admin Baru'>";
echo "</form>";

// Proses buat admin baru
if(isset($_POST['buat_admin'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    
    $insert = mysqli_query($conn, "INSERT INTO tb_admin (username, password, admin_name, admin_telp, admin_email, admin_address) VALUES ('$username', '$password', '$nama', '', '', '')");
    
    if($insert){
        echo "<script>alert('Admin berhasil dibuat!'); window.location='lihat_password.php';</script>";
    } else {
        echo "<script>alert('Gagal membuat admin: " . mysqli_error($conn) . "');</script>";
    }
}

echo "<br><br><a href='login.php'>Kembali ke Login</a>";
?>