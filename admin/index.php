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
?>

<?php include('header.php'); ?>


    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">

          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Product Listing</h3>
              </div>

              <!-- /.card-header -->
               <div class="card-body">
                <div class="">
                    <a href="add.php" type="button" class="btn btn-success">Creat New Post</a>

                </div>
                <br>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Title</th>
                      <th>Content</th>
                      <th style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </table>


              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
  </div>
</div>
</div>


    <!-- /.content -->
  <?php include('footer.html'); ?>
