<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8">
      <title>Login</title>
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
          <form action="login.php" method="post" class="form-horizontal">
          <h2 class="text-center text-primary mb-4">LOGIN</h2>
          <?php if(isset($_GET['error'])) { ?>
                <p class="error"> <?php echo $_GET['error']; ?></p>
              <?php } ?>
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
              <label>Not a user? <a href="register.php">Register</a></label>
            </div>
          </div>
          <div class="form-group d-flex justify-content-center align-items-center">
            <div class="col-sm-offset-2 col-sm-10 d-flex justify-content-center align-items-center">
              <button type="submit" class="btn btn-primary">Log in</button>
            </div>
          </div>
        </form>    
      </div>
    </div>
  </body>
</html>