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
  if (empty($_POST['name']) || empty($_POST['description']))
  {
    if(empty($_POST['name']))
    {
      $nameError = 'Name needs to be filled';
    }
    if (empty($_POST['description'])) {
      $description = 'Description needs to be filled';
    }
  }else {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];


      $stmt = $pdo->prepare("UPDATE categories SET name='$name',description='$description' WHERE id='$id'");
      $result = $stmt->execute();
      if ($result) {
        echo"<script>alert('Category is Successfully Updated');window.location.href='category.php';</script>";


    }
  }

}
$stmt=$pdo->prepare("SELECT * FROM categories WHERE id=".$_GET['id']);
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
                <form class="" action="" method="post" >
                  <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                  <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo $result[0]['id'] ?>">
                    <label for="name">Name</label><p style="color:red;"><?php echo empty($nameError) ? '' : '*'.$nameError; ?></p>
                    <input type="text" class="form-control"name="name" value="<?php echo escape($result[0]['name']) ?>">
                  </div>
                  <div class="form-group">
                    <label for="description">Description</label><br><p style="color:red;"><?php echo empty($descriptionError) ? '' : '*'.$descriptionError; ?></p>
                    <textarea class="form-control" name="description" rows="8" cols="80"><?php print_r($result[0]['description']) ?></textarea>
                  </div>
                  <div class="form-group">
                  <input type="submit" class="btn btn-success" name="" value="SUBMIT">
                  <a href="category.php" type="button" class="btn btn-warning">Back</a>
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
