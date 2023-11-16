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

    <link rel="stylesheet" href="../styles/landing.css">
    <title>Blog Spot</title>
</head>
<body>
    <!-- --------------------- LINKS --------------------- -->
    <header class="header-link ">
    <h1 class="logo logo-left"><a href="landing.php" style="text-decoration: none; color:black;">Blog | <span class="logo-right">Spot</span></a></h1>
        <nav class="link-adjust">
            <a class="link active-link" href="landing.php">Overview</a>
            <a class="link" href="">Services</a>
            <a class="link" href="">About us</a>
        </nav>
        <div class="login-button">
            <a class="link login-button" href="login.php">Login</a>
        </div>
    </header>
    <!-- ---------------------------------------- -->

    <!-- ----------------------- Upper contents ------------------------- -->
    <section>
        <main class="bcg-image">

            <div class="content-inside">
                <h1>Explore, Learn, and Inspire</h1>
                <p>Embark on a Path of Discovery, Growth, and <br>Inspiration with your Blog</p>

                <div class="btn">
                    <a href="login.php"><button class="get-start-btn">Get Started</button></a>
                    <a href=""><button class="overview-btn">Overview</button></a>
                </div>
            </div>

        </main>
    </section>
    <!-- ------------------------------------ -->


      <!-- ----------------------- Lower contents ------------------------- -->
    <section class="section-2">

        <div class="sub-content-header">
            <h1>
                Transforming Everyday Life into Extraordinary Adventures: Join Us in Exploring the Beauty, Challenges, and Triumphs of the Ordinary
            </h1>
        </div>


        <div class="sub-content-text">
            <p>
                Welcome to Blog Spot where we explore the beauty, challenges, and triumphs of everyday life. Discover insights, tips, and heartwarming stories that turn the ordinary into extraordinary adventures. Join our community of everyday enthusiasts and embrace life to the fullest.
            </p>
        </div>

    </section>
    <!-- ----------------------------------------------- -->

</body>
</html>









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


?>
