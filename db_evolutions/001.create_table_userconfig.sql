CREATE TABLE `user_config` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `user_id` INT(10) NOT NULL,
  `config_type` VARCHAR(50) NOT NULL,
  `value` VARCHAR(50) NOT NULL,
  `updaded_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `user_id_config_type` (`user_id`, `config_type`)
)
COLLATE='utf8_bin'
ENGINE=InnoDB;
