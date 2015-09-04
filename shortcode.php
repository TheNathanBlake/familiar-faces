<?php

include_once 'utils.php';
include 'presentation.php';
include 'presentation_full.php';

/*
    Function random_faces_count_handler

    param $atts (attributes)
    max: Number of faces to show (if higher than count, will display count)
    per_row: Number of units to be shown per row.
    order: attribute determining the order in which units are to be displayed.
        By Name:
            name-asc
            name-desc
        By Title:
            title-asc
            title-desc
        None specified: random

    Connects to the pavlov_faces shortcode (lists 4 members by default)
*/
function random_faces_count_handler($atts)
{
    $a = shortcode_atts(array(
        'max' => 4,
        'per_row' => 4,
        'order' => 'random',
        'hoverface'=> '1',
        'hovername' => '',
        'presentation' => '',
        'link' => '#'
        ), $atts);

    ob_start();
    presentation($a, get_data($a));
    return ob_get_clean();
}

/*
    Function listed_faces_handler

    param $atts (attributes)
    max: Number of faces to show at one time (defaults to total)
    per_row: Number of units to be shown per row.
    order: attribute determining the order in which units are to be displayed.
        By Name:
            name-asc
            name-desc
        By Title:
            title-asc
            title-desc
        None specified: random

    Connects to the pavlov_faces_full shortcode (lists all members by default)
*/
function listed_faces_handler($atts)
{
    global $wpdb;
    global $table_full_name;
    $max = $wpdb->get_var("SELECT COUNT(*) FROM $table_full_name");

    $a = shortcode_atts(array(
        'max' => $max,
        'order' => 'name_asc',
        'hoverface' => '1',
        'hovername' => '',
        'presentation' => '1',
        ), $atts);

    ob_start();
    presentation_full_list($a, get_data($a));
    return ob_get_clean();
}

/*
    Get Data Function
    param $atts: tags given in the box

    Calls the SQL table and returns the array provided.
*/
function get_data($atts)
{
    global $wpdb;
    global $table_full_name;
    //code for list.  Here we will eventually check for the type (somehow) then save a lot of size
    //$offset = $atts['offset'];

    if(!is_numeric($atts['max']))
        $limit = 4;
    else $limit = $atts['max'];

    switch($atts['order'])
    {
        case 'name-asc':
            $order = 'membername';
            break;
        case 'name-desc':
            $order = 'membername DESC';
            break;
        case 'title-asc':
            $order = 'title';
            break;
        case 'title-desc':
            $order = 'title DESC';
            break;
        default:
            $order = 'RAND()';
            break;
    }
    //test query

    $faces = $wpdb->get_results("SELECT * FROM $table_full_name ORDER BY $order LIMIT $limit");
    return $faces;
}

/*Turns shortcode into element.*/
function make_element()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'pavlov_faces';
    $max = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");

    $pages = get_pages();
    $list = array('no link' => '');
    foreach($pages as $page)
    {
        $list[$page->post_title] = home_url().get_page_link($page->ID);
    }

    vc_map( array(
       "name" => __("Four Familiar Faces"),
       "base" => "pavlov_faces",
       "category" => __('Content'),
       "params" => array(
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Max"),
             "param_name" => "max",
             "value" => __($max),
             "description" => __("Maximum faces to show (blank = no maximum)", 'my-text-domain')
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Row Size"),
             "param_name" => "per_row",
             "value" => array(1, 2, 3, 4, 5, 6),
             "description" => __("Faces to show per row", 'my-text-domain')
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Display Order"),
             "param_name" => "order",
             "value" => array(
                'Random' => "random",
                'Name (Ascending)' => "name-asc",
                'Name (Descending)' => "name-desc",
                'Title (Ascending)' => "title-asc",
                'Title (Descending)' => "title-desc"
                ),
             "description" => __("Listing order for faces", 'my-text-domain')
          ),
          array(
             "type" => "checkbox",
             "holder" => "span",
             "class" => "",
             "heading" => __("Hover Face"),
             "param_name" => "hoverface",
             "value" => array('' => 'true'), //wants an associative array for checkboxes
             "description" => __("Change face on hover?", 'my-text-domain')
          ),
          array(
            "type" => "checkbox",
            "holder" => "span",
            "class" => "",
            "heading" => __("Hover Name"),
            "param_name" => "hovername",
            "value" =>array('' => 'true'),
            "description" => __("Change name on hover?", 'my-text-domain')
            ),
          array(
            "type" => "dropdown",
            "holder" => "div",
            "class" => "",
            "heading" => __("URL link:"),
            "param_name" => "link",
            "value" => $list,
            "description" => __("URL of webpage containing full member list to link", 'my-text-domain')
            ),
       )
    ) );
}

/*Turns full list shortcode into element*/
function make_full_element()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'pavlov_faces';
    $max = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");

    vc_map( array(
       "name" => __("Four Familiar Faces (Full List)"),
       "base" => "pavlov_faces_full",
       "category" => __('Content'),
       "params" => array(
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Max"),
             "param_name" => "max",
             "value" => __($max, 'my-text-domain'),
             "description" => __("Maximum faces to show (blank = no maximum)", 'my-text-domain')
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Display Order"),
             "param_name" => "order",
             "value" => array(
                'Random' => "random",
                'Name (Ascending)' => "name-asc",
                'Name (Descending)' => "name-desc",
                'Title (Ascending)' => "title-asc",
                'Title (Descending)' => "title-desc"
                ),
             "description" => __("Listing order for faces", 'my-text-domain')
          ),
          array(
             "type" => "checkbox",
             "holder" => "span",
             "class" => "",
             "heading" => __("Hover Face"),
             "param_name" => "hoverface",
             "value" => array('Name' => 'true'), //wants an associative array for checkboxes
             "description" => __("Change face on hover?", 'my-text-domain')
          ),
          array(
            "type" => "checkbox",
            "holder" => "span",
            "class" => "",
            "heading" => __("Hover Name"),
            "param_name" => "hovername",
            "value" =>array('Face' => 'true'),
            "description" => __("Change name on hover?")
            ),
       )
    ) );
}

?>