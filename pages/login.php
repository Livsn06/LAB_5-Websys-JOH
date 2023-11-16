
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
    <link rel="stylesheet" href="../styles/login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Log in</title>
</head>

<body>

    <!-- --------------------------- LINKS ----------------------------- -->
    <header class="header-link ">
    <h1 class="logo logo-left"><a href="landing.php" style="text-decoration: none; color:black;">Blog | <span class="logo-right">Spot</span></a></h1>
        <nav class="link-adjust">
            <a class="link" href="landing.php">Overview</a>
            <a class="link" href="">Services</a>
            <a class="link" href="">About us</a>
        </nav>
        <div class="login-button">
            <a class="link login-button active-link" href="#">Login</a>
        </div>
    </header>
    <!-- ------------------------------------------------------------ -->

    <!-- ----------------------------- LOGIN FORM  ------------------------------------ -->
    <form method="post">
        <section class="content-main">
            <main class="form-design">

                <h1 class="header-title">LOG IN</h1> 

                <!-- username textbox -->
                <div class="text-design-1">
                    <input style="" type="text" placeholder=" " name="f_user"  value="<?php get_UserInput() ?>" required>
                    <label for="Username">Username</label>
                </div>

                 <!-- password textbox -->
                <div class="text-design-2">
                    <input type="password" placeholder=" " name="f_pass" value="<?php get_passInput() ?>" required>
                    <label for="password">Password</label>
                </div>
                
                <span class="spacer"></span>

                 <!-- forgetpassword link -->
                <a class="link mb" href="">Forgot Password?</a>
                
                 <!-- login button -->
                <div class="button-field ">
                    <button class="form_btn" type="submit" name="login" value="">Log in</button>
                </div>
                
                   <!-- link to signup -->
                <a class="have-account" href="signup.php">Don't have an account? <span class="move-btn">Signup</span></a>

            </main>
        </section>
    </form>
     <!-- ----------------------------------------------------- -->

</body>
</html>










<!-- ------------------------ PHP FUNCTIONS -------------------- -->

<!-- ISSETS  -->
<?php
    require '../connection/config.php';

    if(isset($_POST['login'])){
        $user =  $_POST['f_user'];
        $pass =  $_POST['f_pass'];
        // use sha256 rather than md5
        $pass = hash('sha256', $pass); 

        if(is_Existing_Account ($user, $pass))
        {
            
            $_SESSION['active'] = $user;
            change_Status($user);
            echo"
            <script>
                alert('Successfully login...');
            </script>
            ";
          
            echo "<script>window.location.href='home.php'</script>";
        }
        else
        {
            echo"
            <script>
                alert('Username or password doesn\'t exist');
            </script>
            ";
        }
    }

?>

<!-- QUERY COMMANDS -->
<?php
    
    function is_Existing_Account ($user_val, $pass_val)
    {
        require '../connection/config.php';
        
        # login existing account
        $result = $conn-> query("SELECT username, password, status FROM ACCOUNTS");
        
        while($data = $result->fetch_assoc())
        {
            if($data['username'] == $user_val && $data['password'] == $pass_val){
                $result->free();
                return true;
            }
        }
        $result->free();
        return false;
    }

    #make account active 
    function change_Status($user){
        require '../connection/config.php';
        
        $query = "UPDATE ACCOUNTS SET status = 'active' WHERE username='".$user."'";
        mysqli_query($conn, $query); 
    }
?>




<!-- ----------------- MY FUNCTION BUILD ----------------- -->
<?php

function verify_Session()
{
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

?>