<?php
    //header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');

    //IMPORT THE DATABASE AND CATEGORY MODEL
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    //instantiate database object
    $database = new Database();
    //connection variable
    $db = $database->connect();

    //instantiate category object
    $category = new Category($db);

    //get the raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $category->name = $data->name;

    //create category
    if($category->create()){
        echo json_encode(
            array(
                'message' => 'category created'
            )
        );
    } else {
        echo json_encode(
            array(
                'message' => 'category not created'
            )
        );
    }

?>