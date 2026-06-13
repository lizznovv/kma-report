<?php

$email = $_GET['email'] ?? null;
if (empty($email)) {
    http_response_code(400);
    echo 'Email parameter is required';
    exit;
}

if (empty($_GET['from'])) {
    http_response_code(400);
    exit('"from" date parameter is required');
}
$from = new DateTime($_GET['from']);

if (empty($_GET['to'])) {
    http_response_code(400);
    exit('"to" date parameter is required');
}
$to = new DateTime($_GET['to']);

require_once __DIR__ . '/../src/Task.php';
require_once __DIR__ . '/../src/BitrixClient.php';
require_once __DIR__ . '/../src/ReportBuilder.php';
require_once __DIR__ . '/../src/Mailer.php';

$client = new BitrixClient('', 207);
$tasks = $client->getClosedTasks($from, $to);

echo '<pre>';
print_r($tasks);

try {
    $builder = new ReportBuilder();
    $result = $builder->build($tasks);
}
catch (\Exception $e) {echo error_get_last();}

$result = $builder->formatToText($result);

echo '<pre>';
print_r($result);

$mailer = new Mailer();
$mailer->send($email, (string)$result);

