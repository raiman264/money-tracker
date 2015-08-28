USE `money_tracker`;

ALTER TABLE `money_tracker`.`data` 
ADD COLUMN `inserted_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `date`;