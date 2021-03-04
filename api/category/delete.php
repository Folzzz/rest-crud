<?php
    //headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');

    //IMPORT THE DATABASE AND CATEGORY MODEL
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    //INSTANTIATE DATABASE
    $database = new Database();
    //connection variable
    $db = $database->connect();

    //INSTANTIATE category
    $category = new Category($db);

    //get raw data
    $data = json_decode(file_get_contents("php://input"));

    //set id to delete
    $category->id = $data->id;

    //delete category
    if($category->delete()) {
        echo json_encode(
            array(
                'message' => 'post deleted'
            )
        );
    } else {
        echo json_encode(
            array(
                'message' => 'post not deleted'
            )
        );
    }
?>