CREATE TABLE `nw202101`.`intentospagos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cliente` VARCHAR(128) NULL,
  `monto` DECIMAL(13,2) NULL,
  `fecha_vencimiento` DATE NULL,
  `estado` ENUM('PGD', 'CNL', 'ERR') NULL,
  PRIMARY KEY (`id`));
