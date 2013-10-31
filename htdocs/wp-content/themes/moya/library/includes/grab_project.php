<?php

// initiate wordpress core (this is terrible, i need to learn to do it right);
include "../../../../../wp-load.php";

// grab our constants for some options needed in the function below
include "constants.php";

// 
get_single_project( $_POST['project_id'] );

?>
