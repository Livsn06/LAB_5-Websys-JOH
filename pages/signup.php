<?php
    session_start();
    if(isset($_SESSION['active'])){
        echo "<script>window.location.href='home.php'</script>";
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/signup.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Blog Spot</title>
</head>
<body>

    <!-- ------------------------- LINKS --------------------- -->
    <header class="header-link ">
    <h1 class="logo logo-left"><a href="landing.php" style="text-decoration: none; color:black;">Blog | <span class="logo-right">Spot</span></a></h1>
        <nav class="link-adjust">
            <a class="link" href="landing.php">Overview</a>
            <a class="link" href="">Services</a>
            <a class="link" href="">About us</a>
        </nav>
        <div class="login-button">
            <a class="link login-button " href="login.php">Login</a>
        </div>
    </header>
    <!-- ------------------------------------ -->

    <!-- ------------------------ SIGNUP FORM  ------------------------- -->
    <form method="post">
        <section class="content-main">
            <main class="form-design">

                <h1 class="header-title">SIGN UP</h1>

                  <!-- username textbox -->
                <div class="text-design-1">
                    <input type="text" placeholder=" " name="f_user" value="<?php get_UserInput() ?>" required>
                    <label for="text">Username</label>
                </div>

                  <!-- new password textbox -->
                <div class="text-design-2">
                    <input type="password" placeholder=" " name="f_pass" value="<?php get_passInput() ?>" required>
                    <label for="password">Create Password</label>
                </div>

                  <!-- confirm password textbox -->
                <div class="text-design-3">
                    <input type="password" placeholder=" " name="f_repass" value="<?php get_repassInput() ?>" required>
                    <label for="password">Confirm Password</label>
                </div>

                <span class="spacer"></span>

                  <!-- signup button -->
                <div class="button-field ">
                    <button class="form_btn" name="signup" value="">Sign up</button>
                </div>
                
                  <!-- link to login -->
                <a class="have-account" href="login.php">Already have an account? <span class="move-btn">Login</span></a>

            </main>
        </section>
    </form>
    <!-- ----------------------------------------------------- -->
    
</body>
</html>







<!-- ISSETS  -->
<?php

    if(isset($_POST['signup']))
    {
        $user =  $_POST['f_user'];
        $pass =  $_POST['f_pass'];
        $repass =  $_POST['f_repass'];


            if(is_password_Confirmed($pass, $repass))
            {
                insert_new_Account($user,$pass);
            }
            else
            {
                echo"
                <script>
                    alert('Password doesn\'t match!');
                </script>
                ";
            }

    }

?>







<!-- ------------------------ PHP FUNCTIONS -------------------- -->

<?php

function verify_Session(){
    require '../connection/config.php';
    session_start();
    if(isset($_SESSION["s_user"])){
    
        if((!empty($_SESSION['s_user']) && !empty($_SESSION['s_pass']))){
            header('Location: home.php');
        }else{
            session_destroy();
        }
     }
}

?>



<!-- QUERY COMMANDS -->
<?php

    function insert_new_Account($username , $password)
    {
        require '../connection/config.php';

            // use sha256 rather than md5
            $password = hash('sha256', $password); 

            # if account doest exist [it add to database]
            $query = "INSERT INTO ACCOUNTS (username, password, status) VALUES ('$username','$password','inactive')";
            try
            {
                mysqli_query($conn, $query);
                
                $query = "INSERT INTO ACCOUNTS_PROFILE (username, profile) VALUES ('$username','../images/profile/default.jpg')";
                mysqli_query($conn, $query);

                echo " <script>alert('Account created');</script>";
                echo "<script>window.location.href='login.php'</script>";
            }
            catch(Exception $e)
            {
                echo"
                <script>
                    alert('Username already used');
                </script>
                ";
            }

            
    }

?>




<!-- ----------------- MY FUNCTION BUILD ----------------- -->
<?php

function change_Status($user){
    require 'config.php';
    $query = "UPDATE ACCOUNTS SET status = 'active' WHERE username='".$user."'";
    mysqli_query($conn, $query); 
}

function get_UserInput(){
    if(isset($_POST['f_user'])){
        echo $_POST['f_user'];
    }
}

function get_passInput(){
    if(isset($_POST['f_pass'])){
        echo $_POST['f_pass'];
    }
}

function get_repassInput(){
    if(isset($_POST['f_repass'])){
        echo $_POST['f_repass'];
    }
}

function is_password_Confirmed($pass, $confirm){
    return $pass == $confirm;
}
?>