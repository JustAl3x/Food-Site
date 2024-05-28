<?php
session_start();

if(isset($_SESSION['id']) && isset($_SESSION['user_name'])){ 

  ?>
  <?php require"db_conn.php" ?>
  <!DOCTYPE html>
  <html lang="en">
    <head>
        <title>HOME</title>
        <style>
    </style>
        <link rel="stylesheet" type="text/css" href="css/home.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"> </script>
    </head>
    <body>
      <?php include "css/include/nav.php" ?>    
      <?php include "css/include/header.php" ?>      
        <main>
          <div class="left">
              <div class="section-title mx-5">Menu</div>  
              <div style="width: 160px;">
                <label>
                  Choose from many delicious meals
                </label>
              </div> 
          </div>
          <div class="right">
            <table>
                <?php
                // Connect to the database
                $sql = "SELECT * FROM inventory";
                $result = mysqli_query($conn, $sql);

                // Loop through the results and display each item as a list item
                if ($result->num_rows > 0) {
                    $col = 1;
                    echo  "<tr>";
                    while ($row = $result->fetch_assoc()) {
                    ?>
                       <td>

                        <!-- Bootstrap cards -->

                       <div class="card" style="width: 18rem; margin:10px;">
                        <img class="card-img-top" src="<?php echo $row["image_url"]?>" alt="Card image cap" width="287" height="180">
                        <div class="card-body">
                          <h5 class="card-title">
                            
                          <?php echo $row["name"] ?>  

                        </h5>
                          <p class="card-text">Price: <?php echo $row["price"] ?>€</p>
                          <form method="post">
                          <input type="submit" name="<?php echo $row["price"] ?>"  value="Order" class="btn btn-primary" /><br/>
                          </form>
                        </div>
                      </div>
                      </td>
                        <?php

                    if($col % 4 == 0)  {
                      echo "</tr><tr>";
                    }
                    $col = $col+1;
                    }
                  echo "</tr>";
                } else {
                    echo "No items found.";
                }
                ?>
            </table>
          </div>
        </main>
    </body>
  </hmtl>
  <?php
}
else {
header("Location: index.php");
exit();

}

function order(){
  if(isset($_POST['price'])){
    $_SESSION['total_price'] += $_POST['price'];
    unset($_POST['price']);
    echo $_SESSION['total_price'];  
  }
}



if(array_key_exists('price',$_POST)){
  order();
}



if(isset($_POST['price']))
{
   add_order();
} 
?>