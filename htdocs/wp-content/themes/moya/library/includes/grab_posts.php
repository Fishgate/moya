<?php

// initiate wordpress core (this is terrible, i need to learn to do it right);
include "../../../../../wp-load.php";

// grab our constants for some options needed in the function below
include "constants.php";

if($_POST['offset'] >= get_total_posts_num('custom_projects', null)){
    echo "error1"; //no more posts to load
}else{
    echo get_work('custom_projects', POSTS_PER_PAGE, null, $_POST['offset']);
}


?>
