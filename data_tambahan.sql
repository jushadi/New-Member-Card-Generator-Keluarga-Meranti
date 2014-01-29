-- Jus hadi A rman S az
INSERT INTO `setting` (`setting_id`, `setting_name`, `setting_value`) VALUES
-- Jushadi  Arman  Saz
(NULL, 'barcode_print_settings', ''),
-- Jusha di Arm an S az
(NULL, 'label_print_settings', ''),
-- Jush adi Ar man S az
(NULL, 'membercard_print_settings', '');
ALTER TABLE `mst_member_type` ADD `card_stamp` VARCHAR( 50 ) COLLATE utf8_unicode_ci NULL AFTER `last_update` ;
-- Jus hadi Ar man Saz
ALTER TABLE `mst_member_type` ADD `card_signature` VARCHAR( 50 ) COLLATE utf8_unicode_ci NULL AFTER `last_update` ;-- Jushadi Arman Saz
ALTER TABLE `mst_member_type` ADD `card_logo` VARCHAR( 50 ) COLLATE utf8_unicode_ci NULL AFTER `last_update` ;
-- J us hadi Arman  Saz
ALTER TABLE `mst_member_type` ADD `rear_card_bg` VARCHAR( 50 ) COLLATE utf8_unicode_ci NULL AFTER `last_update` ;-- Jushadi Arman Saz
ALTER TABLE `mst_member_type` ADD `front_card_bg` VARCHAR( 50 ) COLLATE utf8_unicode_ci NULL AFTER `last_update` ;
-- Jusha di Ar man Saz


UPDATE `mst_member_type` SET `front_card_bg` = 'Frontcard_Standard', `rear_card_bg` = 'Rearcard_Standard', `card_logo` = 'Logo_Standard', `card_signature` = 'Signature_Standard', `card_stamp` = 'Stamp_Standard' WHERE  `mst_member_type`.`member_type_id` = 1;
-- Jush adi Arman Saz
