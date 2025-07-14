<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Bukawarung</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <div id="bg-login">
    <div class="box-login">
      <h2>Login</h2>
      <form action="" method="POST">
        <input type="text" name="user" placeholder="Username" class="input-control">
        <input type="password" name="pass" placeholder="Password" class="input-control">
        <input type="submit" name="submit" value="Login" class="btn">
      </form>
      
      <?php
      if(isset($_POST['submit'])){
        session_start();
        include 'db.php';
        
        $user = mysqli_real_escape_string($conn, $_POST['user']);
        $pass = $_POST['pass'];
        
        $cek = mysqli_query($conn, "SELECT * FROM tb_admin WHERE username = '".$user."' AND password = '".MD5($pass)."'");
        
        if(mysqli_num_rows($cek) > 0){
          $data = mysqli_fetch_assoc($cek);
          
          // Buat object untuk admin dengan pengecekan field
          $admin_obj = new stdClass();
          $admin_obj->admin_id = isset($data['admin_id']) ? $data['admin_id'] : '';
          $admin_obj->admin_name = isset($data['admin_name']) ? $data['admin_name'] : (isset($data['username']) ? $data['username'] : 'Admin');
          $admin_obj->username = isset($data['username']) ? $data['username'] : '';
          $admin_obj->admin_telp = isset($data['admin_telp']) ? $data['admin_telp'] : '';
          $admin_obj->admin_email = isset($data['admin_email']) ? $data['admin_email'] : '';
          $admin_obj->admin_address = isset($data['admin_address']) ? $data['admin_address'] : '';
          
          $_SESSION['status_login'] = true;
          $_SESSION['a_global'] = $admin_obj;
          
          echo '<script>window.location="dashboard.php"</script>';
          exit();
        } else {
          echo "<script>alert('Username atau password salah!');</script>";
        }
      }
      ?>
    </div>
  </div>
</body>
</html>