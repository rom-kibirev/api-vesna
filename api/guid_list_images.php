<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validUsername = 'runtec@local.local';
    $validPassword = '1tzjabSQ';

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $type = $_POST['type'] ?? '';

    if ($username === $validUsername && $password === $validPassword) {

        if ($type === 'goods') {
            $response = array('76834f38-b663-4600-adaf-3de690dc0db4', '6dd28ce3-fa29-11e9-90fd-0c9d92c47525', '16146959-1906-4d83-bb5d-4be5625737ca', '49709577-5945-11e6-8106-002590d99cf6', '2c821a20-b7c5-4d2d-9370-de1507822840');
        } elseif ($type === 'category') {
            $response = array('04b7c17b-f44a-11de-94a9-0015175303fd', '04b7c133-f44a-11de-94a9-0015175303fd', '04b7c159-f44a-11de-94a9-0015175303fd', '04b7c173-f44a-11de-94a9-0015175303fd');
        } else {
            $response = array('error' => 'Invalid command');
        }
    } else {
        $response = array('error' => 'Invalid credentials');
    }
}

echo json_encode($response);
