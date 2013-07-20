ALTER TABLE `#__atlete` 
ADD COLUMN `group_reference_id` VARCHAR(200) NULL COMMENT 'ID of group reference'  AFTER `removed` 
, ADD INDEX `group_reference_id` (`group_reference_id` ASC)
;