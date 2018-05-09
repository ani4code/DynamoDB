<?php
session_start();


include("config.php");
$msg="";
 $user=$_SESSION['username'];
if(isset($_POST['but_upload'])){

 $name = $_FILES['file']['name'];
 $target_dir = "images/";
 $target_file = $target_dir . basename($_FILES["file"]["name"]);
 //$image_text = mysqli_real_escape_string($db, $_POST['image_text']);
 

 // Select file type
 $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

 // Valid file extensions
 $extensions_arr = array("jpg","jpeg","png","gif");
 // Check extension
 if( in_array($imageFileType,$extensions_arr) ){
      // Insert record
    
  $query = "insert into images(name, user) values('".$name."','".$user."')";
  mysqli_query($connection,$query);
  
  // Upload file
  move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name);
  header("location: welcome.php");

 }
 

}


$sql = "select * from images where user='$user'";
$result = mysqli_query($connection,$sql);

?>
<html>
   
   <head>
      <title>Welcome </title>
   </head>
   
   <body>
       <h1>Welcome <?php echo ($_SESSION['username']); ?></h1> 
      <h2><a href = "logout.php">Sign Out</a></h2>
      
      <div class="container">
          <div class="row">
               <?php
    while ($row = mysqli_fetch_array($result)) {  
      	echo "<img width=100 height=100 src='images/".$row['name']."' >&nbsp";
      	//echo "<p>".$row['image_text']."</p>";
     
    }
  ?>
          </div>
          <div class="row">
              <div class="form-group">
             <form method="POST" action="" enctype='multipart/form-data'>
                <input type='file' name='file' />
                 <input type='submit' value='Save name' name='but_upload'>
  
            </form>
                  </div>
          </div>
      
      </div>
      
      
      
   </body>
   
</html>