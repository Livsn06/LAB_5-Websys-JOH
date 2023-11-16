<?php
    session_start();
    if(!isset( $_SESSION['active']))
    {
        echo "<script>window.location.href='landing.php'</script>";
    }
    require '../connection/config.php';
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
        <link rel="stylesheet" href="../styles/home.css">
        <title>Home</title>
    </head>
    <body>


      <?php
            $profile_pic = "";
            $user_name = "";
            $query = "SELECT ap.username AS user, profile FROM ACCOUNTS_PROFILE AS ap JOIN ACCOUNTS AS a ON ap.username = a.username 
            WHERE  ap.username ='". trim($_SESSION['active'])."'";
            $result = $conn->query($query);
            while($data = $result->fetch_assoc()){
                $profile_pic = $data['profile'];
                $user_name = $data['user'];
            }

            $result->free();
      ?>
        <header class="header-link ">
            <h1 class="logo logo-left"><a href="home.php" style="text-decoration: none; color:black;">Blog | <span class="logo-right">Spot</span></a></h1>
            <nav class="link-adjust">
                <a class="link active-link" href="#">Home</a>
                <a class="link" href="create.php?createBlog=<?php echo $user_name;?>">Create</a>
                <a class="link" href="#">About us</a>
            </nav>
            <div class="profile">

                <!-- ! udjusted -->
               <img class="pic" src="<?php echo $profile_pic;?>" width="40" height="40" alt="profile">

               <!-- todo: added` -->
               <nav class="link-adjust">
                    <a class="link-end" href="home.php?logout=<?php echo $user_name;?>">Log out</a>
               </nav>

            </div>
        </header>

      <?php
        
      
      
      ?>



<?php  
   

    $query = "SELECT username,  blogid, blog_title, blog_content, datetime_created, blog_cat, blog_pic FROM POST ORDER BY datetime_created DESC";
    $result = $conn->query($query);

    while($data = $result->fetch_assoc()){
        $id = $data['blogid'];
        $username = $data['username'];
        $date = arrangeDate($data['datetime_created']);
        $category = $data['blog_cat'];
        $title = $data['blog_title'];
        $content = $data['blog_content'];
        $upload = identify_Picture($data['blog_pic']);
        $profile = get_Users_Profile($username); //,--- function on getting profile


    echo "
        
    <section class=\"card\">

        <div class=\"wrapper\">

            <main class=\"contents\">

                <div class=\"user-profile\">
            
                    <img class=\"pic\" src=\"".$profile."\" width=\"50\" height=\"50\" alt=\"profile\">
                </div>
                <div class=\"user-about\">
                    <h1>".$username."</h1>
                    <p>".$date ."</p>
                </div>

                <div class=\"category\">   
                    <a href=\"#\">".$category."</a>
                </div>

            </main>

            <main class=\"description\">
                <div>
                    <h1>
                        <a href=\"comment.php?postedBy=".$username."&seeMorepost=".$id."&userF0llowing2=".$user_name."\">". $title."</a>
                    </h1>
                </div>
            </main>
            ".
            $upload
            ."

        </div>


    </section>
        
    " ;

    }
    $result->free();

?>

    </body>
</html>















<!-- ------------------------ PHP FUNCTIONS -------------------- -->


<?php

if(isset($_GET['logout']))
{
    change_Status($_GET['logout']);
    session_destroy();
    echo"
    <script>
        alert('Log out Successfully');
    </script>
    ";
    echo "<script>window.location.href='login.php'</script>";

}



?>





<?php

function verify_Session()
{
    require '../connection/config.php';
    session_start();

    if(isset($_SESSION["s_user"])){
        
        if((!$_SESSION['s_user']) && !$_SESSION['s_pass']){
            header('Location: login.php');
        }
    }else{
        header('Location: landing.php');
    }

}

function arrangeDate($timedate)
{
    $timedate = date_create($timedate);
    $timedate = date_format($timedate, 'M d, Y') ." at ". date_format($timedate, 'h:i a');
    return $timedate;
}

function identify_Picture($path){
    $image_container = "";
    // echo $path;
    if(!empty($path) && $path !="../images/upload/"){

         $image_container = "
                <main>
                <div class=\"picture-post\">
                    <img src=\"".$path."\">
                </div>
                </main>
        ";
    }else{
        $image_container = "";
    }
   return  $image_container;
}

function get_Users_Profile($user)
{
    require '../connection/config.php';
    $query = "SELECT profile FROM ACCOUNTS_PROFILE AS ap WHERE  ap.username = '".$user."'";
    $result = $conn->query($query);
    while($data = $result->fetch_assoc()){
        $prof = $data['profile'];
        $result->free();
        return  $prof;
    }


}

?>


<!-- QUERY COMMANDS -->
<?php
    
    #make account active 
    function change_Status($user)
    {
        require '../connection/config.php';
        
        $query = "UPDATE ACCOUNTS SET status = 'inactive' WHERE username='".$user."'";
        mysqli_query($conn, $query); 
    }
?>



