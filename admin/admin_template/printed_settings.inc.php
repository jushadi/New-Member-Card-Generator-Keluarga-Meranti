<?php
/**
 * SENAYAN application printable data configuration
 *
 * Copyright (C) 2007,2013 Arie Nugraha (dicarve@yahoo.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
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

/**
 * Function to load and override print settings from database
 */
function loadPrintSettings($dbs, $type) {
  global $sysconf; 
  $barcode_settings_q = $dbs->query("SELECT setting_value FROM setting WHERE setting_name='".$type."_print_settings'");
  if ($barcode_settings_q->num_rows) {
    $barcode_settings_d = $barcode_settings_q->fetch_row();
    if ($barcode_settings_d[0]) {
      $barcode_settings = unserialize($barcode_settings_d[0]);
      foreach ($barcode_settings as $setting_name => $val) {
        $sysconf['print'][$type][$setting_name] = $val;
      }
    }
  }
}



// Jushadi Arman Saz
// member card print settings OK
// Items Settings, change to 0 if dont want to use selected items OK
$sysconf['print']['membercard']['card_show_id_label'] = 1;
$sysconf['print']['membercard']['card_show_name_label'] = 1;
$sysconf['print']['membercard']['card_show_pin_label'] = 0;
$sysconf['print']['membercard']['card_show_email_label'] = 0;
$sysconf['print']['membercard']['card_show_inst_label'] = 1;
$sysconf['print']['membercard']['card_show_address_label'] = 1;
$sysconf['print']['membercard']['card_show_type_label'] = 1;
$sysconf['print']['membercard']['card_show_expired_label'] = 1;
$sysconf['print']['membercard']['card_show_barcode_label'] = 1;
$sysconf['print']['membercard']['card_show_front_hlines'] = 1;
$sysconf['print']['membercard']['card_show_back_hlines'] = 1;
$sysconf['print']['membercard']['card_show_back_header'] = 1;
$sysconf['print']['membercard']['card_show_front_stamp'] = 0;
$sysconf['print']['membercard']['card_show_back_stamp'] = 1;
$sysconf['print']['membercard']['label_namej'] = "J";
// Header Settings
$sysconf['print']['membercard']['card_header_color'] = "#000099"; //e.g. :#0066FF, green, etc.
$sysconf['print']['membercard']['label_nameU'] = "U";
// Front Card Header
$sysconf['print']['membercard']['card_front_header1_text'] = "KARTU ANGGOTA PERPUSTAKAAN<BR>PROGRAM PASCASARJANA";
$sysconf['print']['membercard']['card_front_header1_font_size'] = 13;
$sysconf['print']['membercard']['card_front_header2_text'] = "Kampus UNM Gunung Sari Baru, Jl. Bonto Langkasa, Makassar - 90222<br />Telp. (0411) 830368, Fax. (0411) 855288, e-mail: pasca@unm.ac.id, website: pps.unm.ac.id";
$sysconf['print']['membercard']['card_front_header2_font_size'] = 5;
$sysconf['print']['membercard']['label_nameS'] = "S";
// Rear Card Header

$sysconf['print']['membercard']['card_back_header1_text'] = "PROGRAM PASCASARJANA<br/>UNIVERSITAS NEGERI MAKASSAR";
$sysconf['print']['membercard']['card_back_header1_font_size'] = 13;
$sysconf['print']['membercard']['card_back_header2_text'] = "Kampus UNM Gunung Sari Baru, Jl. Bonto Langkasa, Makassar - 90222<br />Telp. (0411) 830368, Fax. (0411) 855288, e-mail: pasca@unm.ac.id, website: pps.unm.ac.id";
$sysconf['print']['membercard']['card_back_header2_font_size'] = 5; 
$sysconf['print']['membercard']['label_nameH'] = "H";
// Rules OK
$sysconf['print']['membercard']['card_rules'] = "<li>Kartu ini diterbitkan oleh Perpustakaan PPs UNM. Segala penggunaan kartu diatur oleh Perpustakaan PPs UNM sesuai ketentuan dan syarat yang berlaku.</li>
<li>Bila menemukan kartu ini mohon mengembalikan ke Perpustakaan Program Pascasarjana UNM.</li>";
$sysconf['print']['membercard']['card_rules_font_size'] = 8;
$sysconf['print']['membercard']['card_rules_top'] = 58;
$sysconf['print']['membercard']['label_nameA'] = "A";
// Address OK
$sysconf['print']['membercard']['card_address'] = "Perpustakaan Program Pascasarjana UNM<br />pustakawan@unm.ac.id<br />dlibpps.unm.ac.id";
$sysconf['print']['membercard']['card_address_font_size'] = 7;
$sysconf['print']['membercard']['card_address_left'] = 10;
$sysconf['print']['membercard']['card_address_top'] = 165;
$sysconf['print']['membercard']['label_nameD'] = "D";
// Stamp Settings
$sysconf['print']['membercard']['card_city'] = "Makassar";
$sysconf['print']['membercard']['card_title'] = "Direktur PPs UNM";
$sysconf['print']['membercard']['card_officials'] = "Prof. Dr. Jasruddin, M.Si.";
$sysconf['print']['membercard']['card_officials_id'] = "NIP. 19641222 199103 1 002";
$sysconf['print']['membercard']['card_stamp_left'] = -10;
$sysconf['print']['membercard']['card_stamp_top'] = 15;
$sysconf['print']['membercard']['card_stamp_width'] = 40;
$sysconf['print']['membercard']['card_stamp_height'] = 40;
$sysconf['print']['membercard']['card_signature_left'] = 0;
$sysconf['print']['membercard']['card_signature_top'] = 20;
$sysconf['print']['membercard']['card_signature_width'] = 107;
$sysconf['print']['membercard']['card_signature_height'] = 25;
$sysconf['print']['membercard']['label_nameI'] = "I";
// Logo Setting  OK
$sysconf['print']['membercard']['card_logo_width'] = 38;
$sysconf['print']['membercard']['card_height'] = 38;
$sysconf['print']['membercard']['card_left'] = 14;
$sysconf['print']['membercard']['card_top'] = 5;
$sysconf['print']['membercard']['label_nameR'] = "R";

// Cardbox Settings, measurement in cm OK
$sysconf['print']['membercard']['card_box_width'] = 8.6;
$sysconf['print']['membercard']['card_box_height'] = 5.4;
$sysconf['print']['membercard']['card_right_margin'] = 10;
$sysconf['print']['membercard']['card_bottom_margin'] = 5;
$sysconf['print']['membercard']['card_items_per_row'] = 1;
$sysconf['print']['membercard']['label_nameM'] = "M";
// Photo Settings OK
$sysconf['print']['membercard']['card_photo_height'] = 2.9;
$sysconf['print']['membercard']['card_photo_width'] = 2.3;
$sysconf['print']['membercard']['card_photo_left'] = 6;
$sysconf['print']['membercard']['card_photo_top'] = 55;
$sysconf['print']['membercard']['label_nameN'] = "N";
// Biodata settings OK
$sysconf['print']['membercard']['card_bio_font_weight'] = "bold";
$sysconf['print']['membercard']['card_bio_font_size'] = 12;
$sysconf['print']['membercard']['card_bio_top'] = 55; //55-100
$sysconf['print']['membercard']['label_nameZ'] = "Z";
// Expired OK
$sysconf['print']['membercard']['card_exp_font_size'] = 9;
$sysconf['print']['membercard']['card_exp_left'] = 10;
$sysconf['print']['membercard']['card_exp_top'] = 188;
$sysconf['print']['membercard']['card_exp_width'] = 135;
$sysconf['print']['membercard']['card_exp_height'] = 12;
// Barcode Setting OK
$sysconf['print']['membercard']['card_barcode_scale'] = 100; // barcode scale in percent relative to box width and height
$sysconf['print']['membercard']['card_barcode_height'] = 35;
$sysconf['print']['membercard']['card_barcode_width'] = 160;
$sysconf['print']['membercard']['card_barcode_left'] = 150;
$sysconf['print']['membercard']['card_barcode_top'] = 165; //150-180
// testing
$sysconf['print']['membercard']['label_name'] = "";
$sysconf['print']['membercard']['label_desc'] = "";
$sysconf['print']['membercard']['label_image'] = "label-multimedia.png";
$sysconf['print']['membercard']['image'] = "frontcard_Standard.jpg";
$sysconf['print']['membercard']['front_card_bg'] = "frontcard_Standard.jpg";
$sysconf['print']['membercard']['library_name'] = "hadi perpus";
$sysconf['print']['membercard']['notes'] = "nota";
$sysconf['print']['membercard']['opac_hide'] = 0;
$sysconf['print']['membercard']['quick_return'] = 0;
$sysconf['print']['membercard']['page_hadi'] = "hadi";
$sysconf['print']['membercard']['theme'] = "default";
