<?php
header('Content-Type: application/json');

$title = $_POST['title'] ?? '';
$content = $_POST['content'] ?? '';

if (!$title || !$content) {
    echo json_encode(['success' => false]);
    exit;
}

$file = 'objects.json';
$data = json_decode(file_get_contents($file), true) ?? [];
$data[] = ['title' => $title, 'content' => $content];

file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo json_encode(['success' => true]);
?>
