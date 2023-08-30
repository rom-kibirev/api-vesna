<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$hardLogin = "runtec@local.local";
$hardPassword = "1tzjabSQ";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Запрос POST для проверки логина и пароля

    // Получение данных из запроса
    $username = $_POST['username'];
    $password = $_POST['password'];

     // Проверка логина и пароля
    if ($username === $hardLogin && $password === $hardPassword) {
        // Верные логин и пароль

        // Формирование данных для отправки в ответе
        $responseData = array(
            'message' => 'Авторизация прошла успешно',
            'showButtons' => true
        );

        // Отправка данных в формате JSON
        header('Content-Type: application/json');
        echo json_encode($responseData);
    }
    else {
        // Неверные логин или пароль

        // Формирование данных для отправки в ответе
        $responseData = array(
            'message' => 'Ошибка авторизации',
            'showButtons' => false,
            'req' => [$username,$hardLogin,$password,$hardPassword,$_POST['username'],$_POST['password']]
        );

        // Отправка данных в формате JSON
        header('Content-Type: application/json');
        echo json_encode($responseData);
    }
}
elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Запрос GET для получения данных со стороннего сервера

    // Получение команды из запроса
    $command = $_GET['command'];

    // Проверка авторизации
    if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
        $_SERVER['PHP_AUTH_USER'] !== $hardLogin || $_SERVER['PHP_AUTH_PW'] !== $hardPassword) {
        // Неверные логин или пароль

        http_response_code(401); // Отправка кода ошибки 401 Unauthorized
        echo 'Ошибка авторизации';
        exit;
    }

    // Формирование URL для отправки запроса
    $url = $_GET['url'] . '/?login=' . urlencode($hardLogin) .
        '&password=' . urlencode($hardPassword) . '&command=' . urlencode($command);

    // Отправка GET-запроса
    $response = file_get_contents($url);

    if ($response === false) {
        // Ошибка при получении данных

        http_response_code(500); // Отправка кода ошибки 500 Internal Server Error
        echo 'Ошибка при получении данных';
        exit;
    }

    // Отправка данных в ответе
    echo $response;
}
else {
    // Неподдерживаемый метод запроса

    http_response_code(405); // Отправка кода ошибки 405 Method Not Allowed
    echo 'Неподдерживаемый метод запроса';
}

?>
