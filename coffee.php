<?php
include_once 'utils.php';

function coffee()
{
	switch($_POST['i_love_you'])
	{
	case 'coffee':
		global $wpdb;
		$table_name = $wpdb->prefix . 'report_data';
		$fetch = $wpdb->get_results($wpdb->prepare(
				"
				SELECT hierarchy, information, ranking
				FROM $table_name
				WHERE id = %d
				ORDER BY hierarchy;
				",
				$_POST['this_much']
			)
		);
		if(empty($fetch)) echo '';
		else echo json_encode($fetch);
		break;
	default:
		echo "bolly";
		break;
    }
	wp_die();
}
?>