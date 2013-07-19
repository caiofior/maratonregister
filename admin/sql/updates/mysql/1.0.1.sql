ALTER TABLE `#__atlete` 
ADD COLUMN `group_reference_id` VARCHAR(200) NULL COMMENT 'ID of group reference'  AFTER `removed` 
, ADD INDEX `group_reference_id` (`group_reference_id` ASC)
, ADD CONSTRAINT `fk_group_reference_id`
  FOREIGN KEY (`group_reference_id` )
  REFERENCES `#__atlete` (`id` )
  ON DELETE SET NULL
  ON UPDATE CASCADE;