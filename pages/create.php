<?php
session_start();
    require '../connection/config.php';
    if(!isset($_GET['createBlog']))
    {
        echo "<script>window.location.href='home.php'</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
        <link rel="stylesheet" href="../styles/create.css">
        <script src="https://kit.fontawesome.com/a3ac451aad.js" crossorigin="anonymous"></script>
        <title>Create</title>
    </head>
    <body>


        <!-- ----------------------- LINKS ------------------ -->
        <header class="header-link ">
        <h1 class="logo logo-left"><a href="home.php" style="text-decoration: none; color:black;">Blog | <span class="logo-right">Spot</span></a></h1>
            <nav class="link-adjust">
                <a class="link" href="home.php">Home</a>
                <a class="link active-link" href="">Create</a>
                <a class="link" href="#">About us</a>
            </nav>
            <div class="profile">

                <!-- ! udjusted -->
               <img class="pic" src="<?php echo get_Users_Profile($_GET['createBlog']);?>" width="40" height="40" alt="profile">

               <!-- todo: added` -->
               <nav class="link-adjust">
                    <a class="link-end" href="create.php?logout=<?php echo $_GET['createBlog'];?>">Log out</a>
               </nav>

            </div>
        </header>
        <!-- ----------------- -->

       
        <!-- ------------------------- CONTENT MAIN CONTAINERS ----------------- -->
        <section class="card">
            
            <!-- card post -->
            <div class="wrapper">

                <!-- form -->
                <form action="" method="post" enctype="multipart/form-data">
                    <!-- user post and category -->
                    <main class="contents">

                        <!-- user profile -->
                        <div class="user-profile">
                                                   <!-- ! adjusted -->
                        <img class="pic" src="<?php echo get_Users_Profile($_GET['createBlog']);?>" width="50" height="50" alt="profile">
                        </div>

                        <!-- user info -->
                        <div class="user-about">
                            <h1><?php echo $_SESSION['active']?></h1>
                            <p><?php echo date("M d, Y");?></p>
                        </div>
                    
                        <!-- category selection -->
                        <div class="category">   

                            <select name="f_category[]" id="">
                                <option value="Others" selected>--- Category ---</option>
                                <option value="Leisure & Travel">Leisure & Travel</option>
                                <option value="Fitness and Wellness">Fitness and Wellness</option>
                                <option value="DIY and Crafts">DIY and Crafts</option>
                                <option value="Food and Cooking">Food and Cooking</option>
                                <option value="Technology and Gadgets">Technology and Gadgets</option>
                                <option value="Fashion and Beauty">Fashion and Beauty</option>
                                <option value="Game and Sports">Game and Sports</option>
                                <option value="Others">Others</option>
                            </select>

                        </div>
                        
                    </main>
                    <!-- ------------------- -->

                    
                    <!-- descriptions -->
                    <main class="description">
                        <div>

                            <!-- blog title -->
                            <div class="input-design">
                                <input type="text" name="f_entry" placeholder="Title of blog..">
                            </div>

                            <!-- blog descriptions -->
                        <div class="input-design">
                            <textarea name="f_content"  cols="20" rows="4" placeholder="Say something..."></textarea>
                        </div>
                        
                        </div>
                    </main>
                    <!-- ---- -->


                    <!-- upload picture -->
                    <main class="post_pic">
                        <div class="picture-post">
                            <input type="file" name="f_upload" accept="image/*">
                        </div>
                    </main>
                    <!-- --- -->

                    <!-- post button -->
                    <main>
                        <div class="button-field ">
                            <button class="form_btn" type="submit" name="post" value="">Post</button>
                        </div>
                    </main> 
                    <!-- -- -->
                </form>
                <!-- -- -->

            </div>
        </section>
        <!-- ---------------------------------- -->

    </body>
</html>





<?php

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


if(isset($_POST['post'])){

    $entry = $_POST['f_entry'];
    $content = $_POST['f_content'];
    $oldDIR = $_FILES['f_upload']['tmp_name'];
    $fileNAME = $_FILES['f_upload']['name'];
    $newDIR = "../images/upload/".$fileNAME;
    $username = $_GET['createBlog'];
    $cat = "";
    foreach($_POST['f_category'] as $c){
        $cat = $c;
    }

    move_uploaded_file($oldDIR , $newDIR);//<-- move to new folder directory
    
    # the file uploaded via new image path name [$newDIR]
    $query = "INSERT INTO POST (username, blog_title, blog_content, dateTime_created, blog_cat, blog_pic) ".
                "VALUES ('$username','$entry','$content',LOCALTIMESTAMP(),'$cat','$newDIR')";

    mysqli_query($conn, $query);
    echo "<script>window.location.href='home.php'</script>"; //<-- direct to homepage

}


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

function change_Status($user)
{
    require '../connection/config.php';
    
    $query = "UPDATE ACCOUNTS SET status = 'inactive' WHERE username='".$user."'";
    mysqli_query($conn, $query); 
}


?>

