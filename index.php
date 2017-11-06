<?php
session_start();
include_once('dbcon.php');

$error = false;
if(isset($_POST['btn-login'])){
    $email = trim($_POST['email']);
    $email = htmlspecialchars(strip_tags($email));

    $password = trim($_POST['password']);
    $password = htmlspecialchars(strip_tags($password));

    if(empty($email)){
        $error = true;
        $errorEmail = 'Please enter email';
    # email validation
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = true;
        $errorEmail = 'Please enter a valid email address';
    }

    if(empty($password)){
        $error = true;
        $errorPassword = 'Please enter password';

    #limit password at least 6 characters
    }elseif(strlen($password)< 6){
        $error = true;
        $errorPassword = 'Password at least 6 character';
    }

    if(!$error){

        # encrypt password into md5
        $password = md5($password);
        # retrieving data from DB users_table
        $sql = "select * from users_table where email='$email' ";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);
        # check for authentication of user inside DB & Entered data
        if($count==1 && $row['password'] == $password){
            $_SESSION['username'] = $row['username'];
            # redirect user to home page for valid authentcated user
            header('location: home.php');
        }else{
            $errorMsg = 'Invalid Username or Password';
        }
    }
}
?>


<!doctype html>
<html lang="en">
  <head>
    <title>Softnet Shopping Cart</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    <!-- master css -->
    <link rel="stylesheet" href="scripts/master.css">
    <link rel="stylesheet" href="scripts/modal.css">
  </head>
  <body>
    <nav class="navbar navbar-inverse">
          <div class="container-fluid">
            <div class="navbar-header">
              <a class="navbar-brand" href="index.php">Softnet Shopping Cart</a>
            </div>
            <ul class="nav navbar-nav">
              <li class="active"><a href="index.php">Home</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
              <!-- <li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li> -->
              <li><a><span onclick="document.getElementById('id02').style.display='block'" style="width:auto;" class="glyphicon glyphicon-log-in" id="myBtn"></span> Register</a></li>
              <li><a><span onclick="document.getElementById('id01').style.display='block'" style="width:auto;" class="glyphicon glyphicon-log-in" id="myBtn"></span> Login</a></li>
              <!-- <button type="button" class="btn btn-default btn-lg" id="myBtn">Login</button> -->
              <!-- <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button> -->
            </ul>
          </div>
    </nav>
    <!-- <div class="container"> -->
      <div id="myCarousel" class="carousel slide" data-ride="carousel" style="margin-top:-23px">
            <!-- Indicators -->
            <ol class="carousel-indicators">
              <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
              <li data-target="#myCarousel" data-slide-to="1"></li>
              <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
              <div class="item active">
                <img src="images/cable.jpg" alt="New York" width="100%" height="100%">
                <div class="carousel-caption">
                  <h3>New York</h3>
                  <p>WHEN IT COMES TO THE INSTALLATION, CONFIGURATION AND COMMISSIONING OF NEW HARDWARE AND SOFTWARE SYSTEMS, EXPERIENCE AND A PROVEN TRACK RECORD COUNTS</p>
                </div>
              </div>

              <div class="item">
                <img src="images/hardware.jpg" alt="Chicago" width="100%" height="100%">
                <div class="carousel-caption">
                  <h3>Chicago</h3>
                  <p>WHEN IT COMES TO THE INSTALLATION, CONFIGURATION AND COMMISSIONING OF NEW HARDWARE AND SOFTWARE SYSTEMS, EXPERIENCE AND A PROVEN TRACK RECORD COUNTS..</p>
                </div>
              </div>

              <div class="item">
                <img src="images/servers.jpg" alt="Los Angeles" width="100%" height="100%">
                <div class="carousel-caption">
                  <h3>LA</h3>
                  <p>WE ARE EXPERTS IN DESIGNING, BUILDING AND DELIVERING BUSINESS-DRIVEN TECHNOLOGY SOLUTIONS.</p>
                </div>
              </div>
              </div>

              <!-- Left and right controls -->
              <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
      </div>
      <!-- </div> -->
      <footer class="modal-footer" style="background-color:#080808;">
          <center><strong ><p style="color:white">Developed By <a href="https://github.com/Mwarukason">Amri Shabani Mwaruka (mwarukason)</a></p></strong></center>
      </footer>



      <!-- begin og login Modal -->
      <div id="id01" class="modal" >
        <form class="modal-content animate" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <!-- avatar image div -->
            <div class="imgcontainer">
              <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
              <img src="images/avatar.png" alt="Avatar" class="avatar">
            </div>

            <div class="container" style="width:100%;height:100%;">
                    <center><h2>Login</h2></center>
                    <hr/>
                    <?php
                        if(isset($errorMsg)){
                            ?>
                            <div class="alert alert-danger">
                                <span class="glyphicon glyphicon-info-sign"></span>
                                <?php echo $errorMsg; ?>
                            </div>
                            <?php
                        }
                    ?>
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="email" name="email" class="form-control" autocomplete="off" required>
                        <span class="text-danger"><?php if(isset($errorEmail)) echo $errorEmail; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label">Password</label>
                        <input type="password" name="password" class="form-control" autocomplete="off">
                        <span class="text-danger"><?php if(isset($errorPassword)) echo $errorPassword; ?></span>
                    </div>
                    <div class="form-group">
                        <center><input type="submit" name="btn-login" value="Login" class="btn btn-primary"></center>
                    </div>
                    <hr/>
                <!-- </form> -->

                <div class="container" style="background-color:#f1f1f1;width:100%;height:100%;" >
                  <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                  <span class="psw">Forgot <a href="#">password?</a></span>
                </div>
            </div>
        </form>
      </div> <!-- End of Login Modal -->

      <!-- login modal JavaScript -->
    <script type="text/javascript" src="scripts/loginModal.js"></script>


    <!-- Register Modal -->
    <div id="id02" class="modal">
      <form class="modal-content animate" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
          <div class="imgcontainer">
            <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
            <img src="images/registertab.png" alt="Avatar" class="avatar">
          </div>

          <div class="container" style="width:100%;height:100%;">
                      <hr/>
                      <?php
                          if(isset($successMsg)){
                       ?>
                              <div class="alert alert-success">
                                  <span class="glyphicon glyphicon-info-sign"></span>
                                  <?php echo $successMsg; ?>
                              </div>
                      <?php
                          }
                      ?>
                      <div class="form-group">
                        <label for="username" class="control-label">Username</label>
                        <input type="text" name="username" class="form-control" autocomplete="off">
                        <span class="text-danger"><?php if(isset($errorUsername)) echo $errorUsername; ?></span>
                      </div>
                      <div class="form-group">
                          <label for="email" class="control-label">Email</label>
                          <input type="email" name="email" class="form-control" autocomplete="off">
                          <span class="text-danger"><?php if(isset($errorEmail)) echo $errorEmail; ?></span>
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">Password</label>
                          <input type="password" name="password" class="form-control" autocomplete="off">
                          <span class="text-danger"><?php if(isset($errorPassword)) echo $errorPassword; ?></span>
                      </div>
                      <div class="form-group">
                          <center><input type="submit" name="btn-register" value="Register" class="btn btn-primary"></center>
                      </div>
                      <hr/>
                  </form>
                  <hr/>
              <!-- </form> -->

              <div class="container" style="background-color:#f1f1f1;width:100%;height:100%;" >
                <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
              </div>
          </div>
      </form>
    </div>
    <!-- register modal JavaScript -->
  <script type="text/javascript" src="scripts/registerModal.js"></script>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>
