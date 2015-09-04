<?php

function presentation_full_list($atts, $data)
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
    global $wpdb;
    $col = $row = $ref = 0;

?>
    <ul class="familiar_faces">
<?php

    $detail_list = array();

    $data_table = $wpdb->prefix . 'report_data';
    foreach($data as $face)
    {
        /*
        The main loop
        
        TODO: fix JS issue with duplicate element plugs.
        Possible fix may involve starting id's at a randomized number up to 10 digits.

        Note: width used to be max-width
        */  
        $details = $wpdb->get_results($wpdb->prepare("SELECT information, hierarchy, id, ranking FROM $data_table WHERE id=%d;", $face->id));

        /*
        Invoke the illuminati


        Actually just calling the details to pull them into JS
        for the reports in each team members' description
        */
        $id_list = array();
        foreach($details as $key => $item)
        {
            $id_list[] = array(
                'information' => $item->information,
                'ranking' => $item->ranking
                );
        }
        $detail_list[$face->id] = $id_list;
?>
        <li class='ff-facebox' id='pv_box_<?php echo $ref; ?>'>
            <div class='ff-portrait'>
                <img alt='' id='main_image_<?php echo $ref;?>' onclick='expand(<?php echo $ref;?>)' src='<?php echo $face->mainimage; ?>' />
                <p id="name_field_<?php echo $ref;?>" class='block_name_field' ><?php echo $face->membername; ?></p>
                <p id="title_field_<?php echo $ref;?>" class='block_title_field'><?php echo $face->title; ?></p>
            </div>
        </li>
<?php
        $ref++;
    }
?>
    </ul>
    <script>
        var data = <?php echo json_encode($data).";";?>

        //detail list
        var details = <?php echo json_encode($detail_list).";";?>
        //track selected item and selected row
        var selected = -1;
        var selectedRow = -1;
        var total = <?php echo $ref; ?>;
        var total_rows = <?php echo $row + 1; ?>;
        var timeout = 700;  //timeout between panel drop/raise
        var face_id<?php

                $face_id = get_query_var('face_id', null);
                if($face_id) echo ' = '.$face_id;
?>;

        //$('html,body').animate({scrollTop: jQuery('#main_image_'+face_id).offset().top}, 700);

        //assign hover actions to every member
        for(var i = 0; i < data.length; i++)
        {
            jQuery('#main_image_'+i).hover(hoverOn(i), hoverOff(i));
            if(data[i]['id'] == face_id)
                jQuery('#main_image_'+i).click();
        }

//        jQuery('#main_image_'+face_id).click();

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

        function expand(ref)
        {
            /*** NEW NATHAN ***/
            //data[ref]['lefttopic'] to plug lefttopic
           
            jQuery('#pv_box_'+selected).toggleClass("pv-expand");
            jQuery('#viewport').remove(); //necessary if other viewports are open

            if(ref !== selected)
            {
                var polaroid1 = "<img class='polaroid1' src='"+data[ref]['polaroid1']+"' alt='' />";
                var polaroid2 = "<img class='polaroid2' src='"+data[ref]['polaroid2']+"' alt='' />";
                var stimulant = "<img class='stimulant' src='"+data[ref]['stimulant']+"' alt='stimulant' />";
                var signature = "<img class='signature' src='"+data[ref]['signature']+"' alt='signature' />";
                var phylumcircle = <?php echo json_encode(plugin_dir_url(__FILE__)."img/phylum-circle.png");?>;

                var polaroid_loc = <?php echo json_encode(plugin_dir_url(__FILE__)."images/polaroid-200.png");?>;

                var viewport = "<div id='viewport'>"
                    + "<div class='polaroids'>"
                        + "<div class='frame-top'>"
                            + polaroid1
                            + "<img class='frame1' src='"+polaroid_loc+"' alt='' />"
                        + "</div>"
                        + "<div class='frame-bottom'>"
                            + polaroid2
                            + "<img class='frame2' src='"+polaroid_loc+"' alt='' />"
                        + "</div>"
                    + "</div>"
            
                    + "<div class='identification'>"
                        + "<div class='identity'>"
                        + "<table border='0' cellpadding='0' cellspacing='0' align='left' style='width: 100%;'>"
                            + "<tr><th>"
                            + "<div class='report-canvas'>"
                            + "<div class='alignheader'><h1>Lab Report</h1></div><div class='alignclear'></div>"
                            + "</div>"
                            + "</th></tr>"
                            + "<tr><td>"
                            + "<table border='0' cellpadding='0' cellspacing='0' align='left' style='width: 48%;'>"
                                + "<tr><td><span class='name'>Name</span></td> <td id='signature'>"+signature+"</td></tr>"
                                + "<tr><td></td> <td><span class='description'>IN THE DEVELOPMENT OF THESE TRAITS,<br>THE HOME SHARE RESPONSIBILITY WITH THE LAB</span></td></tr>"
                            + "</table>"
                            + "<table border='0' cellpadding='0' cellspacing='0' align='left' style='width: 50%;'>"
                                + "<tr><td> <table id='traits' border='0' cellpadding='0' cellspacing='0'>"
                                    + "<tr><td class='trait-data'><span class='trait'>KINGDOM :</span> <span id='kingdom'></span></td></tr>"
                                    + "<tr><td class='trait-data'>"
                                        + "<span class='trait'>PHYLUM :</span>"
                                        + "<span id='creativus' class='phylum-select'> CREATIVUS //</span>"
                                        + "<span id='accountus' class='phylum-select'> ACCOUNTUS //</span>"
                                        + "<span id='medialia' class='phylum-select'> MEDIALIA //</span>"
                                        + "<span id='programmia' class='phylum-select'> PROGRAMMIA</span>"
                                    + "</td></tr>"
                                    + "<tr><td class='trait-data'><span class='trait'>SPECIES :</span> <span id='species'></span></td></tr>"
                                + "</table></td></tr>"
                                + "<tr><td class='trait-space'> <table border='0' cellpadding='0' cellspacing='0'>"
                                    + "<tr><td class='trait-space'><hr class='trait-spacer'></td></tr>"
                                + "</table></td></tr>"
                            + "</table>"
                            + "</td></tr>"
                        + '</table>'
                        + "</div>"
                
                        + "<hr class='spacer'>"
                
                        + "<div class='inquiry'>"
                        + "<table class='queries' border='0' cellpadding='0' cellspacing='0' align='left' style='width: 63%;'>"
                            + "<tr><td><span class='query'>I'M STIMULATED BY </span> <span id='stimulus' class='answers'></span></td></tr>"
                            + "<tr><td><span class='query'>WHERE? </span> <span id='location' class='answers'></span></td></tr>"
                            + "<tr><td><span class='query'>I'M AFRAID OF </span> <span id='fear' class='answers'></span></td></tr>"
                            + "<tr><td><span class='query'>THESE THREE WORDS </span> <span id='threewords' class='answers'></span></td></tr>"
                            + "<tr><td><span class='query'>I ONCE </span> <span id='ionce' class='answers'></span></td></tr>"
                            + "<tr><td><span class='query'>I COULDN'T LIVE WITHOUT </span> <span id='couldntlive' class='answers'></span></td></tr>"
                            + "<tr><td><span class='query'>TURN ON THE </span> <span id='turnonthe' class='answers'></span></td></tr>"
                            + "<tr><td><span class='query'>MY BEAKER IS FULL OF </span> <span id='beaker' class='answers'></span></td></tr>"
                        + "</table>"
                        + "<table border='0' cellpadding='0' cellspacing='0' align='left' style='width: 35%;'>"
                            + "<tr><td id='rorschach'><span class='rorschach'>RORSCHACH TEST</span></td></tr>"
                            + "<tr><td id='stimulant'>"+stimulant+"</td></tr>"
                            + "<tr><td id='response'></td></tr>"
                        + "</table>"
                        + "</div>"
                    + "</div>"
                    + "<div class='viewport-clear'></div>"
                + "</div>";

                jQuery('#pv_box_'+ref).toggleClass("pv-expand");
                jQuery('#pv_box_'+ref).append(viewport);

                //begin animated scroll
                setTimeout(
                    function(){
                        jQuery('html,body').animate({scrollTop: jQuery('#viewport').offset().top}, 700);
                    }, 700);

                var id = data[ref]['id'];

                jQuery("#kingdom").html(data[ref]['kingdom']);
                jQuery("#species").html(data[ref]['species']);
                
                jQuery("#stimulus").html(data[ref]['stimulus']);
                jQuery("#location").html(data[ref]['location']);
                jQuery("#fear").html(data[ref]['fear']);
                jQuery("#threewords").html(data[ref]['threewords']);
                jQuery("#ionce").html(data[ref]['ionce']);
                jQuery("#couldntlive").html(data[ref]['couldntlive']);
                jQuery("#turnonthe").html(data[ref]['turnonthe']);
                jQuery("#beaker").html(data[ref]['beaker']);
                
                var phylumid = "#"+data[ref]['phylum'];

				jQuery(phylumid).prepend("<img class='phylum-circle' src='"+phylumcircle+"' />");
                
                //jQuery("#creativus").html(data[ref]['phylum']);
                
                jQuery("#response").html("<span class='rorschach-answer'>"+data[ref]['response']+"</span>");
                
//                var dasher = <?php //echo json_encode(plugin_dir_url(__FILE__)."img/dash.png");?>;
//                
//                jQuery("table.queries td").css({
//                    "backgroundImage" : "url('"+dasher+"')"
//                });
                
                selected = ref;
            }
            else
                selected = -1;
        }

    </script>
    <?php
}
?>