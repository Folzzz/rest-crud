<?php
    //HEADERS
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    //IMPORT DATABASE AND POST MODEL
    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    //INSTANTIATE DATABASE OBJECT
    $database = new Database();
    //CONNECTION VARIABLE
    $db = $database->connect();

    //INSTANTIATE POST
    $post = new Post($db);

    //GET RAW DATA
    $data = json_decode(file_get_contents("php://input"));

    //SET ID TO UPDATE
    $post->id = $data->id;

    $post->title = $data->title;
    $post->body = $data->body;
    $post->author = $data->author;
    $post->category_id = $data->category_id;

    //UPDATE POST
    if ($post->update()) {
        echo json_encode(
            array("Message" => "Post Updated")
        );
    } else {
        echo json_encode(
            array("Message" => "Post not Updated")
        );
    }
?>