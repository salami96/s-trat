<?php

require 'vendor/autoload.php';

use SMSGatewayMe\Client\ApiClient;
use SMSGatewayMe\Client\Configuration;
use SMSGatewayMe\Client\Api\MessageApi;
use SMSGatewayMe\Client\Model\SendMessageRequest;

// Configure client
$config = Configuration::getDefaultConfiguration();
$config->setApiKey('Authorization', '****');
$apiClient = new ApiClient($config);
$messageClient = new MessageApi($apiClient);

// Sending a SMS Message
$sendMessageRequest1 = new SendMessageRequest([
    'phoneNumber' => '****',
    'message' => '****',
    'deviceId' => 1
]);
$sendMessageRequest2 = new SendMessageRequest([
    'phoneNumber' => '***',
    'message' => '****',
    'deviceId' => 2
]);
$sendMessages = $messageClient->sendMessages([
    $sendMessageRequest1,
    $sendMessageRequest2
]);
print_r($sendMessages);
?>
