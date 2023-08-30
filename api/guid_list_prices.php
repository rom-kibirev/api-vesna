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

    if ($username === $validUsername && $password === $validPassword) {

        $priceTypes = array(
            'a2896017-fe5f-11dc-a014-001731520b3d', // Розничные
            '33598c30-e91f-11dd-90b9-0015175303fd', // Опт 1 (от 2000 у.е)
            'd035c3a6-ce27-11ed-af77-7c10c921f6a6' // Маркетплейс_Розничные
        );

        $currencyTypes = array(
            '01ca606a-5b93-4523-aee5-b7d9ecf372d2', // руб
            '371712fa-ed26-11ea-9107-0c9d92c47525', // теньге
            '9634e7e3-b7f5-4edd-888d-a9b86814fb07' // евро
        );

        $response = array(
            'price_types' => $priceTypes,
            'currency_types' => $currencyTypes
        );
    } else {
        $response = array('error' => 'Invalid credentials');
    }
}

echo json_encode($response);

?>