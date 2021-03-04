<?php
    //HEADERS
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    //IMPORT THE DATABASE AND POST MODEL
    include_once '../../config/Database.php';
    include_once '../../models/Post.php';
    
    //INSTANTIATE DATABASE OBJECT
    $database = new Database();
    //CONNECTION VARIABLE
    $db = $database->connect();

    //INSTANTIATE POST OBJECT
    $post = new Post($db);

    //GET ID FROM URL
    $post->id = isset($_GET['id']) ? $_GET['id'] : die();

    //CALL READ_SINGLE OBJECT (get post)
    $post->read_single();
    
    //CREATE ARRAY
    $post_arr = array(
        'id' => $post->id,
        'title' => $post->title,
        'body' => html_entity_decode($post->body),
        'author' => $post->author,
        'category_id' => $post->category_id,
        'category_name' => $post->category_name
    );

    //CONVERT/GET TO JSON
    print_r(json_encode($post_arr));
?>