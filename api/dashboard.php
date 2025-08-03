<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration (you'll need to set up a database)
$db_config = [
    'host' => 'localhost',
    'dbname' => 'todays_news',
    'username' => 'root',
    'password' => ''
];

// Simple file-based storage for demo purposes
$data_dir = '../data/';
if (!file_exists($data_dir)) {
    mkdir($data_dir, 0777, true);
}

$posts_file = $data_dir . 'posts.json';
$arad_file = $data_dir . 'arad.json';
$settings_file = $data_dir . 'settings.json';

// Initialize files if they don't exist
if (!file_exists($posts_file)) {
    file_put_contents($posts_file, json_encode([]));
}
if (!file_exists($arad_file)) {
    file_put_contents($arad_file, json_encode([
        'section1' => '',
        'section2' => ''
    ]));
}
if (!file_exists($settings_file)) {
    file_put_contents($settings_file, json_encode([
        'site_title' => "Today's News",
        'site_description' => 'We provide all useful information government job, information, health tips, current affair etc.',
        'admin_email' => 'admin@todaysnews.com'
    ]));
}

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

try {
    switch ($method) {
        case 'GET':
            handleGet($action);
            break;
        case 'POST':
            handlePost($action);
            break;
        case 'PUT':
            handlePut($action);
            break;
        case 'DELETE':
            handleDelete($action);
            break;
        default:
            throw new Exception('Method not allowed');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}

function handleGet($action) {
    global $posts_file, $arad_file, $settings_file;
    
    switch ($action) {
        case 'posts':
            $posts = json_decode(file_get_contents($posts_file), true);
            echo json_encode(['posts' => $posts]);
            break;
            
        case 'post':
            $id = $_GET['id'] ?? null;
            if (!$id) {
                throw new Exception('Post ID required');
            }
            $posts = json_decode(file_get_contents($posts_file), true);
            $post = array_filter($posts, function($p) use ($id) {
                return $p['id'] == $id;
            });
            if (empty($post)) {
                throw new Exception('Post not found');
            }
            echo json_encode(['post' => array_values($post)[0]]);
            break;
            
        case 'arad':
            $arad = json_decode(file_get_contents($arad_file), true);
            echo json_encode(['arad' => $arad]);
            break;
            
        case 'settings':
            $settings = json_decode(file_get_contents($settings_file), true);
            echo json_encode(['settings' => $settings]);
            break;
            
        case 'stats':
            $posts = json_decode(file_get_contents($posts_file), true);
            $stats = [
                'total_posts' => count($posts),
                'published_posts' => count(array_filter($posts, function($p) {
                    return $p['status'] === 'published';
                })),
                'draft_posts' => count(array_filter($posts, function($p) {
                    return $p['status'] === 'draft';
                })),
                'categories' => count(array_unique(array_column($posts, 'category')))
            ];
            echo json_encode(['stats' => $stats]);
            break;
            
        default:
            throw new Exception('Invalid action');
    }
}

function handlePost($action) {
    global $posts_file;
    
    $input = json_decode(file_get_contents('php://input'), true);
    
    switch ($action) {
        case 'posts':
            if (!isset($input['title']) || !isset($input['content'])) {
                throw new Exception('Title and content are required');
            }
            
            $posts = json_decode(file_get_contents($posts_file), true);
            $new_post = [
                'id' => uniqid(),
                'title' => $input['title'],
                'content' => $input['content'],
                'category' => $input['category'] ?? 'general',
                'image' => $input['image'] ?? '',
                'tags' => $input['tags'] ?? '',
                'status' => $input['status'] ?? 'published',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $posts[] = $new_post;
            file_put_contents($posts_file, json_encode($posts, JSON_PRETTY_PRINT));
            
            echo json_encode(['message' => 'Post created successfully', 'post' => $new_post]);
            break;
            
        default:
            throw new Exception('Invalid action');
    }
}

function handlePut($action) {
    global $posts_file, $arad_file, $settings_file;
    
    $input = json_decode(file_get_contents('php://input'), true);
    
    switch ($action) {
        case 'posts':
            $id = $_GET['id'] ?? null;
            if (!$id) {
                throw new Exception('Post ID required');
            }
            
            $posts = json_decode(file_get_contents($posts_file), true);
            $post_index = array_search($id, array_column($posts, 'id'));
            
            if ($post_index === false) {
                throw new Exception('Post not found');
            }
            
            $posts[$post_index] = array_merge($posts[$post_index], $input, [
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            
            file_put_contents($posts_file, json_encode($posts, JSON_PRETTY_PRINT));
            echo json_encode(['message' => 'Post updated successfully', 'post' => $posts[$post_index]]);
            break;
            
        case 'arad':
            $arad = json_decode(file_get_contents($arad_file), true);
            $arad = array_merge($arad, $input);
            file_put_contents($arad_file, json_encode($arad, JSON_PRETTY_PRINT));
            echo json_encode(['message' => 'Arad sections updated successfully', 'arad' => $arad]);
            break;
            
        case 'settings':
            $settings = json_decode(file_get_contents($settings_file), true);
            $settings = array_merge($settings, $input);
            file_put_contents($settings_file, json_encode($settings, JSON_PRETTY_PRINT));
            echo json_encode(['message' => 'Settings updated successfully', 'settings' => $settings]);
            break;
            
        default:
            throw new Exception('Invalid action');
    }
}

function handleDelete($action) {
    global $posts_file;
    
    switch ($action) {
        case 'posts':
            $id = $_GET['id'] ?? null;
            if (!$id) {
                throw new Exception('Post ID required');
            }
            
            $posts = json_decode(file_get_contents($posts_file), true);
            $posts = array_filter($posts, function($p) use ($id) {
                return $p['id'] != $id;
            });
            
            file_put_contents($posts_file, json_encode(array_values($posts), JSON_PRETTY_PRINT));
            echo json_encode(['message' => 'Post deleted successfully']);
            break;
            
        default:
            throw new Exception('Invalid action');
    }
}
?> 