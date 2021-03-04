<?php
    //HEADERS
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    // IMPORT THE DATABASE AND MODELS(POST MODEL)
    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // INSTANTIATE DB OBJECT AND CONNECT
    $database = new Database();
    //CONNECTION VARIABLE
    $db = $database->connect();

    //INSTANTIATE BLOG POST OBJECT
    $post = new Post($db);

    //BLOG POST QUERY
    $result = $post->read();

    //GET ROW COUNT
    $num = $result->rowCount();

    //CHECK IF ANY POST
    if ($num > 0) {
        //INITIALIZE POST ARRAY
        $posts_arr = array();
        //WE WANT IT TO HAVE A DATA VALUE AND NOT JSON
        $posts_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            //POST ITEM FOR EACH POST
            $post_item = array(
                'id' => $id,
                'title' => $title,
                'body' => html_entity_decode($body),
                'author' => $author,
                'category_id' => $category_id,
                'category_name' => $category_name
            );

            //PUSH TO "DATA"
            array_push($posts_arr['data'], $post_item);
        }

        //TURN TO JSON AND OUTPUT
        echo json_encode($posts_arr);

    } else {
        // NO POST
        echo json_encode(
            array('message' => 'No Posts Found')
        );
    }

?>