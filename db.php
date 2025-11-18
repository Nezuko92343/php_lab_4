<?php
header('Content-Type: application/json; charset=utf-8');

$host = "localhost";
$user = "OlhaBendik";
$pass = "Bendik6266";
$db   = "php";

$connection = new mysqli($host, $user, $pass, $db);
if ($connection->connect_error) {
    echo json_encode(['status'=>'error','message'=>'db_connect','error'=>$connection->connect_error]);
    exit;
}
$connection->set_charset("utf8mb4");

$method = $_SERVER['REQUEST_METHOD'];
$page = basename($_REQUEST['page'] ?? basename($_SERVER['SCRIPT_NAME'] ?? 'index.php'));

if ($method === 'POST') {
    $index = isset($_POST['index']) ? intval($_POST['index']) : null;
    $content = $_POST['content'] ?? '';

    if ($index === null || $content === '') {
        echo json_encode(['status'=>'error','message'=>'empty_fields']);
        $connection->close();
        exit;
    }

    $stmt = $connection->prepare("INSERT INTO collapse_objects (page, element_index, content) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE content=VALUES(content), last_update=NOW()");
    $stmt->bind_param("sis", $page, $index, $content);
    $stmt->execute();
    $stmt->close();

    echo json_encode(['status'=>'ok']);
    $connection->close();
    exit;
}

if ($method === 'GET') {
    $dbContent = [];
    $stmt = $connection->prepare("SELECT element_index, content FROM collapse_objects WHERE page=?");
    $stmt->bind_param("s", $page);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $dbContent[$row['element_index']] = $row['content'];
    }
    $stmt->close();
    $connection->close();
    echo json_encode($dbContent);
    exit;
}

echo json_encode(['status'=>'error','message'=>'unsupported_method']);
$connection->close();
?>
