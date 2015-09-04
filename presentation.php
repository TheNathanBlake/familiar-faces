<?php

function presentation($atts, $data)
{
    /*
    Prevents the randomly generated items from being thrown into the cache.
    Without preventing this, the page will not register new randomized results
    for a long time.
    */
    if(!defined('DONOTCACHEPAGE') ) define( 'DONOTCACHEPAGE', true);

    add_action( 'wp_enqueue_scripts', 'pavlov_presentation_stylesheet');
    global $main_img_path; //main image file path extension
    global $hover_img_path; //hover image file path extension

    $col = $row = $ref = 0;
    $url = $atts['link'];

?>
    <div class="pavlov">
        <div class="pavlov_faces">
<?php
    foreach($data as $face)
    {
        /*
        The main loop
        
        TODO: fix JS issue with duplicate element plugs.
        Possible fix may involve starting id's at a randomized number up to 10 digits.

        Note: width used to be max-width
        */  
?>
            <div class='pavlov_box' style='width: <?php echo 100 / $atts["per_row"] - 2; ?>%'>
            <?php echo "<a href='$url"."?face_id=".$face->id."'>"; ?><img id='main_image_<?php echo $ref; ?>' src='<?php echo $face->mainimage; ?>' /><?php echo '</a>'; ?>

                <p id="name_field_<?php echo $ref;?>" class='block_name_field' ><?php echo $face->membername; ?></p>
                <p id="title_field_<?php echo $ref;?>" class='block_title_field'><?php echo $face->title; ?></p>
            </div>
<?php
        /*
        Runs if the loop has reached the last column allowed in the attributes.
        This will end the div and create a new dropfield to display the data.
        */
        if(++$col == $atts['per_row'])
        {
?>
        <span class="stretch"></span>
        </div>
<?php
            if($face !== end($data))
            {
?>
    <div class="pavlov_faces">
<?php
            }
            $col = 0;
            $row++;
        }
        /*
        Runs if the stream finishes before the row is completed.
        This will write the end of the current table and create the last dropfield.
        */
        else if($face === end($data))
        {
?>
            <span class="stretch"></span>
        </div>
<?php
        }
        $ref++;
    }
?>
    </div>
    <script>
        var data = <?php echo json_encode($data).";";?>
        //track selected item and selected row
        var selected = -1;
        var selectedRow = -1;

        var total_rows = <?php echo $row + 1; ?>;

        //assign hover actions to every member
        for(var i = 0; i < data.length; i++)
        {
            jQuery('#main_image_'+i).hover(hoverOn(i), hoverOff(i));
            jQuery('#main_image_'+i).mouseup(hoverOff(i));
        }

        function hoverOn(i)
        {
            return function()
            {
<?php
                if($atts['hoverface'])
                {
?>
                jQuery('#main_image_'+i).attr('src', data[i]['hoverimage']);
<?php
                }
                if($atts['hovername'])
                {
?>
                jQuery('#name_field_'+i).html(data[i]['dogname']);
                jQuery('#title_field_'+i).html(data[i]['dogbreed']);
<?php
                }
?>
            }
        }

        function hoverOff(i)
        {
            return function()
            {
<?php
                if($atts['hoverface']) {
?>
                jQuery('#main_image_'+i).attr('src', data[i]['mainimage']);
<?php
                }
                if($atts['hovername']) {
?>
                jQuery('#name_field_'+i).html(data[i]['membername']);
                jQuery('#title_field_'+i).html(data[i]['title']);
<?php
                }
?>
            }
        }
    </script>
<?php
}

?>