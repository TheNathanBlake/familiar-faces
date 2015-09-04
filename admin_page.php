<?php

include_once 'utils.php';
include_once 'settings.php';

function add_pavlov_widget()
{
    wp_add_dashboard_widget('faces_of_pavlov', 'Faces of PAVLOV', 'admin_page');
}

function pavlov_faces_menu()
{
    add_options_page('Faces of PAVLOV', 'Faces of PAVLOV', 'administrator', __FILE__, 'admin_page');
}

/**
* Function delete_member (not very complicated)
* @param selection: selected member to delete
* Deletes a member.
*/
function delete_member($selection)
{
    //check that the member exists
    if($selection < 0)
    {
        return;
    }
    global $wpdb;
    global $table_full_name;

    $wpdb->delete($table_full_name, array('id' => $selection), array('%d'));
}

/*
Function edit_member (too many comments)
all the parameters
Adds members
(Keep id null)
*/
function add_new_member($array)
{
    global $wpdb;
    global $table_full_name;

    $wpdb->insert(
        $table_full_name,
        $array
        );
}

/*
Function edit_member (not enough to comment on)
all the parameters
Edits members
*/
function edit_member($array, $id)
{
    global $wpdb;
    global $table_full_name;

    $types = array();

    foreach($array as $value)
    {
        $type = gettype($value);
        if($type == 'integer')
        {
            $types[] = '%d';
        }
        else if($type == 'double')
        {
            $types[] = '%f';
        }
        else
        {
            $types[] = '%s';
        }
    }

    $wpdb->update(
        $table_full_name,
        $array,
        array('id' => $id),
        $types,
        array('%d')
    );
}

/*
Function handle_submit (Feel free to sift through the awful.)
No parameters.
Description:
    Handles both editing and adding of new team members.
    All the values to enter are read through $_POST
    Values on edit aren't checked YET, except for images.
*/

function handle_submit()
{
//    function safe($value){ 
//       return mysql_real_escape_string($value); 
//    }
    
//    function safe($value){ 
//       return stripslashes_deep($value); 
//    }

    //Note: This is done by the ternary statement underneath.
    if(!array_key_exists('pv_phylum', $_POST))
    {
        $_POST['pv_phylum'] = 'creativus';
    }
    
    $id = $_POST['member_id'];
    $submit = array(
    //'id' => $_POST['member_id'];
    'membername' => stripslashes_deep($_POST['pv_name']),
    'title' => stripslashes_deep($_POST['pv_title']),
    'dogname' => stripslashes_deep($_POST['dog_name']),
    'dogbreed' => stripslashes_deep($_POST['dog_breed']),
    'mainimage' => $_POST["mainImg"],
    'hoverimage' => $_POST["hoverImg"],
    'polaroid1' => $_POST["polaroid1"],
    'polaroid2' => $_POST["polaroid2"],
    
        'signature' => $_POST['pv_signature'],
        'kingdom' => stripslashes_deep($_POST['pv_kingdom']),
        'species' => stripslashes_deep($_POST['pv_species']),
        'phylum' => (array_key_exists('pv_phylum', $_POST) ? 
        $_POST['pv_phylum'] : 'creativus'),
        'stimulant' => $_POST['pv_stimulant'],
        'response' => stripslashes_deep($_POST['pv_response']),
        
    'lefttopic' => $_POST['pv_leftcat'],
    'righttopic' => $_POST['pv_rightcat'],
        'stimulus' => stripslashes_deep($_POST['pv_stimulus']),
        'location' => stripslashes_deep($_POST['pv_location']),
        'fear' => stripslashes_deep($_POST['pv_fear']),
        'threewords' => stripslashes_deep($_POST['pv_threewords']),
        'ionce' => stripslashes_deep($_POST['pv_ionce']),
        'couldntlive' => stripslashes_deep($_POST['pv_couldntlive']),
        'turnonthe' => stripslashes_deep($_POST['pv_turnonthe']),
        'beaker' => stripslashes_deep($_POST['pv_beaker'])
    );

    if(empty($_POST['member_id']))
    {
        if(!($_POST['mainImg'] and $_POST['hoverImg']))
        {
            /*Go forth and*/ die( "New selections must include a main image and hover image.");
        }
        else
        {
            add_new_member($submit);
            echo "<h3> Update successful. New results will appear on refresh.</h3>";
        }
    }
    else
    {
        if($_POST['mainImg'] == NULL)
            unset($submit['mainImg']);
        if($_POST['hoverImg'] == NULL)
            unset($submit['hoverImg']);
        if($_POST['polaroid1'] == NULL)
            unset($submit['polaroid1']);
        if($_POST['polaroid2'] == NULL)
            unset($submit['polaroid2']);
        
        if($_POST['pv_signature'] == NULL)
            unset($submit['signature']);
        if($_POST['pv_stimulant'] == NULL)
            unset($submit['stimulant']);
        
        $submit['id'] = $id;
        edit_member($submit, $id);
        echo "<h3> Edit successful. New results will appear on refresh.</h3>";
    }

    /* Handle the details from the table earlier */
    if(array_key_exists('deets', $_POST))
    {
        $deets = $_POST['deets'];
        $ranking = $_POST['ranking'];

        global $wpdb;
        global $data_table_name;

        //delete the previous entries and rewrite
        $wpdb->delete($data_table_name, array('id' => $id), array('%d'));

        /*
        It actually comes out faster to delete the entries from the table and
        re-enter them all, than to search through the array of both entries
        to see what's been altered.  Our only shot would be if we can find an 
        efficient way to pass an array to PHP from JavaScript.  So far hidden
        forms have worked well enough for normal values, but they often go
        unnoticed when people edit code.
        */
        $count = 0;
        foreach($deets as $index => $deet)
        {
            $test = $ranking[$index];
            echo "<p>deet $index : $test</p>";
            if($deet !== "")
            {
                $submit = array(
                    'id' => $id,
                    'information' => $deet,
                    'hierarchy' => $count,
                    'side' => 0,
                    'ranking' => $ranking[$index]
                    );

                $wpdb->insert(
                    $data_table_name,
                    $submit
                    );
            }
            $count++;
        }
    }
}





/* Somehow I broke things when I removed this function. */
function table_name()
{
    return "pavlov_faces";
}

?>