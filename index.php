<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Controller\ContactController;

$controller = new ContactController();

function handleRequest($method, $controller) {
    $publicDir = __DIR__ . '/public';
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $filePath = $publicDir . $requestUri;

    if (is_file($filePath)) {
        header('Content-Type: ' . mime_content_type($filePath));
        readfile($filePath);
        exit;
    }

    if ($requestUri === '/contact') {
        header('Content-Type: application/json');

        switch ($method) {
            case 'POST':
                if (isset($_POST['name'], $_POST['phone'], $_POST['email'], $_POST['address'])) {
                    $response = $controller->createContact($_POST['name'], $_POST['phone'], $_POST['email'], $_POST['address']);
                } else {
                    $response = [
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'Missing parameters for creating contact.'
                    ];
                }
                break;

                case 'GET':
                    if (isset($_GET['id'])) {
                        $response = $controller->getContact((int)$_GET['id']);
                    } else {
                        $response = $controller->getContact(); 
                    }
                    break;
                
            case 'PUT':
                parse_str(file_get_contents('php://input'), $put_vars);
                if (isset($_GET['id'], $put_vars['name'], $put_vars['phone'], $put_vars['email'], $put_vars['address'])) {
                    $response = $controller->updateContact((int)$_GET['id'], $put_vars['name'], $put_vars['phone'], $put_vars['email'], $put_vars['address']);
                } else {
                    $response = [
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'Missing parameters for updating contact.'
                    ];
                }
                break;

            case 'DELETE':
                if (isset($_GET['id'])) {
                    $response = $controller->deleteContact((int)$_GET['id']);
                } else {
                    $response = [
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'No ID specified for deletion.'
                    ];
                }
                break;

            default:
                $response = [
                    'status' => 'error',
                    'code' => 405,
                    'message' => 'Method not allowed.'
                ];
                break;
        }

        echo json_encode($response);
        exit;
    }

    if ($requestUri === '/' || $requestUri === '/index.php') {
        require $publicDir . '/index.php';
        exit;
    }

    header('HTTP/1.1 404 Not Found');
    echo json_encode([
        'status' => 'error',
        'code' => 404,
        'message' => 'Not Found'
    ]);
}

handleRequest($_SERVER['REQUEST_METHOD'], $controller);
?>
