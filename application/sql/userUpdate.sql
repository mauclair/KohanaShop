DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
`user_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`shopper_group_id` INT NOT NULL,
`username` VARCHAR( 255 ) NOT NULL ,
`email` VARCHAR( 255 ) NOT NULL ,
`level` INT NOT NULL ,
`npwd` VARCHAR( 32 ) NOT NULL ,
`password` VARCHAR( 32 ) NOT NULL ,
`LPToken` VARCHAR( 32 ) NOT NULL ,
`new_password` VARCHAR( 32 ) NOT NULL,
`old_user_id` VARCHAR( 32 ) NOT NULL
) ENGINE = MYISAM ;


INSERT INTO `user` (shopper_group_id,username,email,`level`,npwd,password,old_user_id)
SELECT shopper_group_id,username, user_email, IF( perms = 'admin', 0, IF( perms = 'storeadmin', 100, 255 ) ) AS `level`,
       MD5( concat( 'Bylinky_*/-9090',username,password ) ) ,password,user_id
FROM auth_user_md5
JOIN user_info USING ( user_id )
JOIN shopper_vendor_xref USING ( user_id )
WHERE address_type = 'BT';

DROP TABLE IF EXISTS shopper_vendor_xref;


ALTER TABLE `user_info` DROP INDEX `user_id`;
UPDATE user_info SET user_id = (SELECT user_id FROM user WHERE old_user_id = user_info.user_id);
ALTER TABLE `user_info` CHANGE `user_id` `user_id` INT NOT NULL;
ALTER TABLE `user_info` ADD INDEX ( `user_id` );
ALTER TABLE `user_info` ADD `name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL AFTER `address_type`;
ALTER TABLE `user_info` CHANGE `user_info_id` `user_info_id` INT(11) NOT NULL AUTO_INCREMENT, CHANGE `user_id` `user_id` INT(11) NOT NULL, CHANGE `address_type` `address_type` VARCHAR(2) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL, CHANGE `name` `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL, CHANGE `address_type_name` `address_type_name` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL, CHANGE `company` `company` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL, CHANGE `title` `title` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL, CHANGE `last_name` `last_name` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL, CHANGE `first_name` `first_name` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL, CHANGE `middle_name` `middle_name` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL, CHANGE `phone_1` `phone_1` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL;
UPDATE `user_info` SET `name` = CONCAT(first_name,' ',middle_name,' ',last_name);
ALTER TABLE `user_info` DROP `last_name` ,DROP `first_name` ,DROP `middle_name`, DROP phone_2, 
                        drop title, drop address_type_name, drop `state`, DROP `cdate` ,
                        DROP `mdate`, DROP `extra_field_1` , DROP `extra_field_2` , DROP `extra_field_3` ,
                        DROP `extra_field_4`, DROP `extra_field_5`;

ALTER TABLE `orders` DROP INDEX `user_id`;
UPDATE orders SET user_id = (SELECT user_id FROM user WHERE old_user_id = orders.user_id LIMIT 1);
ALTER TABLE `orders` CHANGE `user_id` `user_id` INT NOT NULL;
ALTER TABLE `orders` ADD INDEX ( `user_id` );



CREATE TABLE `log_login` (
`user_id` INT NOT NULL ,
`login_date` DATETIME NOT NULL ,
`ip` VARCHAR( 64 ) NOT NULL ,
`location` VARCHAR( 64 ) NOT NULL ,
`useragent` INT NOT NULL
) ENGINE = MYISAM ;

ALTER TABLE `indikace` CHANGE `indikace_cze` `indikace_name` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL;
ALTER TABLE `indikace` CHANGE `indikace_sk` `indikace_url` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL;
ALTER TABLE `indikace_joined` CHANGE `i_refs_cze` `i_refs` TEXT CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL, `indikace_joined` DROP `i_refs_sk`;


ALTER TABLE `clanky` ADD `clanky_url` VARCHAR( 255 ) NOT NULL AFTER `title`;

DROP TABLE `auth_user_md5`;

ALTER TABLE `payment_method`  DROP `vendor_id`,  DROP `list_order`,  DROP `payment_method_code`,  DROP `enable_processor`;
ALTER TABLE `payment_method` CHANGE `payment_method_discount` `payment_cost` DECIMAL( 10, 2 );


ALTER TABLE `vendor`  DROP `contact_last_name`,  DROP `contact_first_name`,  DROP `contact_middle_name`,  DROP `contact_title`,  DROP `contact_phone_1`,  DROP `contact_phone_2`,  DROP `contact_fax`,  DROP `contact_email`,  DROP `vendor_phone`,  DROP `vendor_address_1`,  DROP `vendor_address_2`,  DROP `vendor_city`,  DROP `vendor_state`,  DROP `vendor_country`,  DROP `vendor_zip`,  DROP `vendor_store_name`,  DROP `vendor_store_desc`,  DROP `vendor_category_id`,  DROP `vendor_thumb_image`,  DROP `vendor_full_image`,  DROP `vendor_currency`,  DROP `cdate`,  DROP `mdate`,  DROP `vendor_image_path`
 ADD `vendor_url` VARCHAR( 255 ) NOT NULL , ADD `vendor_desc` TEXT NOT NULL;

ALTER TABLE `orders`  DROP `vendor_id`,  CHANGE `user_info_id` `billing_adddress_id` INT( 11 ) NULL DEFAULT NULL ,
CHANGE `ship_method_id` `shipping_id` INT( 11 ) NULL DEFAULT NULL;

ALTER TABLE `order_item`  DROP `user_info_id`,  DROP `vendor_id`, DROP cdate, DROP mdate, DROP `order_item_currency` , DROP `order_status`, ADD `product_price_id` INT NOT NULL  ;


