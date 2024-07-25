<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];

        if (isset($_SESSION['favorites']) && is_array($_SESSION['favorites'])) {
            foreach ($_SESSION['favorites'] as $key => $product) {
                if ($product['id'] == $product_id) {
                    unset($_SESSION['favorites'][$key]);
                    $_SESSION['favorites'] = array_values($_SESSION['favorites']);
                    echo json_encode(['status' => 'success']);
                    exit;
                }
            }
        }

        echo json_encode(['status' => 'error', 'message' => 'Product not found']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
