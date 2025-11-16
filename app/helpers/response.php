<?php
function json_success($data = [], $msg = 'Success') {
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'message' => $msg] + $data);
    exit;
}

function json_error($msg, $code = 400) {
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => $msg]);
    exit;
}