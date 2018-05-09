<?php
require 'vendor/aws-autoloader.php';

date_default_timezone_set('UTC');

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;
if(isset($_POST) & !empty($_POST)){
/* 	echo $_POST['userid'];
	echo $_POST['email'];
	echo $_POST['name'];
	echo $_POST['passwords']; */
 $sdk = new Aws\Sdk([
   // 'endpoint'   => '',
    'region'   => 'us-east-2',
    'version'  => 'latest'
]);

$dynamodb = $sdk->createDynamoDb();
$marshaler = new Marshaler();

$tableName = 'Users';
//echo $userid;
//$UserID = $_POST['userid'];
$Email = $_POST['email'];//'gangi@email.com';
$Name = $_POST['name'];//'Gangi';


$item = $marshaler->marshalJson('
    {
        
		"UserName": "'.$Name.'",
		"Email": "'.$Email.'"
    }
');

$params = [
    'TableName' => $tableName,
    'Item' => $item
];


try {
	//echo "try block";
    $result = $dynamodb->putItem($params);
    echo "Added item: $Email - $Name - $Password\n";


} catch (DynamoDbException $e) {
    echo "Unable to add item:\n";
    echo $e->getMessage() . "\n";
} 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
<?php if(isset($smsg)){ ?><div class="alert alert-success alert-dismissible" > <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?php echo $smsg; ?> </div><?php } ?>
      <?php if(isset($fmsg)){ ?><div class="alert alert-danger alert-dismissible" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <?php echo $fmsg; ?> </div><?php } ?>
	<div class="row">
		<div class="col-sm-4">
		</div>
		<div class="col-sm-4">
<h2> Basic Form</h2>

	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
	<!-- <div class="form-group">
			<label for="id"><span class="error">*</span>UserID:</label>
			 <input type="text" class="form-control" name="userid" value="<?php echo $userid;?>" placeholder="Enter UserID">	
				<span class="error"><?php echo $emailErr;?></span>			 
		</div> -->
		
		<div class="form-group">
			<label for="name"><span class="error">*</span>Name:</label>
			<input type="text" class="form-control" name="name" pattern="[a-z]{3,15}" value="<?php echo $name;?>" placeholder="Enter Name">
		</div> 
		
		<div class="form-group">
			<label for="email"><span class="error">*</span>Email:</label>
			 <input type="email" class="form-control" name="email" value="<?php echo $email;?>" placeholder="Enter Email">	
				<span class="error"><?php echo $emailErr;?></span>			 
		</div>
		
       <!--  <div class="form-group">
        <label for="inputPassword">Password</label>
        <input type="password" name="password" id="inputPassword"  class="form-control" placeholder="Password" required>
        </div> -->
		
        <!--<div class="form-group">
        <label for="inputPassword">Confirm Password</label>
        <input type="password" name="repassword" id="inputrePassword"  class="form-control" placeholder="Confirm Password" required>
        </div> -->
		
		<button type="submit" class="btn btn-default">Submit</button>
		</form>
		</div>
		<div class="col-sm-4">
		</div>

</body>
</html>
