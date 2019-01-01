<?php 
global $wpdb;
$results = $wpdb->get_results("SELECT * FROM student");
foreach($results as $res)
      echo $res->id;
      echo $res->name;
    }
?>
