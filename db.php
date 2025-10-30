<?php
header('Content-Type: application/json; charset=utf-8');

$host = "localhost";
$user = "OlhaBendik";
$pass = "Bendik6266";
$db   = "php";

$connection = new mysqli($host, $user, $pass, $db);
if ($connection->connect_error) {
    http_response_code(500);
    echo json_encode(['status'=>'error','message'=>'db_connect','error'=>$connection->connect_error]);
    exit;
}
$connection->set_charset("utf8mb4");

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    // Намагаємося читати з різних джерел 
    $page = $_POST['page'] ?? null;
    $index = isset($_POST['index']) ? intval($_POST['index']) : null;
    $content = $_POST['content'] ?? null;

    if (empty($_POST)) {
        $raw = file_get_contents('php://input');
        $json = json_decode($raw, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $page = $json['page'] ?? $page;
            $index = isset($json['index']) ? intval($json['index']) : $index;
            $content = $json['content'] ?? $content;
        } else {
            // Якщо raw - form-encoded string
            parse_str($raw, $parsed);
            if (!empty($parsed)) {
                $page = $parsed['page'] ?? $page;
                $index = isset($parsed['index']) ? intval($parsed['index']) : $index;
                $content = $parsed['content'] ?? $content;
            }
        }
    }

    // fallback: якщо page пустий 
    if (!$page) {
        $page = basename($_SERVER['HTTP_REFERER'] ?? $_SERVER['SCRIPT_NAME'] ?? 'index.php');
    }

    $page = (string) trim($page);
    $content = (string) $content;
    $content = trim($content);

    $errors = [];
    if ($page === '') $errors[] = 'empty_page';
    if (!is_int($index) || $index < 0) $errors[] = 'invalid_index';
    if ($content === '') $errors[] = 'empty_content';

    if (!empty($errors)) {
        echo json_encode([
            'status'=>'error',
            'message'=>'Invalid input',
            'errors'=>$errors,
            'received'=>['page'=>$page,'index'=>$index,'content_preview'=>mb_substr($content,0,200)]
        ]);
        $connection->close();
        exit;
    }

    $postData = $connection->prepare("INSERT INTO page_content (page, element_index, content) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE content=VALUES(content), last_update=NOW()");
    $postData->bind_param("sis", $page, $index, $content);

    if ($postData->execute()) {
        echo json_encode(['status'=>'ok']);
    } else {
        echo json_encode(['status'=>'error','message'=>'db_error','db_error'=>$postData->error]);
    }
    $postData->close();
    $connection->close();
    exit;
}

// Повертаємо JSON зі сторінки
if ($method === 'GET') {
    $page = basename($_GET['page'] ?? basename($_SERVER['SCRIPT_NAME'] ?? 'index.php'));
    $dbContent = [];
    $postData = $connection->prepare("SELECT element_index, content FROM page_content WHERE page=?");
    $postData->bind_param("s", $page);
    $postData->execute();
    $result = $postData->get_result();
    while ($row = $result->fetch_assoc()) {
        $dbContent[$row['element_index']] = $row['content'];
    }
    $postData->close();
    $connection->close();
    echo json_encode($dbContent);
    exit;
}

echo json_encode(['status'=>'error','message'=>'unsupported_method']);
