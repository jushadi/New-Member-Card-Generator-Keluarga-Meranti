<?php
/**
 * Copyright (C) 2007,2008  Arie Nugraha (dicarve@yahoo.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *  Jushadi Arman Saz
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


/* Member Type Management section */

// key to authenticate
define('INDEX_AUTH', '1');
// key to get full database access
define('DB_ACCESS', 'fa');

// main system configuration
require '../../../sysconfig.inc.php';
// IP based access limitation
require LIB_DIR.'ip_based_access.inc.php';

do_checkIP('smc');
do_checkIP('smc-membership');
// start the session
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';
require SIMBIO_BASE_DIR.'simbio_UTILS/simbio_date.inc.php';
require SIMBIO_BASE_DIR.'simbio_FILE/simbio_file_upload.inc.php';


// privileges checking
$can_read = utility::havePrivilege('membership', 'r');
$can_write = utility::havePrivilege('membership', 'w');

if (!$can_read) {
    die('<div class="errorBox">'.__('You don\'t have enough privileges to access this area!').'</div>');
}

/* RECORD OPERATION */
if (isset($_POST['saveData']) AND $can_read AND $can_write) {
    // check form validity
    $memberTypeName = trim(strip_tags($_POST['memberTypeName']));
    if (empty($memberTypeName)) {
        utility::jsAlert(__('Member Type Name can\'t be empty')); //mfc
        exit();
    } else {
        $data['member_type_name'] = $dbs->escape_string($memberTypeName);

//Jushadi Arman  Saz
        //hadi image uploading
		//hadi_front_card
		    if (!empty($_FILES['input_front_bg']) AND $_FILES['input_front_bg']['size']) { //field form
            // create upload object
            $upload = new simbio_file_upload();
            $upload->setAllowableFormat($sysconf['allowed_images']);
            $upload->setMaxSize($sysconf['max_image_upload']*1024); // approx. 100 kb
            $upload->setUploadDir(IMAGES_BASE_DIR.'member_card');
            // give new name for upload file
            $new_filename = 'Frontcard_'.$data['member_type_name'];
            $upload_status = $upload->doUpload('input_front_bg', $new_filename);
            if ($upload_status == UPLOAD_SUCCESS) {
            $data['front_card_bg'] = $dbs->escape_string($upload->new_filename); //database field
			//$data['front_card_bg'] = $dbs->escape_string($upload->new_filename.'.png');
            }
        } 
		
		//hadi_rear_card
		    if (!empty($_FILES['input_rear_bg']) AND $_FILES['input_rear_bg']['size']) { //field form
            // create upload object
            $upload = new simbio_file_upload();
            $upload->setAllowableFormat($sysconf['allowed_images']);
            $upload->setMaxSize($sysconf['max_image_upload']*1024); // approx. 100 kb
            $upload->setUploadDir(IMAGES_BASE_DIR.'member_card');
            // give new name for upload file
            $new_filename = 'Rearcard_'.$data['member_type_name'];
            $upload_status = $upload->doUpload('input_rear_bg', $new_filename);
            if ($upload_status == UPLOAD_SUCCESS) {
            $data['rear_card_bg'] = $dbs->escape_string($upload->new_filename); //database field
            }
        }

		//hadi_card_logo
		    if (!empty($_FILES['input_card_logo']) AND $_FILES['input_card_logo']['size']) { //field form
            // create upload object
            $upload = new simbio_file_upload();
            $upload->setAllowableFormat($sysconf['allowed_images']);
            $upload->setMaxSize($sysconf['max_image_upload']*1024); // approx. 100 kb
            $upload->setUploadDir(IMAGES_BASE_DIR.'member_card');
            // give new name for upload file
            $new_filename = 'Logo_'.$data['member_type_name'];
            $upload_status = $upload->doUpload('input_card_logo', $new_filename);
            if ($upload_status == UPLOAD_SUCCESS) {
            $data['card_logo'] = $dbs->escape_string($upload->new_filename); //database field
            }
        } 
		
		//hadi_card_signature
		    if (!empty($_FILES['input_card_signature']) AND $_FILES['input_card_signature']['size']) { //field form
            // create upload object
            $upload = new simbio_file_upload();
            $upload->setAllowableFormat($sysconf['allowed_images']);
            $upload->setMaxSize($sysconf['max_image_upload']*1024); // approx. 100 kb
            $upload->setUploadDir(IMAGES_BASE_DIR.'member_card');
            // give new name for upload file
            $new_filename = 'Signature_'.$data['member_type_name'];
            $upload_status = $upload->doUpload('input_card_signature', $new_filename);
            if ($upload_status == UPLOAD_SUCCESS) {
            $data['card_signature'] = $dbs->escape_string($upload->new_filename); //database field
            }
        } 
		//Jushadi  Arman Saz
		//hadi_card_stamp
		    if (!empty($_FILES['input_card_stamp']) AND $_FILES['input_card_stamp']['size']) { //field form
            // create upload object
            $upload = new simbio_file_upload();
            $upload->setAllowableFormat($sysconf['allowed_images']);
            $upload->setMaxSize($sysconf['max_image_upload']*1024); // approx. 100 kb
            $upload->setUploadDir(IMAGES_BASE_DIR.'member_card');
            // give new name for upload file
            $new_filename = 'Stamp_'.$data['member_type_name'];
            $upload_status = $upload->doUpload('input_card_stamp', $new_filename);
            if ($upload_status == UPLOAD_SUCCESS) {
            $data['card_stamp'] = $dbs->escape_string($upload->new_filename); //database field
            }
        } 
		
		
		// upload status alert
                if (isset($upload_status)) {
                    if ($upload_status == UPLOAD_SUCCESS) {
                        // write log
                        utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'membership', $_SESSION['realname'].' upload image file '.$upload->new_filename);
                        utility::jsAlert(__('Image Uploaded Successfully'));
                    } else {
                        // write log
                        utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'membership', 'ERROR : '.$_SESSION['realname'].' FAILED TO upload image file '.$upload->new_filename.', with error ('.$upload->error.')');
                        utility::jsAlert(__('Image FAILED to upload'));
                    }
                }

		
        // create sql op object
        $sql_op = new simbio_dbop($dbs);
        if (isset($_POST['updateRecordID'])) {
            /* UPDATE RECORD MODE */
            // remove input date
            unset($data['input_date']);
            // filter update record ID
            $updateRecordID = (integer)$_POST['updateRecordID'];
            // update the data
            $update = $sql_op->update('mst_member_type', $data, 'member_type_id='.$updateRecordID);
            if ($update) {
                utility::jsAlert(__('Member Type Successfully Updated'));
				
						// J u s h a d i  A r m a n  S a z		
				
        // update all member expire date
                @$dbs->query('UPDATE member AS m SET expire_date=DATE_ADD(register_date,INTERVAL '.$data['member_periode'].'  DAY)
                    WHERE member_type_id='.$updateRecordID);
                echo '<script type="text/javascript">parent.$(\'#mainContent\').simbioAJAX(\''.$_SERVER['PHP_SELF'].'\');</script>';
            } else { utility::jsAlert(__('Member Type Data FAILED to Save/Update. Please Contact System Administrator')."\nDEBUG : ".$sql_op->error); }
            exit();
        } else {
            /* INSERT RECORD MODE */
            // insert the data
            if ($sql_op->insert('mst_member_type', $data)) {
                utility::jsAlert(__('New Member Type Successfully Saved'));
                echo '<script type="text/javascript">parent.$(\'#mainContent\').simbioAJAX(\''.$_SERVER['PHP_SELF'].'\');</script>';
            } else { utility::jsAlert(__('Member Type Data FAILED to Save/Update. Please Contact System Administrator')."\n".$sql_op->error); }
            exit();
        }
    }
    exit();
} else if (isset($_POST['itemID']) AND !empty($_POST['itemID']) AND isset($_POST['itemAction'])) {
    if (!($can_read AND $can_write)) {
        die();
    }
    /* DATA DELETION PROCESS */
    $sql_op = new simbio_dbop($dbs);
    $failed_array = array();
    $error_num = 0;
    if (!is_array($_POST['itemID'])) {
        // make an array
        $_POST['itemID'] = array((integer)$_POST['itemID']);
    }
    // loop array
    foreach ($_POST['itemID'] as $itemID) {
        $itemID = (integer)$itemID;
        if (!$sql_op->delete('mst_member_type', 'member_type_id='.$itemID)) {
            $error_num++;
        }
    }

    // error alerting
    if ($error_num == 0) {
        utility::jsAlert(__('All Data Successfully Deleted'));
        echo '<script type="text/javascript">parent.$(\'#mainContent\').simbioAJAX(\''.$_SERVER['PHP_SELF'].'?'.$_POST['lastQueryStr'].'\');</script>';
    } else {
        utility::jsAlert(__('Some or All Data NOT deleted successfully!\nPlease contact system administrator'));
        echo '<script type="text/javascript">parent.$(\'#mainContent\').simbioAJAX(\''.$_SERVER['PHP_SELF'].'?'.$_POST['lastQueryStr'].'\');</script>';
    }
    exit();
}
/* RECORD OPERATION END */

/* search form */
?>
<fieldset class="menuBox">
<div class="menuBoxInner memberTypeIcon">
	<div class="per_title">
    	<h2><?php echo __('Template KTA'); ?></h2>
    </div>
    <div class="sub_section">
	    <div class="action_button">
		    <a href="<?php echo MODULES_WEB_ROOT_DIR; ?>membership/member_card_type.php" class="headerText2"><?php echo __('Daftar Template'); ?></a>
		    <a href="<?php echo MODULES_WEB_ROOT_DIR; ?>membership/member_card_type.php?action=detail" class="headerText2"><?php echo __('Tambah Template'); ?></a>
	    </div>
	    <form name="search" action="<?php echo MODULES_WEB_ROOT_DIR; ?>membership/member_card_type.php" id="search" method="get" style="display: inline;"><?php echo __('Search'); ?> :
		    <input type="text" name="keywords" size="30" />
		    <input type="submit" id="doSearch" value="<?php echo __('Search'); ?>" class="button" />
	    </form>
    </div>
</div>
</fieldset>
<?php
/* search form end */
/* main content */
if (isset($_POST['detail']) OR (isset($_GET['action']) AND $_GET['action'] == 'detail')) {
    if (!($can_read AND $can_write)) {
        die('<div class="errorBox">'.__('You don\'t have enough privileges to view this section').'</div>');
    }
    /* RECORD FORM */
    $itemID = (integer)isset($_POST['itemID'])?$_POST['itemID']:0;
    $rec_q = $dbs->query('SELECT * FROM mst_member_type WHERE member_type_id='.$itemID);
    $rec_d = $rec_q->fetch_assoc();

    // create new instance
    $form = new simbio_form_table_AJAX('mainForm', $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'], 'post');
    $form->submit_button_attr = 'name="saveData" value="'.__('Save').'" class="button"';

    // form table attributes
    $form->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
    $form->table_header_attr = 'class="alterCell" style="font-weight: bold;"';
    $form->table_content_attr = 'class="alterCell2"';

    // edit mode flag set
    if ($rec_q->num_rows > 0) {
        $form->edit_mode = true;
        // record ID for delete process
        $form->record_id = $itemID;
        // form record title
        $form->record_title = $rec_d['member_type_name'];
        // submit button attribute
        $form->submit_button_attr = 'name="saveData" value="'.__('Update').'" class="button"';
    }

    /* Form Element(s) */
    // member type name
    $form->addTextField('text', 'memberTypeName', __('Member Type Name').'*', $rec_d['member_type_name'], 'style="width: 80%;"');
    // loan limit
 
	//hadi_front_card	
    $str_input = '';
    if ($rec_d['front_card_bg']) {
        $str_input = '<strong>'.$rec_d['front_card_bg'].'</strong><br />
		<img src="../lib/phpthumb/phpThumb.php?src=../../images/member_card/'.urlencode($rec_d['front_card_bg']).'&w=325.0393700826&timestamp='.date('his').'" style="border: 1px solid #999999" /><br/>';
    }
    $str_input .= simbio_form_element::textField('file', 'input_front_bg');
    $str_input .= ' '.__('Maximum').' '.$sysconf['max_image_upload'].' KB';
    $form->addAnything(__('Depan'), $str_input);
	//hadi_rear_card	
	$str_input = '';
    if ($rec_d['rear_card_bg']) {
        $str_input = '<strong>'.$rec_d['rear_card_bg'].'</strong><br />
		<img src="../lib/phpthumb/phpThumb.php?src=../../images/member_card/'.urlencode($rec_d['rear_card_bg']).'&w=325.0393700826&timestamp='.date('his').'" style="border: 1px solid #999999" /><br/>';
    }
    $str_input .= simbio_form_element::textField('file', 'input_rear_bg');
    $str_input .= ' '.__('Maximum').' '.$sysconf['max_image_upload'].' KB';
    $form->addAnything(__('Belakang'), $str_input);
	//hadi_card_logo	
	$str_input = '';
    if ($rec_d['card_logo']) {
        $str_input = '<strong>'.$rec_d['card_logo'].'</strong><br />
		<img src="../lib/phpthumb/phpThumb.php?src=../../images/member_card/'.urlencode($rec_d['card_logo']).'&w=100&timestamp='.date('his').'" style="border: 1px solid #999999" /><br/>';
    }
    $str_input .= simbio_form_element::textField('file', 'input_card_logo');
    $str_input .= ' '.__('Maximum').' '.$sysconf['max_image_upload'].' KB';
    $form->addAnything(__('Logo'), $str_input);	
	//hadi_card_signature	
	$str_input = '';
    if ($rec_d['card_signature']) {
        $str_input = '<strong>'.$rec_d['card_signature'].'</strong><br />
		<img src="../lib/phpthumb/phpThumb.php?src=../../images/member_card/'.urlencode($rec_d['card_signature']).'&w=100&timestamp='.date('his').'" style="border: 1px solid #999999" /><br/>';
    }
    $str_input .= simbio_form_element::textField('file', 'input_card_signature');
    $str_input .= ' '.__('Maximum').' '.$sysconf['max_image_upload'].' KB';
    $form->addAnything(__('Tanda tangan'), $str_input);	
	//hadi_card_stamp	
	$str_input = '';
    if ($rec_d['card_stamp']) {
        $str_input = '<strong>'.$rec_d['card_stamp'].'</strong><br />
		<img src="../lib/phpthumb/phpThumb.php?src=../../images/member_card/'.urlencode($rec_d['card_stamp']).'&w=100&timestamp='.date('his').'" style="border: 1px solid #999999" /><br/>';
    }
    $str_input .= simbio_form_element::textField('file', 'input_card_stamp');
    $str_input .= ' '.__('Maximum').' '.$sysconf['max_image_upload'].' KB';
    $form->addAnything(__('Stempel'), $str_input);	
                
    // edit mode messagge
    if ($form->edit_mode) {
        echo '<div class="infoBox">'.__('You are going to edit member data').' : <b>'.$rec_d['member_type_name'].'</b> <br />'.__('Last Updated').' '.$rec_d['last_update'].'</div>'."\n"; //mfc
    }
    // print out the form object
    echo $form->printOut();
} else {
    /* MEMBER TYPE NAME LIST */
    // table spec
    $table_spec = 'mst_member_type AS mt';

    // create datagrid
    $datagrid = new simbio_datagrid();
    if ($can_read AND $can_write) {
        $datagrid->setSQLColumn('mt.member_type_id',
            'mt.member_type_name AS \''.__('Membership Type').'\'',
            'mt.front_card_bg AS \''.__('Kartu Depan').'\'',
            'mt.rear_card_bg  AS \''.__('Kartu Belakang').'\'',
            'mt.card_logo AS \''.__('Logo').'\'',
			'mt.card_signature AS \''.__('Tanda Tangan').'\'',
			'mt.card_stamp  AS \''.__('Stempel').'\'',
            'mt.last_update AS \''.__('Last Updated').'\'');
    } else {
        $datagrid->setSQLColumn('mt.member_type_name AS \''.__('Membership Type').'\'',
            'mt.front_card_bg AS \''.__('Kartu Depan').'\'',
            'mt.rear_card_bg  AS \''.__('Kartu Belakang').'\'',
            'mt.card_logo AS \''.__('Logo').'\'',
			'mt.card_signature AS \''.__('Tanda Tangan').'\'',
			'mt.card_stamp  AS \''.__('Stempel').'\'',
            'mt.last_update AS \''.__('Last Updated').'\'');
    }
    $datagrid->setSQLorder('member_type_name ASC');

    // is there any search
    if (isset($_GET['keywords']) AND $_GET['keywords']) {
       $keywords = $dbs->escape_string($_GET['keywords']);
       $datagrid->setSQLCriteria("mt.member_type_name LIKE '%$keywords%'");
    }

    // set table and table header attributes
    $datagrid->icon_edit = SENAYAN_WEB_ROOT_DIR.'admin/'.$sysconf['admin_template']['dir'].'/'.$sysconf['admin_template']['theme'].'/edit.gif';
    $datagrid->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
    $datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
    // set delete proccess URL
    $datagrid->chbox_form_URL = $_SERVER['PHP_SELF'];

    // put the result into variables
    $datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 20, ($can_read AND $can_write));
    if (isset($_GET['keywords']) AND $_GET['keywords']) {
        $msg = str_replace('{result->num_rows}', $datagrid->num_rows, __('Found <strong>{result->num_rows}</strong> from your keywords')); //mfc
        echo '<div class="infoBox">'.$msg.' : "'.$_GET['keywords'].'"</div>';
    }

    echo $datagrid_result;
}//Jushadi A r m a n  Saz
/* main content end */
