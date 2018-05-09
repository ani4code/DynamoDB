<?php
require 'vendor/aws-autoloader.php';

date_default_timezone_set('UTC');

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

$sdk = new Aws\Sdk([
   // 'endpoint'   => 'http://localhost:8000',
    'region'   => 'us-east-2',
    'version'  => 'latest'
]);

$dynamodb = $sdk->createDynamoDb();
$marshaler = new Marshaler();

$tableName = 'Users';

$User = "reddy";//$_POST['userid'];
//$Email = $_POST['email'];//'gangi@email.com';
//$Name = $_POST['name'];//'Gangi';

$key = $marshaler->marshalJson('
    {
        "UserName": "'.$User.'"
    }
');

 
/* $eav = $marshaler->marshalJson('
    {
        ":e": "Reddy@email.com" 
       
    }
'); */

$params = [
    'TableName' => $tableName,
    'Key' => $key
    //'ConditionExpression' => 
      //  'set Email = :e',
    //'ExpressionAttributeValues'=> $eav
];

try {
    $result = $dynamodb->deleteItem($params);
    echo "Deleted item.\n";
    print_r($result['Attributes']);

} catch (DynamoDbException $e) {
    echo "Unable to delete item:\n";
    echo $e->getMessage() . "\n";
}

?>
