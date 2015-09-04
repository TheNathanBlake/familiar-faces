<?php
class MainFaceTable
{
    private $table_version = '0.89';
    private $create = '';

    function __construct()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'pavlov_faces';

        $this->create = "CREATE TABLE {$table_name} (
          id mediumint(9) NOT NULL AUTO_INCREMENT,
          membername tinytext NOT NULL,
          title tinytext NOT NULL,
          dogname tinytext,
          dogbreed tinytext,
          mainimage tinytext NOT NULL,
          hoverimage tinytext NOT NULL,
          signature tinytext,
          lefttopic tinytext,
          righttopic tinytext,
          polaroid1 tinytext,
          polaroid2 tinytext,
          
          signature tinytext,
          kingdom tinytext,
          species tinytext,
          phylum tinytext,
          stimulant tinytext,
          response tinytext,

          stimulus tinytext,
          location tinytext,
          fear tinytext,
          threewords tinytext,
          ionce tinytext,
          couldntlive tinytext,
          turnonthe tinytext,
          beaker tinytext,
          UNIQUE KEY id (id)
        )";

        $installed_version = get_option('main_face_table');
            
        if(!$installed_version or $installed_version != $this->table_version)
            $this->update_tables();
            //These also go here:
            //add_action('admin_menu', array(&$this, 'admin_menu'));
    }
    function make_tables()
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        if(!require_once(ABSPATH . 'wp-admin/upgrade-functions.php'))
        {
            die('Foolish samurai warrior has added its own maybe_upgrade* functions');
        }

        $query = $this->create . $charset_collate . ';';
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($query);

        add_option('main_face_table', $this->table_version);
    }

    function update_tables()
    {
        $query = $this->create . ';';
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($query);

        update_option('main_face_table', $this->table_version);
    }

}

class FaceInfoTable
{
    private $table_version = '0.8
    ';
    private $create = '';

    function __construct()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'report_data';

        $this->create = "CREATE TABLE $table_name (
          dataid mediumint(9) NOT NULL AUTO_INCREMENT,
          id mediumint(9),
          information mediumtext NOT NULL,
          hierarchy mediumint(9),
          ranking tinyint(9),
          UNIQUE KEY dataid (dataid)
        )";


        $installed_version = get_option('face_info_table');

        if(!$installed_version or $installed_version != $this->table_version)
            $this->update_tables();
            //These also go here:
            //add_action('admin_menu', array(&$this, 'admin_menu'));
    }

    function make_tables()
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        if(!require_once(ABSPATH . 'wp-admin/upgrade-functions.php'))
        {
            die('Foolish samurai warrior has added its own maybe_upgrade* functions');
        }

        $query = $this->create . $charset_collate;
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($query);

        add_option('face_info_table', $this->table_version);
    }

    function update_tables()
    {
        $query = $this->create;
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($query);

        update_option('face_info_table', $this->table_version);
    }

}
?>