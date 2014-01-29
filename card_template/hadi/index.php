<?php
// chunk cards array
$chunked_card_arrays = array_chunk($member_datas, $sysconf['membercard_print_settings']['card_items_per_row']);
// create html ouput
$html_str = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
$html_str .= '<html xmlns="http://www.w3.org/1999/xhtml"><head><title>Member Card by Jushadi Arman Saz</title>'."\n";
$html_str .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
$html_str .= '<meta http-equiv="Pragma" content="no-cache" /><meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, post-check=0, pre-check=0" /><meta http-equiv="Expires" content="Fry, 02 Oct 2012 12:00:00 GMT" />';
$html_str .= '<style type="text/css" media="all">'."\n";
$html_str .= '*{font:12px Arial, Helvetica, sans-serif;}'."\n";
$html_str .= 'p, li{position: relative;}'."\n";
$html_str .= 'p{margin-bottom: 0px;margin-top: 0px;font-weight: '.$sysconf['membercard_print_settings']['card_bio_font_weight'].';}'."\n";
$html_str .= 'li{margin-bottom: 0px; margin-top: 0px;list-style-type: disc;font-size: 8px;}'."\n";
$html_str .= 'ul{margin: 0px;padding-left: 10px;}'."\n";
$html_str .= 'h1{margin: 0px;font-weight: bold;text-align: center;font-size:13px;}'."\n";
$html_str .= 'h2{margin: 0px;font-weight: bold;text-align: center;padding-bottom:3px;font-size:5px;}'."\n";
$html_str .= 'h3{margin: 0px;font-weight: bold;text-align: center;font-size:13px;}'."\n";
$html_str .= 'h4{margin: 0px;font-weight: bold;text-align: center;padding-bottom:3px;font-size:5px;}'."\n";
$html_str .= 'hr{margin: 0px;border: 1px solid '.$sysconf['membercard_print_settings']['card_header_color'].';position: relative;}'."\n";
$html_str .= 'td{padding:4px 10px 5px 10px;border-top:thin; border-right:thin;}'."\n";
if (!$_GET[mirror])   
{ $html_str .= '#kontainer_div{z-index:1;position: relative; width:'.($sysconf['membercard_print_settings']['card_box_width']*37.795275591).'px; height:'.($sysconf['membercard_print_settings']['card_box_height']*37.795275591).'px;margin-bottom:'.($card_items_margin*37.795275591).'px;border:#CCCCCC solid 1px;-moz-border-radius: 8px;border-radius: 8px;}'."\n"; }//J u s h a d i   A r m a n  S a z
    else                                
{ $html_str .= '#kontainer_div{z-index:1;position: relative; width:'.($sysconf['membercard_print_settings']['card_box_width']*37.795275591).'px; height:'.($sysconf['membercard_print_settings']['card_box_height']*37.795275591).'px;margin-bottom:'.($card_items_margin*37.795275591).'px;border:#CCCCCC solid 1px;-moz-border-radius: 8px;border-radius: 8px;-moz-transform:rotateY(180deg);}'."\n"; }
$html_str .= '#header1{z-index:2;position: absolute;left: 0px;top: 0px;width:145px;height: 45px;color:'.$sysconf['membercard_print_settings']['card_header_color'].'; border-top-left-radius: 8px;border-top-right-radius: 8px;padding-bottom: 5px;padding-left: 39px;padding-top: 10px;}'."\n";
$html_str .= '#header1_div{-moz-transform:rotateZ(90deg);z-index:2;position: absolute;left: 195px;top: 72px;width:205px;height: 60px;color:'.$sysconf['membercard_print_settings']['card_header_color'].'; background-color: gold;border-top-left-radius: 8px;border-top-right-radius: 8px;}'."\n";
$html_str .= '#header2_div{z-index:3;position: absolute;left: 10px;top: 4px;width:300px;height: 43px;color:'.$sysconf['membercard_print_settings']['card_header_color'].';}'."\n";
$html_str .= '#garis{position:absolute; left: 10px;top: 51px;width:305px;height: 45px;}'."\n";
$html_str .= '#rules_div{-moz-transform:rotateZ(90deg);z-index:4;position: absolute;left: 120px;top:30px;width:165px;height: 142px;text-align: justify;}'."\n";
$html_str .= '#address_div{-moz-transform:rotateZ(90deg);z-index:4;position: absolute;left: -77px;top: 95px;width:200px;height: 30px;font-size:7px;color: #000000;font-weight: bold;}'."\n";
$html_str .= '#logo_div{-moz-transform:rotateZ(90deg);z-index:5;position: absolute;left: 275px;top: 5px;}'."\n";
$html_str .= '#photo_blank_div{-moz-transform:rotateZ(90deg);z-index:5;position: absolute;left: 115px;top:50px;font-size: 7px;text-align: center;border:#cccccc solid 1px;width:'.(($sysconf['membercard_print_settings']['card_photo_width']-0.2)*37.795275591).'px; height:'.(($sysconf['membercard_print_settings']['card_photo_height']-0.2)*37.795275591).'px;}'."\n";
$html_str .= '#photo_div{-moz-transform:rotateZ(90deg);z-index:6;position: absolute;left: 115px;top:50px;width:'.(($sysconf['membercard_print_settings']['card_photo_width']+0.2)*37.795275591).'px; height:'.($sysconf['membercard_print_settings']['card_photo_height']*37.795275591).'px;}'."\n";
$html_str .= '.bio_div{-moz-transform:rotateZ(90deg);z-index:7;position: absolute;left: -50px;top:55px;height: 100px;margin: 0px;text-align: center;width: 50%;}'."\n";
$html_str .= '.bio_label{z-index:10;float: left; width: 100%;margin-bottom:0px;margin-top: 0px;margin-left:0px;font-weight: bold;}'."\n";
$html_str .= '.bio_llabel{z-index:10;float: left; width: 100%;margin-bottom:0px;margin-top: 0px;margin-left:0px;}'."\n";
$html_str .= '.stempel_div{-moz-transform:rotateZ(90deg);z-index:11;position: absolute;left: 0px;top:105px;margin-bottom: 34px;width: 118px;}'."\n";
$html_str .= '.stempel{z-index:12;text-align: center;margin: 0px;}'."\n";
$html_str .= '.lokasi{z-index:13;font-size:8px;margin: 0px;}'."\n";
$html_str .= '.jabatan{z-index:14;font-size:8px;margin: 0px;}'."\n";
$html_str .= '.pejabat{z-index:15;top: 0px;font-size: 8px;margin: 0px;}'."\n";
$html_str .= '.gambar_ttd_div{z-index:16;position: absolute;left: 0px;top: 20px;width:107px;height: 25px;}'."\n";
$html_str .= '.gambar_stempel_div{z-index:17;position: absolute;left:-10px;top: 15px;width: 40px;height: 40px;}'."\n";
$html_str .= '.mtype{z-index:199;position: absolute;border-radius: 4px 4px 4px 4px;left: 0px;top: 0px;width:83px;height: 12px;font-size: 9px;text-align: center;font-weight: bold;}'."\n";
$html_str .= '.mtype_div{-moz-transform:rotateZ(90deg);z-index:199;border: medium ridge royalblue;position: absolute;border-radius: 4px 4px 4px 4px;left: 50px;top: 95px;width:83px;height: 12px;font-size: 9px;text-align: center;font-weight: bold;}'."\n";
$html_str .= '.exp_div{z-index:18;position: absolute;left: 90px;top: 185px;width:135px;height: 12px;font-size: 9px;text-align: left;}'."\n";
$html_str .= '.barcode_div{z-index:19;position: absolute;left: 70px;top: 10px;width:160px;}'."\n";
$html_str .= '</style>'."\n";
$html_str .= '</head>'."\n";
$html_str .= '<body>'."\n";
$html_str .= '<table cellspacing="0" cellpadding="20" border="1">'."\n";
    // loop the chunked arrays to row
    foreach ($chunked_card_arrays as $card_rows) {
        $html_str .= '<tr>'."\n";
        foreach ($card_rows as $card) {
            $html_str .= '<td valign="top">';
$html_str .= '<div id="kontainer_div">';
$html_str .= '<div><img width="'.($sysconf['membercard_print_settings']['card_box_width']*37.795275591).'px" height="'.($sysconf['membercard_print_settings']['card_box_height']*37.795275591).'px" src="'.SENAYAN_WEB_ROOT_DIR.IMAGES_DIR.'/member_card/Frontcard_'.$card['member_type_name'].'" style="border-radius: 8px; -moz-border-radius: 8px;-khtml-border-radius: 8px;-webkit-border-radius: 8px;"></img></div>';
$html_str .= '<div id="logo_div"><img height="45px" width="45px" src="'.SENAYAN_WEB_ROOT_DIR.IMAGES_DIR.'/member_card/Logo_'.$card['member_type_name'].'"></img></div>';
$html_str .= '<div id="header1_div"><img style="width: 100%; height:100%; border-top-left-radius: 8px;border-top-right-radius: 8px;" src="/x3/images/member_card/1blue.png">';
$html_str .= '<div id="header1">';
$html_str .= '<h1>'.$sysconf['membercard_print_settings']['card_front_header1_text'].'</h1>';
$html_str .= '<h2>'.$sysconf['membercard_print_settings']['card_front_header2_text'].'</h2></div></div>';
$html_str .= ''.( $sysconf['membercard_print_settings']['card_show_front_hlines']?'':'<!--').'<div id="garis"><hr></div>'.( $sysconf['membercard_print_settings']['card_show_front_hlines']?'':'-->').'';
$html_str .= '<div class="bio_div">';
$html_str .= ''.( $sysconf['membercard_print_settings']['card_show_id_label']?'':'<!--').'<span class="bio_label">'.$card['member_id'].'</span>'.( $sysconf['membercard_print_settings']['card_show_id_label']?'':'-->').'';
$html_str .= ''.( $sysconf['membercard_print_settings']['card_show_name_label']?'':'<!--').'<span class="bio_label">'.$card['member_name'].'</span>'.( $sysconf['membercard_print_settings']['card_show_name_label']?'':'-->').'';
$html_str .= ''.( $sysconf['membercard_print_settings']['card_show_gender_label']?'':'<!--').'<span class="bio_label">'.$card['gender'].'</span>'.( $sysconf['membercard_print_settings']['card_show_gender_label']?'':'-->').'';
$html_str .= ''.( $sysconf['membercard_print_settings']['card_show_bdate_label']?'':'<!--').'<span class="bio_label">'.$card['birth_date'].'</span>'.( $sysconf['membercard_print_settings']['card_show_bdate_label']?'':'-->').'';
$html_str .= ''.( $sysconf['membercard_print_settings']['card_show_pin_label']?'':'<!--').'<span class="bio_label">'.$card['pin'].'</span>'.( $sysconf['membercard_print_settings']['card_show_pin_label']?'':'-->').'';
$html_str .= ''.( $sysconf['membercard_print_settings']['card_show_email_label']?'':'<!--').'<span class="bio_label">'.$card['member_email'].'</span>'.( $sysconf['membercard_print_settings']['card_show_email_label']?'':'-->').'';
$html_str .= ''.( $sysconf['membercard_print_settings']['card_show_inst_label']?'':'<!--').'<span class="bio_label">'.$card['inst_name'].'</span>'.( $sysconf['membercard_print_settings']['card_show_inst_label']?'':'-->').'';
$html_str .= ''.( $sysconf['membercard_print_settings']['card_show_fax_label']?'':'<!--').'<span class="bio_llabel">'.$card['member_fax'].'</span>'.( $sysconf['membercard_print_settings']['card_show_fax_label']?'':'-->').'';
$html_str .= ''.( $sysconf['membercard_print_settings']['card_show_postal_code_label']?'':'<!--').'<span class="bio_llabel">'.$card['postal_code'].'</span>'.( $sysconf['membercard_print_settings']['card_show_postal_code_label']?'':'-->').'';
$html_str .= ''.( $sysconf['membercard_print_settings']['card_show_address_label']?'':'<!--').'<span class="bio_llabel">'.$card['member_address'].''.( $sysconf['membercard_print_settings']['card_show_mphone_label']?'':'<!--').' / '.$card['member_phone'].''.( $sysconf['membercard_print_settings']['card_show_mphone_label']?'':'-->').'</span>'.( $sysconf['membercard_print_settings']['card_show_address_label']?'':'-->').'';
$html_str .= ''.( $sysconf['membercard_print_settings']['card_show_mail_address_label']?'':'<!--').'<span class="bio_llabel">'.$card['member_mail_address'].'</span>'.( $sysconf['membercard_print_settings']['card_show_mail_address_label']?'':'-->').'';

$html_str .= '</div>';
$html_str .= '<div id="photo_blank_div"><br /><br />Foto Ukuran:<br />'.$sysconf['membercard_print_settings']['card_photo_width'].' X '.$sysconf['membercard_print_settings']['card_photo_height'].' cm</div>';
$html_str .= '<div id="photo_div"><div align="center"><img width="'.($sysconf['membercard_print_settings']['card_photo_width']*37.795275591+2).'px" height="'.($sysconf['membercard_print_settings']['card_photo_height']*37.795275591+2).'px" style="border-radius: 4px; -moz-border-radius: 4px;-khtml-border-radius: 4px;-webkit-border-radius: 4px;" src="'.SENAYAN_WEB_ROOT_DIR.IMAGES_DIR.'/persons/'.$card['member_image'].'"/></img></div></div>';
$html_str .= ''.( $sysconf['membercard_print_settings']['card_show_type_label']?'':'<!--').'<div class="mtype_div"><img style="width: 100%; height:100%; border-radius: 1px;" src="/x3/images/member_card/1white.png"><div class="mtype">'.$card['member_type_name'].'</div></div>'.( $sysconf['membercard_print_settings']['card_show_type_label']?'':'-->').''; //Jushadi
$html_str .= ''.( $sysconf['membercard_print_settings']['card_show_expired_label']?'':'<!--').'<div class="exp_div">'.__('Expiry Date').' : '.$card['expire_date'].'</div>'.( $sysconf['membercard_print_settings']['card_show_expired_label']?'':'-->').'';
$html_str .= ''.( $sysconf['membercard_print_settings']['card_show_barcode_label']?'':'<!--').'<div class="barcode_div">';
$html_str .= '<div style="text-align: right;"><img  src="'.SENAYAN_WEB_ROOT_DIR.IMAGES_DIR.'/barcodes/'.str_replace(array(' '), '_', $card['member_id']).'.png" style="width: 100%; height:25px; border-radius: 3px; -moz-border-radius: 3px;-khtml-border-radius: 3px;-webkit-border-radius: 3px;"></img></div></div>'.( $sysconf['membercard_print_settings']['card_show_barcode_label']?'':'-->').''; 
$html_str .= '</td>';
$html_str .= '<td valign="top">';
$html_str .= '<div id="kontainer_div">';
$html_str .= '<div><img height="'.($sysconf['membercard_print_settings']['card_box_height']*37.795275591).'px" width="'.($sysconf['membercard_print_settings']['card_box_width']*37.795275591).'px" src="'.SENAYAN_WEB_ROOT_DIR.IMAGES_DIR.'/member_card/Rearcard_'.$card['member_type_name'].'" style="border-radius: 8px; -moz-border-radius: 8px;-khtml-border-radius: 8px;-webkit-border-radius: 8px;"></img></div>';
$html_str .= ''.( $sysconf['membercard_print_settings']['card_show_back_header']?'':'<!--').'<div id="logo_div"><img height="45px" width="45px" src="'.SENAYAN_WEB_ROOT_DIR.IMAGES_DIR.'/member_card/Logo_'.$card['member_type_name'].'"></img></div>';
$html_str .= '<div id="header1_div"><img style="width: 100%; height:100%; border-top-left-radius: 8px;border-top-right-radius: 8px;" src="/x3/images/member_card/1blue.png">'; // Jushadi  Arman  Saz
$html_str .= '<div id="header1">';
$html_str .= '<h1>'.$sysconf['membercard_print_settings']['card_front_header1_text'].'</h1>';
$html_str .= '<h2>'.$sysconf['membercard_print_settings']['card_front_header2_text'].'</h2></div></div>'.( $sysconf['membercard_print_settings']['card_show_back_header']?'':'-->').'';
//Jushadi Arman Saz
//$html_str .= '<div id="header1_div">';
//$html_str .= '<h3>'.$sysconf['membercard_print_settings']['card_back_header1_text'].'</h3>';
//$html_str .= '<h4>'.$sysconf['membercard_print_settings']['card_back_header2_text'].'</h4></div>'.( $sysconf['membercard_print_settings']['card_show_back_header']?'':'-->').'';
$html_str .= ''.( $sysconf['membercard_print_settings']['card_show_back_hlines']?'':'<!--').'<div id="garis"><hr></div>'.( $sysconf['membercard_print_settings']['card_show_back_hlines']?'':'-->').'';
$html_str .= '<div id="rules_div"><ul>'.$sysconf['membercard_print_settings']['card_rules'].'</ul></div>';
$html_str .= '<div id="address_div">'.$sysconf['membercard_print_settings']['card_address'].'</div>';
$html_str .= ''.( $sysconf['membercard_print_settings']['card_show_back_stamp']?'':'<!--').'<div class="stempel_div">';
$html_str .= '<div class="gambar_stempel_div"><img class="" height="35px" width="35px" src="'.SENAYAN_WEB_ROOT_DIR.IMAGES_DIR.'/member_card/Stamp_'.$card['member_type_name'].'"></img></div>';
$html_str .= '<div class="gambar_ttd_div"><img class="" height="30px" width="100px" src="'.SENAYAN_WEB_ROOT_DIR.IMAGES_DIR.'/member_card/Signature_'.$card['member_type_name'].'"></img></div>';
$html_str .= '<p class="stempel lokasi">'.$sysconf['membercard_print_settings']['card_city'].', '.$card['register_date'].'</p><p class="stempel jabatan">'.$sysconf['membercard_print_settings']['card_title'].'</p><br><br>';
$html_str .= '<p class="stempel pejabat">'.$sysconf['membercard_print_settings']['card_officials'].'</br>'.$sysconf['membercard_print_settings']['card_officials_id'].'</p></div></div>'.( $sysconf['membercard_print_settings']['card_show_back_stamp']?'':'-->').'';
$html_str .= '</td>';
        }
        $html_str .= '<tr>'."\n";
    }
    $html_str .= '</table>'."\n";
	    $html_str .= '<a style="font-size: 9px;" href="#" onclick="window.print()">Print Again</a><br />'."\n";
    $html_str .= '<script type="text/javascript">self.print();</script>'."\n";
    $html_str .= '</body></html>'."\n";
// Jushadi
?>
