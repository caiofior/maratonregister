ALTER TABLE `#__atlete` 
ADD COLUMN `group_reference_id` INT(11) NULL DEFAULT NULL COMMENT 'ID of group reference' AFTER `removed` 
, ADD INDEX `group_reference_id` (`group_reference_id` ASC)
;