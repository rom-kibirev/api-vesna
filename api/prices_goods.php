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
    $priceData = $_POST['json'] ?? '';

    // Проверка авторизации
    if ($username === $validUsername && $password === $validPassword) {
        $decodedPriceData = json_decode($priceData, true);

        if ($decodedPriceData) {
            foreach ($decodedPriceData as $item) {
                $guid = $item['guid'];
                $prices = $item['prices'];

                // Создание директории, если она не существует
                if (!is_dir('prices')) {
                    mkdir('prices', 0755, true);
                }

                // Сохранение данных в файл
                $filename = "prices/{$guid}.json";
                $fileContent = json_encode($prices, JSON_PRETTY_PRINT);

                if (file_put_contents($filename, $fileContent)) {
                    $response[] = "Data for guid '{$guid}' saved successfully.";
                } else {
                    $response[] = "Error saving data for guid '{$guid}'.";
                }
            }
        } else {
            $response[] = "Invalid JSON data.";
        }
    } else {
        $response[] = "Invalid credentials.";
    }
} else {
    $response[] = "Invalid request method.";
}

echo json_encode($response);
?>
