<?php
session_start();
require '../config/config.php';
require '../config/common.php';

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in']))
{
  header('Location: login.php');
};
if ($_SESSION['role'] != 1) {
  header('Location: login.php');
}
if($_POST)
{
  if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['address']))
  {
    if(empty($_POST['name']))
    {
      $nameError = 'Name needs to be filled';
    }
    if (empty($_POST['email'])) {
      $emailError = 'Email needs to be filled';
    }
    if (empty($_POST['address'])) {
      $addressError = 'Address needs to be filled';
    }
    if (empty($_POST['phone'])) {
      $phoneError = 'Phone Number needs to be filled';
    }
  }elseif (!empty($_POST['password']) && strlen($_POST['password']) < 4) {
    $passwordError = 'Password should be 4 characters at least';
  } else {
      $id = $_POST['id'];
      $name = $_POST['name'];
      $email = $_POST['email'];
      $address = $_POST['address'];
      $phone = $_POST['phone'];
      $password = password_hash($_POST['password'],PASSWORD_DEFAULT);

    if (empty($_POST['role'])) {
      $role = 2;
    }else{
      $role = 1;
    }

      $stmt2 = $pdo->prepare("SELECT * FROM users WHERE email=:email AND id!=:id");
      $stmt2->execute(array(':email'=>$email, ':id'=>$id));
      $user=$stmt2->fetch(PDO::FETCH_ASSOC);
      if ($user) {
        echo"<script>alert('Email duplicated');</script>";
      }else {
        if($password != null)
      {
        $stmt = $pdo->prepare("UPDATE users SET name='$name',email='$email',password='$password',address='$address',phone='$phone',role='$role' WHERE id='$id'");
      }
      else
      {
        $stmt = $pdo->prepare("UPDATE users SET name='$name',email='$email',address='$address',phone='$phone',role='$role' WHERE id='$id'");
      }
      $result = $stmt->execute();
      if ($result) {
        echo"<script>alert('User is Successfully Updated');window.location.href='user_list.php';</script>";
      }
    }
  }

}
$stmt=$pdo->prepare("SELECT * FROM users WHERE id=".$_GET['id']);
$stmt->execute();
$result=$stmt->fetchAll();

?>

<?php include('header.php'); ?>


    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form class="" action="" method="post" enctype="multipart/form-data">
                   <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                  <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo $result[0]['id'] ?>">
                    <label for="title">Name</label><p style="color:red;"><?php echo empty($nameError) ? '' : '*'.$nameError; ?></p>
                    <input type="text" class="form-control" name="name" value="<?php echo escape($result[0]['name']) ?>">
                  </div>
                  <div class="form-group">
                    <label for="content">Email</label><br><p style="color:red;"><?php echo empty($emailError) ? '' : '*'.$emailError; ?></p>
                    <input class="form-control" name="email" rows="8" cols="80" value="<?php escape($result[0]['email']) ?>">
                  </div>
                  <div class="form-group">
                    <label for="address">Address</label><br><p style="color:red;"><?php echo empty($addressError) ? '' : '*'.$addressError; ?></p>
                    <input class="form-control" name="address" rows="8" cols="80" value="<?php escape($result[0]['address']) ?>">
                  </div>
                  <div class="form-group">
                    <label for="phone">Phone Number</label><br><p style="color:red;"><?php echo empty($phoneError) ? '' : '*'.$phoneError; ?></p>
                    <input class="form-control" name="phone" rows="8" cols="80" value="<?php escape($result[0]['phone']) ?>">
                  </div>
                  <div class="form-group">
                      <label for="">Password</label><p style="color:red"><?php echo empty($passwordError) ? '' : '*'.$passwordError; ?></p>
                      <span style="font-size:10px">The user already has a password</span>
                      <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="role">Admin</label>
                      <input type="checkbox" name="role" value="1" <?php echo $result[0]['role'] == 1 ? 'checked':''?>>
                    </div>
                  <div class="form-group">
                  <input type="submit" class="btn btn-success" name="" value="SUBMIT">
                  <a href="user_list.php" type="button" class="btn btn-warning">Back</a>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.card -->

            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  <?php include('footer.html'); ?>
