<?php

/*
Function admin_page (The presentation view of the admin world)

No parameters

Description:
    Displays faces from the database and associates them with their database info.
*/
function admin_page()
{
    if(!defined('DONOTCACHEPAGE'))
        define('DONOTCACHEPAGE', true);
    ?>
    <div class="wrap">
        <h4>Faces of PAVLOV</h4>

        <div id='pv_selectable'>
        <?php

        global $wpdb;
        global $table_full_name;
        global $path_to_plugin;

        $data = $wpdb->get_results( "
            SELECT *
            FROM $table_full_name" );
        $count = 0;

        foreach($data as $face)
        {
            ?>
                <img src='<?php echo $face->mainimage; ?>' alt='<?php echo $face->membername; ?>' onclick='selected(<?php echo $count; ?>)' width='200px'/>
            <?php
            $count++;
        }
        ?>
            <img src='<?php echo $path_to_plugin."images/new.png" ;?>' onclick='selected(-1)' width='200px' />
        <?php

        //Add an image or item here to represent a new member addition (may need to spend some time in illustrator)
        ?>
    </div>
    <hr id='pv_separator' />
    <div id="pv_editable">
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" id="member_id" name="member_id">
            <div style='width: 600px; margin: 15px auto;'>
                <table style='display: inline-table;'>
                    <tr><td><img id='main_image' src='#' width='200'/></td></tr>
                    <tr><td><button type='button' onclick="media('#mainImg', '#main_image')"/>Main Image</button><input id="mainImg" name='mainImg' type="hidden"></td></tr>
                </table>
                <table style='display: inline-table;'>
                    <tr><td><img id='hover_image' src='#' width='200'/></td></tr>
                    <tr><td><button type='button' onclick="media('#hoverImg', '#hover_image')"/>Hover Image</button><input id="hoverImg" name='hoverImg' type="hidden"></td></tr>
                </table>
                <table style='display: inline-table;'>
                    <tr align='center'>
                        <td><label for="pv_name" >Name: </label></td>
                        <td><input type="text" size='25' name='pv_name' id='pv_name'></td>
                    </tr>
                    <tr align='center'>
                        <td><label for="pv_title">Title: </label></td>
                        <td><input type="text" size='25' name='pv_title' id='pv_title'></td>
                    </tr>
                </table>
                <table style="display: inline-table;">
                    <tr align='center'>
                        <td><label for="dog_name" >Hover Name: </label></td>
                        <td><input type="text" size='25' name='dog_name' id='dog_name'></td>
                    </tr>
                    <tr align='center'>
                        <td><label for="dog_breed">Hover Title: </label></td>
                        <td><input type="text" size='25' name='dog_breed' id='dog_breed'></td>
                    </tr>
                    <tr>
                        <td colspan='2'><p>Activate hover with hovername='true' in shortcode.</p></td>
                    </tr>
                </table>
            </div>
            <hr />
<!--            <div id='pv_polaroids'>
                <div class="polaroid">
                    <img src='#' id='pv_pol1' />
                    <button type='button' onclick="media('#polaroid1', '#pv_pol1')">Studio Image 1</button><input id="polaroid1" name='polaroid1' type="hidden"/>
                </div>
                <div class="polaroid">
                    <img src='#' id='pv_pol2' />
                    <button type='button' onclick="media('#polaroid2', '#pv_pol2')">Studio Image 2</button><input id="polaroid2" name='polaroid2' type="hidden"/>
                </div>
            </div>-->

            <!-- NEW NATHAN -->
            <div id='pv_polaroids'>
                <div class="polaroid">
                    <img src='#' id='pv_pol1' />
                    <button type='button' onclick="media('#polaroid1', '#pv_pol1')">Polaroid Image 1</button>
                    <input id="polaroid1" name='polaroid1' type="hidden"/>
                </div>
                <div class="polaroid">
                    <img src='#' id='pv_pol2' />
                    <button type='button' onclick="media('#polaroid2', '#pv_pol2')">Polaroid Image 2</button>
                    <input id="polaroid2" name='polaroid2' type="hidden"/>
                </div>
            </div>

            <!-- Begin Identification information -->
            <div class='identification' style='display: inline-block;'>
                <img src='#' id='signature' width='300'/>
                <button type='button' onclick="media('#pv_signature', '#signature')">Signature: </button>
                <input name='pv_signature' id='pv_signature' type='hidden'/>

                <label for='pv_kingdom'>Kingdom: </label>
                <input type='text' length='30' name='pv_kingdom' id='pv_kingdom'/>
                
                <label for='pv_species'>Species: </label>
                <input type='text' length='30' name='pv_species' id='pv_species'/>
            </div>
            
            
            <!-- Phylum information -->
            <div class='phylum-selection' style='display: inline-block;'>
                <label for='pv_phylum'>Phylum: </label>
                <span>
                    <input type='radio' name='pv_phylum' id='pv_phylum1' value='creativus' />Creativus
                    <input type='radio' name='pv_phylum' id='pv_phylum2' value='accountus' />Accountus
                    <input type='radio' name='pv_phylum' id='pv_phylum3' value='medialia' />Medialia
                    <input type='radio' name='pv_phylum' id='pv_phylum4' value='programmia' />Programmia
                </span>
            </div>
            
            
            <!-- Rorschach information -->
            <div class='rorschach' style='display: inline-block;'>
                <img src='#' id='stimulant' width='300'/>
                <button type='button' onclick="media('#pv_stimulant', '#stimulant')">Stimulant</button>
                <input name='pv_stimulant' id='pv_stimulant' type='hidden'/>

                <label for='pv_response'>Response: </label>
                <input type='text' length='30' name='pv_response' id='pv_response'/>
            </div>
            
            
            <div style='width: 600px; margin: 15px auto;'>
                <table style='display: inline-table;'>
                    <tr align='center'>
                        <td><label for="pv_stimulus" >I'm stimulated by: </label></td>
                        <td><input type="text" size='25' name='pv_stimulus' id='pv_stimulus'></td>
                    </tr>
                    <tr align='center'>
                        <td><label for="pv_location" >Where: </label></td>
                        <td><input type="text" size='25' name='pv_location' id='pv_location'></td>
                    </tr>
                    <tr align='center'>
                        <td><label for="pv_fear" >I'm afraid of: </label></td>
                        <td><input type="text" size='25' name='pv_fear' id='pv_fear'></td>
                    </tr>
                    <tr align='center'>
                        <td><label for="pv_threewords" >Those three words: </label></td>
                        <td><input type="text" size='25' name='pv_threewords' id='pv_threewords'></td>
                    </tr>
                    <tr align='center'>
                        <td><label for="pv_ionce" >I once: </label></td>
                        <td><input type="text" size='25' name='pv_ionce' id='pv_ionce'></td>
                    </tr>
                    <tr align='center'>
                        <td><label for="pv_couldntlive" >I couldn't live without: </label></td>
                        <td><input type="text" size='25' name='pv_couldntlive' id='pv_couldntlive'></td>
                    </tr>
                    <tr align='center'>
                        <td><label for="pv_turnonthe" >Turn on the: </label></td>
                        <td><input type="text" size='25' name='pv_turnonthe' id='pv_turnonthe'></td>
                    </tr>
                    <tr align='center'>
                        <td><label for="pv_beaker" >My beaker is full of: </label></td>
                        <td><input type="text" size='25' name='pv_beaker' id='pv_beaker'></td>
                    </tr>
                </table>
            </div>

            <div style ='width: 400px; margin: 15px auto;'>
                <input type="submit" name='submit_button' id='submit_button'>
                <input type="submit" name='delete_button' id='delete_button' value = 'Delete'>
            </div>
        </form> 
    </div>
    <?php
    if(isset($_POST["submit_button"]))
    {
        handle_submit();
    }

    if(isset($_POST['delete_button']))
    {
        global $table_full_name;
        $wpdb->delete($table_full_name, array('id' => $_POST['member_id']), array("%d"));
    }
    ?>
    <script>

        var file_frame;

        function media( id, img ){

            //Necessary;  Prevents the page from reloading.
            //event.preventDefault();

            // Create the media frame.
            file_frame = wp.media.frames.file_frame = wp.media({
                title: jQuery( this ).data( 'uploader_title' ),
                button: {
                    text: jQuery( this ).data( 'uploader_button_text' ),
                },
                multiple: false  // Set to true to allow multiple files to be selected
            });

            // When an image is selected, run a callback.
            file_frame.on( 'select', function() {
                // We set multiple to false so only get one image from the uploader
                attachment = file_frame.state().get('selection').first().toJSON();
                //send information to the closest input to the clicked button
                jQuery(id).val(attachment.url);
                jQuery(img).attr('src', attachment.url);
                // Do something with attachment.id and/or attachment.url here
                file_frame.close();
            });

            // Finally, open the modal
            file_frame.open();
        }

        /*
        PHP mixed into JS to grab necessary info from the db
        May soon switch to AJAX calls to prevent people from
        determining the layout of the tables.
        */
        var selectedImage = false;
        <?php
        $upload_dir = wp_upload_dir();

        echo("var data = ".json_encode($data).";");
        echo("var path = ".json_encode($upload_dir['baseurl'].'/facelift/'));
        ?>
        
        var odd = true;
        var data_count = 0;

        /*
        We may want to implement row adding functionality to other portions.
        Increments count, expects fresh increment before function run
        */
        jQuery("#add_row").click(function(event){
            event.preventDefault();

            var row = '<tr><td>' 
            + '<input type="text" name="deets[]" id = "info_data_'+(data_count)+'"/>'
            + '</td><td>'
            + '<input type="range" min="0" max="4" name="ranking[]" id = "ranking_'+(data_count++)+'"/>'
            + '</td><td>'
            + '<input type="text" name="deets[]" id="info_data_'+(data_count)+'"/>'
            + '</td><td>'
            + '<input type="range" min="0" max="4" name="ranking[]" id="ranking_'+(data_count++)+'"/>'
            + '</td></tr>';
            jQuery("#report_data").append(row);
        });

        var block_size = "700px";

        /**
         *
         * Function selected (Pretty neatly fedangled)
         * @param id: an integer passed from the HMTL sheet, tracks the block clicked.
         * Purpose: Calls helper functions to manipulate the data banner below the list of faces
         */
        function selected(id)
        {
            if(selectedImage === false)
            {
                load_things(id);
                setTimeout(function(){
                    //document.getElementById("pv_editable").scrollIntoView(true);
                }, 700);
            }
            else if(id === selectedImage)
            {
                jQuery("#pv_editable").animate({height:'0px'});
                jQuery("#report_data").empty();
                selectedImage = false;
            }
            else
            {
                jQuery("#pv_editable").animate({height:'0px'});
                jQuery("#report_data").empty();
                setTimeout(function(){load_things(id);}, 700);

                setTimeout(function(){
                    //document.getElementById("pv_editable").scrollIntoView(true);
                }, 700);
            }
        }

        /*
        Function load_things (Maybe there's a more efficient way to do this one.)
        @param id: an integer passed from selected, passed from the HTML sheet.  Tracks
            the block clicked.
        Purpose: Helper function to selected; changes values according to the id given
        */
        function load_things(id)
        {
            jQuery('html,body').animate({scrollTop: jQuery('#pv_separator').offset().top}, 700);
            jQuery('#pv_editable').animate({height: block_size});
            jQuery('#pv_editable').css({'overflow' : 'scroll'});


            /* Note to Anthony
             * This class should help clean up the ugly mess that was previously
             * present in the loading section.  Arrays contain [id_name, database_name]
             */
            var data_format = {
                pictures : [['#main_image', 'mainimage'],
                        ['#hover_image', 'hoverimage'],
                        ['#pv_pol1', 'polaroid1'],
                        ['#pv_pol2', 'polaroid2'],
                        ['#signature', 'signature'],
                        ['#stimulant', 'stimulant']
                        ],
                texts : [['#member_id', 'id'],
                        ['#mainImg', 'mainimage'],
                        ['#hoverImg', 'hoverimage'],
                        ['#polaroid1', 'polaroid1'],
                        ['#polaroid2', 'polaroid2'],
                        ['#pv_name', 'membername'],
                        ['#pv_title', 'title'],
                        ['#dog_name', 'dogname'],
                        ['#dog_breed', 'dogbreed'],
                        ['#pv_signature', 'signature'],
                        ['#pv_leftcat', 'lefttopic'],
                        ['#pv_rightcat', 'righttopic'],
                        ['#pv_kingdom', 'kingdom'],
                        ['#pv_species', 'species'],
                        ['#pv_response', 'response'],
                        ['#pv_stimulus', 'stimulus'],
                        ['#pv_location', 'location'],
                        ['#pv_fear', 'fear'],
                        ['#pv_threewords', 'threewords'],
                        ['#pv_ionce', 'ionce'],
                        ['#pv_couldntlive', 'couldntlive'],
                        ['#pv_turnonthe', 'turnonthe'],
                        ['#pv_beaker', 'beaker']
                        ],

                erase : function() {
                    console.log('Erasing');
                    for(var item in this.pictures)
                    {
                        jQuery(this.pictures[item][0]).attr('src', "");
                    }
                    for(var item in this.texts)
                    {
                        jQuery(this.texts[item][0]).val("");
                    }
                },

                //Note: advanced for-loops are pretty primitive in JS
                fill : function(data) {
                    console.log('Filling with '+ data['id']);
                    console.log('The pictures data: ' + this.pictures);
                    for(var item in this.pictures)
                    {
                        console.log("Item array: " + this.pictures[item][1]);
                        jQuery(this.pictures[item][0]).attr('src', data[this.pictures[item][1]]);
                    }
                    console.log('The text array: '+ this.texts);
                    for(var item in this.texts)
                    {
                        console.log("texts item array: " + this.texts[item][0]);
                        jQuery(this.texts[item][0]).val(data[this.texts[item][1]]);
                    }
                }
            }

            if(id > -1)
            {
                //Call the information class
                data_format.fill(data[id]);

                var send = {
                    'action' : 'test_the_waters',
                    'i_love_you' : 'coffee',
                    'this_much' : data[id]['id']
                };

                /*
                  AJAX retrieval of information.
                  Saves time during initial load while sacrificing
                  lazy load time.  This helps when there's lots of
                  data in the database.

                  Never trust ajaxurl global.
                 */
                jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", send, function(response){
                    var info = jQuery.parseJSON(response);
                    if(info != null)
                    {
                        for(var i = 0, k = 0; i < info.length; k++)
                        {
                            console.log(info[i].information + ", " + info[i].ranking);
                            if(k < info[i].hierarchy)
                            {
                                load_row("");
                            }
                            else
                            {
                                load_row(info[i].information, info[i].ranking);
                                i++;
                            }
                        }
                    }
                    if(!odd)//preserve td equality
                        load_row("");
                });

            }
            else
            {
                data_format.erase();
            }
            selectedImage = id;
        }

        //Expects a fresh increment on count before function run
        //If not odd, the increment will be strange.  We may need to fix this.
        function load_row(info, rank)
        {
            if(rank == null) rank = 2;

            if(odd)
            {
                jQuery("#report_data").append('<tr><td>'
                    + '<input type="text" name="deets[]" id="info_data_'+data_count+'" value="'+info+'">'
                    + '</td><td>'
                    + '<input type="range" min="0" max="4" name="ranking[]" id="ranking_'+data_count+'" value="'+rank+'">'
                    + '</td><td>'
                    + '<input type="text" name="deets[]" id="info_data_'+(++data_count)+'">'
                    + '</td><td>'
                    + '<input type="range" min="0" max="4" name="ranking[]" id="ranking_'+data_count+'">'
                    + '</td></tr>');
            }
            else
            {
                jQuery("#info_data_"+(data_count)).val(info);
                jQuery("#ranking_"+data_count).val(rank);
                //document.getElementById('ranking_'+data_count++).value = rank;
            }
            odd = !odd;
        }

    </script>
    <?php
}
?>