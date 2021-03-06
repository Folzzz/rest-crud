<?php
    //HEADERS
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    //IMPORT DATABASE AND POST MODEL
    include_once '../../config/Database.php';
    include_once '../../models/Post.php';
    
    //INSTANTIATE DATABASE OBJECT
    $database = new Database();
    //CONNECTION VARIABLE
    $db = $database->connect();

    //INSTANTIATE POST OBJECT
    $post = new Post($db);

    // GET THE RAW POSTED DATA
    $data = json_decode(file_get_contents("php://input"));

    $post->title = $data->title;
    $post->body = $data->body;
    $post->author = $data->author;
    $post->category_id = $data->category_id;

    //CREATE POST
    if ($post->create()) {
        echo json_encode(
            array('Message' => 'Post Created')
        );
    } else {
        echo json_encode(
            array('Message' => 'Post Not Created')
        );
    }

?>