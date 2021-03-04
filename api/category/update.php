<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');

    //IMPORT THE DATABASE AND CATEGORY MODEL
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    //INSTANTIATE DATABASE
    $database = new Database();
    //CONNECTION VARIABLE
    $db = $database->connect();

    //INSTANTIATE category
    $category = new Category($db);

    //get the raw data
    $data = json_decode(file_get_contents("php://input"));

    //set id to update
    $category->id = $data->id;
    //set other params to update
    $category->name = $data->name;

    //update category
    if($category->update()) {
        echo json_encode(
            array(
                'message' => 'post updated'
            )
        );
    } else {
        echo json_encode(
            array(
                'message' => 'post not updated'
            )
        );
    }

?>