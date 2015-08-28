USE `money_tracker`;

ALTER TABLE `data` 
ADD COLUMN `date_tmp` DATETIME NULL AFTER `date`;

UPDATE `data` SET `date_tmp` = `date` where `id` > 0;

ALTER TABLE `data` 
CHANGE COLUMN `date` `date` INT NULL DEFAULT NULL ;

UPDATE `data` SET `date` = UNIX_TIMESTAMP(`date_tmp`) where `id` > 0;

ALTER TABLE `data` 
DROP COLUMN `date_tmp`;


