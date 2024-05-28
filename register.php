<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8">
      <title>Register</title>
      <link rel="stylesheet" type="text/css" href="style.css">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
      <style>
        body {
          background-color: #cfe2f3; 
        }
      </style>
  </head>         
  <body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-6">
          <form action="register-action.php" method="post" class="form-horizontal">
          <h2 class="text-center text-primary mb-4">REGISTER</h2>
          <?php if(isset($_GET['error'])) { ?>
                <p class="error"> <?php echo $_GET['error']; ?></p>
          <?php } ?>
          <div class="form-group">
            <label class="control-label col-sm-2">Name:</label>
            <div class="col-12">
              <input type="text" class="form-control" name="name" placeholder="Enter name">
            </div>
          </div> 
          <div class="form-group">
            <label class="control-label col-sm-2">Username:</label>
            <div class="col-12">
              <input type="text" class="form-control" name="uname" id="uname" placeholder="Enter username">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Password:</label>
            <div class="col-12"> 
              <input type="password" class="form-control" name="password" placeholder="Enter password">
            </div>
          </div>
          <div class="form-group d-flex justify-content-center align-items-center">
            <div class="col-sm-offset-2 col-sm-10 d-flex justify-content-center align-items-center">
              <label>Already have an account? <a href="index.php">Log in</a></label>
            </div>
          </div>
          <div class="form-group d-flex justify-content-center align-items-center">
            <div class="col-sm-offset-2 col-sm-10 d-flex justify-content-center align-items-center">
              <button type="submit" class="btn btn-primary">Register</button>
            </div>
          </div>
        </form>    
      </div>
    </div>
  </body>
</html>