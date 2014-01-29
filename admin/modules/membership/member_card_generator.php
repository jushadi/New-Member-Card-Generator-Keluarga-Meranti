<?php
/**
 * Copyright (C) 2007,2008  Arie Nugraha (dicarve@yahoo.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

/* Member card print */

// key to authenticate
define('INDEX_AUTH', '1');

// main system configuration
require '../../../sysconfig.inc.php';
// IP based access limitation
require LIB_DIR.'ip_based_access.inc.php';
do_checkIP('smc');
do_checkIP('smc-membership');
// start the session
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';

// privileges checking
$can_read = utility::havePrivilege('membership', 'r');

if (!$can_read) {
    die('<div class="errorBox">You dont have enough privileges to view this section</div>');
}

// local settings
$max_print = 10;

// clean print queue
if (isset($_GET['action']) AND $_GET['action'] == 'clear') {
    // update print queue count object
    echo '<script type="text/javascript">parent.$(\'#queueCount\').html(\'0\');</script>';
    utility::jsAlert(__('Print queue cleared!'));
    unset($_SESSION['card']);
    exit();
}

if (isset($_POST['itemID']) AND !empty($_POST['itemID']) AND isset($_POST['itemAction'])) {
    if (!$can_read) {
        die();
    }
    if (!is_array($_POST['itemID'])) {
        // make an array
        $_POST['itemID'] = array($_POST['itemID']);
    }
    // loop array
    if (isset($_SESSION['card'])) {
        $print_count = count($_SESSION['card']);
    } else {
        $print_count = 0;
    }
    // card size
    $size = 2;
    // create AJAX request
    echo '<script type="text/javascript" src="'.JS_WEB_ROOT_DIR.'jquery.js"></script>';
    echo '<script type="text/javascript">';
    // loop array
    foreach ($_POST['itemID'] as $itemID) {
        if ($print_count == $max_print) {
            $limit_reach = true;
            break;
        }
        if (isset($_SESSION['card'][$itemID])) {
            continue;
        }
        if (!empty($itemID)) {
            $card_text = trim($itemID);
            echo '$.ajax({url: \''.SENAYAN_WEB_ROOT_DIR.'lib/phpbarcode/barcode.php?code='.$card_text.'&encoding='.$sysconf['barcode_encoding'].'&scale='.$size.'&mode=png\', type: \'GET\', error: function() { alert(\'Error creating member card!\'); } });'."\n";
            // add to sessions
            $_SESSION['card'][$itemID] = $itemID;
            $print_count++;
        }
    }
    echo '</script>';
    if (isset($limit_reach)) {
        $msg = str_replace('{max_print}', $max_print, __('Selected items NOT ADDED to print queue. Only {max_print} can be printed at once')); //mfc
        utility::jsAlert($msg);
    } else {
        // update print queue count object
        echo '<script type="text/javascript">parent.$(\'#queueCount\').html(\''.$print_count.'\');</script>';
        utility::jsAlert(__('Selected items added to print queue'));
    }
    exit();
}

// card pdf download
if (isset($_GET['action']) AND $_GET['action'] == 'print') {
    // check if label session array is available
    if (!isset($_SESSION['card'])) {
        utility::jsAlert(__('There is no data to print!'));
        die();
    }
    if (count($_SESSION['card']) < 1) {
        utility::jsAlert(__('There is no data to print!'));
        die();
    }
    // concat all ID together
    $member_ids = '';
    foreach ($_SESSION['card'] as $id) {
        $member_ids .= '\''.$id.'\',';
    }
    // strip the last comma
    $member_ids = substr_replace($member_ids, '', -1);
    // send query to database
	$member_q = $dbs->query('SELECT 
m.member_id, 
m.member_name,
m.member_image,
IF (gender = 1, "Pria", "Wanita") AS gender, 
IF (member_address = "", "-", member_address) AS member_address,
IF (member_mail_address = "", "-", member_mail_address) AS member_mail_address,
IF (member_email = "", "-", member_email) AS member_email, 
IF (postal_code = "", "-", postal_code) AS postal_code,
IF (inst_name = "", "-", inst_name) AS inst_name,
IF (pin = "", "-", pin) AS pin,
IF (member_phone = "", "-", member_phone) AS member_phone, 
IF (member_fax = "", "-", member_fax) AS member_fax,
DATE_FORMAT(birth_date, "%d-%m-%Y") AS birth_date,
DATE_FORMAT(member_since_date, "%d-%m-%Y") AS member_since_date, 
DATE_FORMAT(register_date, "%d-%m-%Y") AS register_date,
DATE_FORMAT(expire_date, "%d-%m-%Y") AS expire_date,
mt.member_type_name FROM member AS m
        LEFT JOIN mst_member_type AS mt ON m.member_type_id=mt.member_type_id
        WHERE m.member_id IN('.$member_ids.')');
    $member_datas = array();
    while ($member_d = $member_q->fetch_assoc()) {
        if ($member_d['member_id']) {
            $member_datas[] = $member_d;
        }
    }

    // include printed settings configuration file
    include SENAYAN_BASE_DIR.'admin'.DIRECTORY_SEPARATOR.'admin_template'.DIRECTORY_SEPARATOR.'printed_settings.inc.php';
    // check for custom template settings
    $custom_settings = SENAYAN_BASE_DIR.'admin'.DIRECTORY_SEPARATOR.$sysconf['admin_template']['dir'].DIRECTORY_SEPARATOR.$sysconf['template']['theme'].DIRECTORY_SEPARATOR.'printed_settings.inc.php';
    if (file_exists($custom_settings)) {
        include $custom_settings;
    }
// chunk cards array
$chunked_card_arrays = array_chunk($member_datas, $sysconf['membercard_print_settings']['card_items_per_row']);
// create html ouput
include SENAYAN_BASE_DIR.'card_template'.DIRECTORY_SEPARATOR.$sysconf['membercard_print_settings']['theme'].DIRECTORY_SEPARATOR.'index.php';
    // unset the session
    unset($_SESSION['card']);
    // write to file
    $print_file_name = 'member_card_gen_print_result_'.strtolower(str_replace(' ', '_', $_SESSION['uname'])).'.html';
    $file_write = @file_put_contents(FILES_UPLOAD_DIR.$print_file_name, $html_str);
    if ($file_write) {
        // update print queue count object
        echo '<script type="text/javascript">parent.$(\'#queueCount\').html(\'0\');</script>';
        // open result in wifield yang asli kan cuma 3, id, nama dan , untuk ndow
        echo '<script type="text/javascript">top.openHTMLpop(\''.SENAYAN_WEB_ROOT_DIR.FILES_DIR.'/'.$print_file_name.'\', 800, 500, \''.__('Member Card Printing').'\')</script>';
    } else { utility::jsAlert('ERROR! Cards failed to generate, possibly because '.SENAYAN_BASE_DIR.FILES_DIR.' directory is not writable'); }
    exit();
}

?>
<fieldset class="menuBox">
<div class="menuBoxInner printIcon">
	<div class="per_title">
    	<h2><?php echo __('Member Card Printing'); ?></h2>
    </div>
	<div class="sub_section">
		<div class="action_button">
		<a target="blindSubmit" href="<?php echo MODULES_WEB_ROOT_DIR; ?>membership/member_card_generator.php?action=clear" class="notAJAX headerText2" style="color: #f00;"><?php echo __('Clear Print Queue'); ?></a>
		<a target="blindSubmit" href="<?php echo MODULES_WEB_ROOT_DIR; ?>membership/member_card_generator.php?action=print" class="notAJAX headerText2"><?php echo __('Print Member Cards'); ?></a>
		<a target="blindSubmit" href="<?php echo MODULES_WEB_ROOT_DIR; ?>membership/member_card_generator.php?action=print&mirror=1" class="notAJAX headerText2"><?php echo __('Print Mirror'); ?></a>
		<a href="javascript: openHTMLpop('<?php echo MODULES_WEB_ROOT_DIR; ?>membership/pop_print_settings.php?type=membercard', 600, 500, 'Print membercard settings')" class="notAJAX headerText2 input-icon" title="<?php echo __('Change print barcode settings'); ?>"><div class="icon-setting"></div>&nbsp;</a>
		</div>
	    <form name="search" action="<?php echo MODULES_WEB_ROOT_DIR; ?>membership/member_card_generator.php" id="search" method="get" style="display: inline;"><?php echo __('Search'); ?>:
	    <input type="text" name="keywords" size="30" />
	    <input type="submit" id="doSearch" value="<?php echo __('Search'); ?>" class="button" />
	    </form>
    </div>
    <div class="infoBox">
    <?php
    echo __('Maximum').' <font style="color: #f00">'.$max_print.'</font> '.__('records can be printed at once. Currently there is').' '; //mfc
    if (isset($_SESSION['card'])) {
        echo '<font id="queueCount" style="color: #f00">'.count($_SESSION['card']).'</font>';
    } else { echo '<font id="queueCount" style="color: #f00">0</font>'; }
    echo ' '.__('in queue waiting to be printed.'); //mfc
    ?>
    </div>
</div>
</fieldset>
<?php
/* search form end */
/* ITEM LIST */
// table spec
$table_spec = 'member AS m
    LEFT JOIN mst_member_type AS mt ON m.member_type_id=mt.member_type_id';
// create datagrid
$datagrid = new simbio_datagrid();
$datagrid->setSQLColumn('m.member_id',
    'm.member_id AS \''.__('Member ID').'\'',
    'm.member_name AS \''.__('Member Name').'\'',
    'mt.member_type_name AS \''.__('Membership Type').'\'');
$datagrid->setSQLorder('m.last_update DESC');
// is there any search
if (isset($_GET['keywords']) AND $_GET['keywords']) {
    $keyword = $dbs->escape_string(trim($_GET['keywords']));
    $words = explode(' ', $keyword);
    if (count($words) > 1) {
        $concat_sql = ' (';
        foreach ($words as $word) {
            $concat_sql .= " (m.member_id LIKE '%$word%' OR m.member_name LIKE '%$word%'";
        }
        // remove the last AND
        $concat_sql = substr_replace($concat_sql, '', -3);
        $concat_sql .= ') ';
        $datagrid->setSQLCriteria($concat_sql);
    } else {
        $datagrid->setSQLCriteria("m.member_id LIKE '%$keyword%' OR m.member_name LIKE '%$keyword%'");
    }
}
// set table and table header attributes
$datagrid->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
$datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
// edit and checkbox property
$datagrid->edit_property = false;
$datagrid->chbox_property = array('itemID', __('Add'));
$datagrid->chbox_action_button = __('Add To Print Queue');
$datagrid->chbox_confirm_msg = __('Add to print queue?');
$datagrid->column_width = array('10%', '70%', '15%');
// set checkbox action URL
$datagrid->chbox_form_URL = $_SERVER['PHP_SELF'];
// put the result into variables
$datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 20, $can_read);
if (isset($_GET['keywords']) AND $_GET['keywords']) {
    echo '<div class="infoBox">'.__('Found').' '.$datagrid->num_rows.' '.__('from your search with keyword').': "'.$_GET['keywords'].'"</div>'; //mfc
}
echo $datagrid_result;
/* main content end */
?>
