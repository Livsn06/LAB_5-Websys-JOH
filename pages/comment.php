<?php
require '../connection/config.php';
    if(!isset($_GET['postedBy']))
    {
        echo "<script>window.location.href='home.php'</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
        <link rel="stylesheet" href="../styles/comment.css">

        <title>Home</title>
    </head>
    <body>

<?php

    if(isset($_GET['seeMorepost']) && isset($_GET['postedBy']) ){

    $user = $_GET['postedBy']; 
    $blogid = $_GET['seeMorepost'];
    $currentUser = $_GET['userF0llowing2'];
        $query = "SELECT username, blogid, blog_title, blog_content, datetime_created, blog_cat, blog_pic FROM POST WHERE (username ='".$user."') AND (blogid=".$blogid.")";


        $result = $conn->query($query);
        while($data = $result->fetch_assoc()){
            $id = $data['blogid'];
            $username = $data['username'];
            $date = arrangeDate($data['datetime_created']);
            $category = $data['blog_cat'];
            $title = $data['blog_title'];
            $content = $data['blog_content'];
            $upload = identify_Picture($data['blog_pic']);
            $profile = get_Users_Profile($username);

            $onlineUser_Profile = get_Users_Profile($currentUser);


?>

        <header class="header-link ">
        <h1 class="logo logo-left"><a href="home.php" style="text-decoration: none; color:black;">Blog | <span class="logo-right">Spot</span></a></h1>
            <nav class="link-adjust">
            <a class="link active-link" href="home.php">Home</a>
                <a class="link" href="create.php?createBlog=<?php echo $currentUser;?>">Create</a>
                <a class="link" href="#">About us</a>
            </nav>
            <div class="profile">

                <!-- ! udjusted -->
               <img class="pic" src="<?php echo $onlineUser_Profile;?>" width="40" height="40" alt="profile">

               <!-- todo: added` -->
               <nav class="link-adjust">
                    <a class="link-end" href="home.php?logout=<?php echo $currentUser;?>">Log out</a>
               </nav>

            </div>
        </header>

        <section class="card">
            <div class="wrapper">
                
                <main class="contents">
                    <div class="user-profile">
                        <!-- ! adjusted -->
                        <img class="pic" src="<?php echo $profile;?>" width="50" height="50" alt="profile">
                    </div>
                    <div class="user-about">
                        <h1><?php echo $username;?></h1>
                        <p><?php echo $date;?></p>
                    </div>
                    <div class="category">   
                        <a href="#"><?php echo $category;?></a>
                    </div>
                    
                </main>
                <main class="description">
                    <div>
                        <h1><?php echo $title;?></h1>
                        <p><?php echo $content;?></p>
                    </div>
                </main>
                <main>
                    <div class="picture-post">
                        <img src="<?php echo $upload;?>" alt="">
                    </div>
                </main>

<?php

    }
    $result->free();
}
?>  

                <!-- comment form -->
                <form action="" method="post">
                    <main>
                        <div class="input-design">
                            <textarea name="f_comment" id="" cols="20" rows="6" placeholder="Write a comment"></textarea>
                        </div>
                        
                        <div class="button-field ">
                            <button class="form_btn" name="comment" value="">Comment</button>
                        </div>
                    </main>

                </form>
                <!-- ---- -->
                <br>
                <hr>


                <div class="scroll-comment">
                    <div class="inner-scroll">
<?php

if(isset($_GET['seeMorepost']) && isset($_GET['postedBy']) ){

   $user = $_GET['postedBy']; 
   $blogid = $_GET['seeMorepost'];
   $currentUser = $_GET['userF0llowing2'];
    $query = "SELECT username, commentID, blogID, Comment, DateTime FROM COMMENTS WHERE blogID=$blogid ORDER BY DateTime DESC";

    // $query = "SELECT username FROM your_table WHERE username = '$username' AND blog_id = $blogId";

    $result = $conn->query($query);
    while($data = $result->fetch_assoc())
    {
        $username = $data['username'];
        $date = arrangeDate($data['DateTime']);
        $comment = $data['Comment'];
        $profile = get_Users_Profile($username); //,--- function on getting profile
        $colorIndicator = "";

?>

                        <!-- COMMENT CARD -->
                        <main class="comment-card">
                            <div class="comment-user-profile">
                                <img class="pic" src="<?php echo $profile;?>" width="45" height="45" alt="profile">
                            </div>
                            <!-- comment infos -->
                             
<?php
    if($currentUser == $username){
        $colorIndicator = "style=\"background-color: #ABE4FF;\"";
    }

?>
                              <div class="comment-info" <?php echo $colorIndicator;?>>
                                   <!-- user info -->
                                <div class="comment-user-about">
                                    <h1><?php echo $username;?></h1>
                                    <p><?php echo $date;?></p>
                                </div>
                                
                                <!-- inputed comment -->
                                <div class="comment">
                                    
                                    <pre><p><?php echo $comment;?></p></pre>

                                </div>
                           
                            </div>
                        </main>
                        <!-- ----- -->
<?php

    }
$result->free();
}
?>  


                    </div>
                </div>

            </div>
        </section>


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

if(isset($_POST['comment'])){
    require '../connection/config.php';

    $user_comment = $_POST['f_comment'];
    $id = $_GET['seeMorepost'];
    $user = $_GET['userF0llowing2'];
    $userposter = $_GET['postedBy'];

    $query = "INSERT INTO COMMENTS (username, blogID, Comment, DateTime) VALUES ('$user',$id, '$user_comment', LOCALTIMESTAMP())" ;
    mysqli_query($conn, $query);
    echo "<script>window.location.href='comment.php?postedBy=".$userposter."&seeMorepost=".$id."&userF0llowing2=".$user."'</script>";
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

         $image_container =$path;
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

