<?php
    //set headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    //import database and category model
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    //instantiate database and connection variable
    $database = new Database();
    $db = $database->connect();

    //instantiate category
    $category = new Category($db);

    //category query
    $result = $category->read();

    //result row count
    $num = $result->rowCount();

    //check if any category
    if($num > 0){
        //initialize category array
        $category_arr = array();
        $category_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            //item for each category
            $category_item = array(
                'id' => $id,
                'name' => $name,
                'created_at' => $created_at
            );

            //push to category_arr
            array_push($category_arr['data'], $category_item);
        }
        //output
        echo json_encode($category_arr);

    } else {
        //no category in result
        echo json_encode(
            array(
                "message" => "no category found"
            )
            );
    }
?>