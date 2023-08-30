<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validUsername = 'runtec@local.local';
    $validPassword = '1tzjabSQ';

    // Получаем данные из POST-запроса
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $jsonData = $_POST['json'] ?? '';
    $type = $_POST['type'] ?? '';

    // Проверяем введенные данные на соответствие хардкодированным значениям
    if ($username === $validUsername && $password === $validPassword) {
        // Проверка прошла успешно, продолжаем выполнение

        // Создаем каталог для сохранения файлов, если его нет
        $directory = './json_data';
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true); // Создаем каталог со всеми правами доступа
        }

        // Генерируем уникальное имя файла на основе типа и текущей даты и времени
        $timestamp = date('Y-m-d_H-i-s');
        $filename = $type . '_' . $timestamp . '.json';

        // Полный путь к файлу
        $filepath = $directory . '/' . $filename;

        // Сохраняем JSON в файл
        file_put_contents($filepath, $jsonData);

        // Возвращаем имя сохраненного файла в ответе на запрос
        echo json_encode(['filename' => 'api/'.$filepath]);
    } else {
        // Неверные учетные данные
        echo json_encode(['error' => 'Invalid credentials']);
    }
} else {
    // Запрос не является POST-запросом
    echo json_encode(['error' => 'Invalid request method']);
}

