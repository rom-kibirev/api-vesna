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
    $quantityData = $_POST['json'] ?? ''; // Получаем данные "quantity" из POST-запроса

    // Проверяем верификацию по имени пользователя и паролю
    if ($username === $validUsername && $password === $validPassword) {
        $data = json_decode($quantityData, true); // Преобразуем JSON в ассоциативный массив

        if (is_array($data)) {
            foreach ($data as $item) {
                $guid = $item['guid'];
                $jsonData = json_encode($item, JSON_PRETTY_PRINT); // Красивое форматирование JSON данных

                // Создаем директорию "quantity", если она не существует
                if (!is_dir('quantity')) {
                    mkdir('quantity');
                }

                // Сохраняем данные в файл с именем, равным guid, внутри директории "quantity"
                $filename = 'quantity/' . $guid . '.json';
                file_put_contents($filename, $jsonData);

                $response[] = array(
                    'guid' => $guid,
                    'status' => 'Data saved successfully',
                );
            }
        } else {
            $response['error'] = 'Invalid "quantity" data format';
        }
    } else {
        $response['error'] = 'Invalid credentials';
    }
} else {
    $response['error'] = 'Invalid request method';
}

// Возвращаем ответ клиенту в формате JSON
header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);
?>
