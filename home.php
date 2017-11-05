<?php
session_start();
if(!isset($_SESSION['username'])){
    header('location:index.php');
}
?>


<!-- shopping cart script -->
<?php
 $connect = mysqli_connect("localhost", "root", "", "products_db");
 if(isset($_POST["add_to_cart"]))
 {
      if(isset($_SESSION["shopping_cart"]))
      {
           $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
           if(!in_array($_GET["id"], $item_array_id))
           {
                $count = count($_SESSION["shopping_cart"]);
                $item_array = array(
                     'item_id'               =>     $_GET["id"],
                     'item_name'               =>     $_POST["hidden_name"],
                     'item_price'          =>     $_POST["hidden_price"],
                     'item_quantity'          =>     $_POST["quantity"]
                );
                $_SESSION["shopping_cart"][$count] = $item_array;
           }
           else
           {
                echo '<script>alert("Item Already Added")</script>';
                echo '<script>window.location="home.php"</script>';
           }
      }
      else
      {
           $item_array = array(
                'item_id'             =>     $_GET["id"],
                'item_name'           =>     $_POST["hidden_name"],
                'item_price'          =>     $_POST["hidden_price"],
                'item_quantity'       =>     $_POST["quantity"]
           );
           $_SESSION["shopping_cart"][0] = $item_array;
      }
 }
 if(isset($_GET["action"]))
 {
      if($_GET["action"] == "delete")
      {
           foreach($_SESSION["shopping_cart"] as $keys => $values)
           {
                if($values["item_id"] == $_GET["id"])
                {
                     unset($_SESSION["shopping_cart"][$keys]);
                     echo '<script>alert("Item Removed")</script>';
                     echo '<script>window.location="home.php"</script>';
                }
           }
      }
 }
 ?>

 <!DOCTYPE html>
 <html>
     <head>
     <title>Softnet | Shopcart</title>

     <!-- Required meta tags -->
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

     <!-- master css -->
     <link rel="stylesheet" href="scripts/master.css">
     </head>
      <body>
           <br />
           <div class="container contner">
                <a href="logout.php">Logout</a>
                <h3 align="center">Welcome To Shopping Cart</h3><br />
                <div class="row">
                <?php
                $query = "SELECT * FROM product_table ORDER BY id ASC";
                $result = mysqli_query($connect, $query);
                if(mysqli_num_rows($result) > 0)
                {
                     while($row = mysqli_fetch_array($result))
                     {
                ?>

                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                         <form method="post" action="home.php?action=add&id=<?php echo $row["id"]; ?>">
                              <div class="tab_shop" align="center">
                                   <img src="<?php echo $row["image"]; ?>" class="img-responsive image" /><br />
                                   <h4 class="text-info"><?php echo $row["name"]; ?></h4>
                                   <h4 class="text-danger">Tsh <?php echo $row["price"]; ?></h4>
                                   <input type="text" name="quantity" class="form-control" value="1" />
                                   <input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" />
                                   <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />
                                   <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />
                              </div>
                         </form>
                    </div>

                <?php
                     }
                }
                ?>
                </div>
                <div style="clear:both"></div>
                <br />
                <h3>Order Details</h3>
                <div class="table-responsive">
                     <table class="table table-bordered">
                          <tr>
                               <th width="35%">ITEM NAME</th>
                               <th width="10%">QUANTITY</th>
                               <th width="20%">PRICE</th>
                               <th width="20%">TOTAL</th>
                               <th width="5%">ACTION</th>
                          </tr>
                          <?php
                          if(!empty($_SESSION["shopping_cart"]))
                          {
                               $total = 0;
                               foreach($_SESSION["shopping_cart"] as $keys => $values)
                               {
                          ?>
                          <tr>
                               <td><?php echo $values["item_name"]; ?></td>
                               <td><?php echo $values["item_quantity"]; ?></td>
                               <td>Tsh <?php echo $values["item_price"]; ?></td>
                               <td>Tsh <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>
                               <td><a href="home.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
                          </tr>
                          <?php
                                    $total = $total + ($values["item_quantity"] * $values["item_price"]);
                               }
                          ?>
                          <tr>
                               <td colspan="3" align="right">Total</td>
                               <td align="right">Tsh <?php echo number_format($total, 2); ?></td>
                               <td></td>
                          </tr>
                          <?php
                          }
                          ?>
                     </table>
                </div>
           </div>
           <br />
      </body>

      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
 </html>
