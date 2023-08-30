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
    $json = $_POST['json'] ?? '';

    // Проверка валидности
    if ($username === $validUsername && $password === $validPassword) {
        $data = json_decode($json, true);

        if ($data !== null) {
            $directory = './images';
            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
            }

            foreach ($data as $item) {
                $guid = $item['guid'];
                $pictures = $item['pictures'];
                $allPicturesValid = true;

                foreach ($pictures as $index => $base64Image) {
                    $imageData = base64_decode($base64Image);
                    if ($imageData !== false) {
                        // Сохранение в файл JPEG
                        $imageFileName = $directory . '/' . $guid . '_' . $index . '.jpg';
                        if (file_put_contents($imageFileName, $imageData) === false) {
                            $allPicturesValid = false;
                        }

                        // Сохранение в файл Base64
                        $base64FileName = $directory . '/' . $guid . '_' . $index . 'base64';
                        if (file_put_contents($base64FileName, $base64Image) === false) {
                            $allPicturesValid = false;
                        }


                    } else {
                        $allPicturesValid = false;
                    }
                }

                if ($allPicturesValid) {
                    $response[] = array(
                        'status' => 'success',
                        'message' => 'Data saved successfully: ' . $guid
                    );
                } else {
                    $response[] = array(
                        'status' => 'error',
                        'message' => 'Invalid image(s) for guid: ' . $guid
                    );
                }
            }
        } else {
            $response[] = array(
                'status' => 'error',
                'message' => 'Invalid JSON data'
            );
        }
    } else {
        $response[] = array(
            'status' => 'error',
            'message' => 'Invalid username or password'
        );
    }
} else {
    $response[] = array(
        'status' => 'error',
        'message' => 'Invalid request method'
    );
}

header('Content-Type: application/json');
echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>
