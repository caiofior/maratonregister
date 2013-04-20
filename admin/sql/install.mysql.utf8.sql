CREATE TABLE  IF NOT EXISTS `#__atlete` (
  `id` VARCHAR(200) NOT NULL COMMENT 'Id' ,
  `first_name` VARCHAR(50) NULL COMMENT 'First name' ,
  `last_name` VARCHAR(50) NULL COMMENT 'Last name' ,
  `date_of_birth` DATE NULL COMMENT 'Date of birth' ,
  `num_tes` VARCHAR(8) NULL COMMENT 'Fidal id' ,
  `num_tes_datetime_confirmed` datetime DEFAULT NULL COMMENT 'Fidal confirmation datetime',
  `sex` VARCHAR(1) NULL ,
  `citizenship` VARCHAR(50) NULL COMMENT 'Citizenship' ,
  `address` VARCHAR(50) NULL COMMENT 'Address' ,
  `zip` VARCHAR(5) NULL COMMENT 'Zip' ,
  `city` VARCHAR(50) NULL COMMENT 'City' ,
  `phone` VARCHAR(50) NULL COMMENT 'Phone' ,
  `email` VARCHAR(50) NULL COMMENT 'Email' ,
  `other_num_tes` VARCHAR(20) NULL COMMENT 'Other federation number',
  `other_ass_name` VARCHAR(50) NULL COMMENT 'Other federation name',
  `registration_datetime` DATETIME NULL COMMENT 'Regsitration date time',
  `payment_type` ENUM('bank_transfer','money_order','paypal') NULL COMMENT 'Payment type' ,
  `payment_datetime` DATETIME NULL COMMENT 'Payment datetime, in null not sucesfull' ,
  `payment_fname` varchar(50) DEFAULT NULL COMMENT 'Payment file name',
  `payment_confirm_datetime` DATETIME NULL COMMENT 'Payment confirm date time, in null not confirmed' ,
  `medical_certificate_fname` VARCHAR(50) NULL COMMENT 'Medical certificate file name' ,
  `medical_certificate_datetime` DATETIME NULL COMMENT 'Medical certificate date time' ,
  `medical_certificate_confirm_datetime` DATETIME NULL COMMENT 'Medical certificate confirm date time, if null not confirmed' ,
  `pectoral` INT NULL COMMENT 'Pectoral number' ,
  `removed` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Removed items' ,
  PRIMARY KEY (`id`, `removed`) COMMENT 'Id must be unique',
  INDEX `first_name` (`first_name` ASC) ,
  INDEX `last_name` (`last_name` ASC) ,
  INDEX `date_of_birt` (`date_of_birth` ASC) ,
  INDEX `phone` (`phone` ASC) ,
  INDEX `email` (`email` ASC) ,
  INDEX `city` (`city` ASC),
  INDEX `num_tes` (`num_tes` ASC),
  INDEX `pectoral` (`pectoral` ASC)
)
ENGINE = InnoDB
COMMENT = 'Atlete table';

CREATE TABLE  IF NOT EXISTS`#__fidal_fella` (
  `num_tes` VARCHAR(8) NOT NULL COMMENT 'Card number',
  `categ` VARCHAR(4) NULL COMMENT 'Category',
  `cod_soc` VARCHAR(5) NULL COMMENT 'Code society',
  `denom` VARCHAR(50) NULL COMMENT 'Society name',
  `dat_mov` DATE NULL COMMENT 'Date',
  `cogn` VARCHAR(50) NULL COMMENT 'Last name',
  `nome` VARCHAR(50) NULL COMMENT 'First name',
  `dat_nas` DATE NULL COMMENT 'Date of birth',
  `stran` VARCHAR(1) NULL COMMENT 'Stranger',
  `cod_reg` VARCHAR(3) NULL COMMENT 'Region code',
  PRIMARY KEY (`num_tes`) ,
  KEY `nome` (`nome`),
  KEY `cogn` (`cogn`),
  KEY `dat_nas` (`dat_nas`)
)
ENGINE = InnoDB
COMMENT = 'Data of fidal fella';