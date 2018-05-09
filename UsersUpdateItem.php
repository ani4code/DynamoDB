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

 
$eav = $marshaler->marshalJson('
    {
        ":e": "reddy@email.com" 
       
    }
');

$params = [
    'TableName' => $tableName,
    'Key' => $key,
    'UpdateExpression' => 
        'set Email = :e',
    'ExpressionAttributeValues'=> $eav,
    'ReturnValues' => 'UPDATED_NEW'
];

try {
    $result = $dynamodb->updateItem($params);
    echo "Updated item.\n";
    print_r($result['Attributes']);

} catch (DynamoDbException $e) {
    echo "Unable to update item:\n";
    echo $e->getMessage() . "\n";
}

?>
