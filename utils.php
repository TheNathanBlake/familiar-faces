<?php

$path_to_plugin = plugin_dir_url(__FILE__);

$main_img_path = "facelift/main/";
$hover_img_path = "facelift/hover/";

$table_name = 'pavlov_faces';

global $wpdb;
$table_full_name = $wpdb->prefix . $table_name;
$data_table_name = $wpdb->prefix . 'report_data';

?>