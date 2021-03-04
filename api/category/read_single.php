<?php
    //headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    //IMPORT THE DATABASE AND POST MODEL
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    //instantiate database object
    $database = new Database();
    //connection variable
    $db = $database->connect();

    //instantiate category object
    $category = new Category($db);

    //get id from url
    $category->id = isset($_GET['id']) ? $_GET['id'] : die();
    //call read_single object
    $category->read_single();

    //create array
    $category_arr = array(
        'id' => $category->id,
        'name' => $category->name,
        'created_at' => $category->created_at
    );

    //convert/grt to json
    print_r(json_encode($category_arr));
?>