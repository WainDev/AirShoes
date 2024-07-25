<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id']) && isset($_POST['product_name']) && isset($_POST['product_price']) && isset($_POST['product_image'])) {
        $product = [
            'id' => $_POST['product_id'],
            'name' => $_POST['product_name'],
            'price' => $_POST['product_price'],
            'image' => $_POST['product_image']
        ];

        if (!isset($_SESSION['favorites'])) {
            $_SESSION['favorites'] = [];
        }


        if (!is_array($_SESSION['favorites'])) {
            $_SESSION['favorites'] = [];
        }


        $favorites = $_SESSION['favorites'];
        $found = false;
        foreach ($favorites as $fav) {
            if ($fav['id'] == $product['id']) {
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['favorites'][] = $product;
        }

        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

header("Location: Card.php");
exit;
