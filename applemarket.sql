-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';


-- -----------------------------------------------------
-- Schema AppleMarket
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `AppleMarket` DEFAULT CHARACTER SET utf8 ;
USE `AppleMarket` ;

-- -----------------------------------------------------
-- Table `AppleMarket`.`userTbl`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AppleMarket`.`userTbl` (
  `idx` INT NOT NULL AUTO_INCREMENT,
  `id` VARCHAR(20) NOT NULL,
  `passwd` VARCHAR(30) NOT NULL,
  `email` VARCHAR(30) NOT NULL,
  `name` VARCHAR(15) NOT NULL,
  `sex` INT NOT NULL,
  `birth` DATE NOT NULL,
  PRIMARY KEY (`idx`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `AppleMarket`.`AddrTbl`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AppleMarket`.`AddrTbl` (
  `Idx` INT NOT NULL AUTO_INCREMENT,
  `Addr` INT NULL,
  `detail` VARCHAR(100) NULL,
  `userTbl_idx` INT NOT NULL,
  PRIMARY KEY (`Idx`),
  INDEX `fk_AddrTbl_userTbl1_idx` (`userTbl_idx` ASC),
  CONSTRAINT `fk_AddrTbl_userTbl1`
    FOREIGN KEY (`userTbl_idx`)
    REFERENCES `AppleMarket`.`userTbl` (`idx`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `AppleMarket`.`RegProductTbl`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AppleMarket`.`RegProductTbl` (
  `idx` INT NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(30) NOT NULL,
  `title` VARCHAR(30) NOT NULL,
  `AddrTbl_Idx` INT NOT NULL,
  `condition` VARCHAR(10) NOT NULL,
  `userTbl_idx` INT NOT NULL,
  `ageRange` INT NOT NULL,
  `price` INT NOT NULL,
  `exchange` VARCHAR(45) NOT NULL,
  `content` TEXT NULL,
  `tags` VARCHAR(45) NULL,
  `quantity` INT NULL,
  `view` INT NULL,
  `favorite` INT NULL,
  `regDate` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idx`),
  INDEX `fk_RegProductTbl_AddrTbl1_idx` (`AddrTbl_Idx`),
  INDEX `fk_RegProductTbl_userTbl1_idx` (`userTbl_idx`),
  CONSTRAINT `fk_RegProductTbl_AddrTbl1`
    FOREIGN KEY (`AddrTbl_Idx`)
    REFERENCES `AppleMarket`.`AddrTbl` (`Idx`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_RegProductTbl_userTbl1`
    FOREIGN KEY (`userTbl_idx`)
    REFERENCES `AppleMarket`.`userTbl` (`idx`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
) ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `AppleMarket`.`CategoryTbl`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AppleMarket`.`CategoryTbl` (
  `idx` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `RegProductTbl_idx1` INT NOT NULL,
  PRIMARY KEY (`idx`),
  INDEX `fk_CategoryTbl_RegProductTbl2_idx` (`RegProductTbl_idx1` ASC),
  CONSTRAINT `fk_CategoryTbl_RegProductTbl2`
    FOREIGN KEY (`RegProductTbl_idx1`)
    REFERENCES `AppleMarket`.`RegProductTbl` (`idx`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `AppleMarket`.`comment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AppleMarket`.`comment` (
  `idx` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(40) NOT NULL,
  `comment` TEXT NULL,
  `RegProductTbl_idx` INT NOT NULL,
  `userTbl_idx` INT NOT NULL,
  `commentDate` TIMESTAMP NULL,
  PRIMARY KEY (`idx`),
  INDEX `fk_comment_RegProductTbl1_idx` (`RegProductTbl_idx` ASC) ,
  INDEX `fk_comment_userTbl1_idx` (`userTbl_idx` ASC) ,
  CONSTRAINT `fk_comment_RegProductTbl1`
    FOREIGN KEY (`RegProductTbl_idx`)
    REFERENCES `AppleMarket`.`RegProductTbl` (`idx`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comment_userTbl1`
    FOREIGN KEY (`userTbl_idx`)
    REFERENCES `AppleMarket`.`userTbl` (`idx`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `AppleMarket`.`buyTBL`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AppleMarket`.`buyTBL` (
  `idx` INT NOT NULL AUTO_INCREMENT,
  `RegProductTbl_idx` INT NOT NULL,
  `method` INT NOT NULL,
  `buyDate` TIMESTAMP NOT NULL,
  `process` INT NOT NULL,
  PRIMARY KEY (`idx`),
  INDEX `fk_buyTBL_RegProductTbl1_idx` (`RegProductTbl_idx` ASC),
  CONSTRAINT `fk_buyTBL_RegProductTbl1`
    FOREIGN KEY (`RegProductTbl_idx`)
    REFERENCES `AppleMarket`.`RegProductTbl` (`idx`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `AppleMarket`.`basketTbl`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AppleMarket`.`basketTbl` (
  `idx` INT NOT NULL AUTO_INCREMENT,
  `userTbl_idx` INT NOT NULL,
  `product_num` INT NOT NULL,
  PRIMARY KEY (`idx`),
  INDEX `fk_basketTbl_userTbl1_idx` (`userTbl_idx` ASC),
  INDEX `fk_basketTbl_RegProductTbl1_idx` (`product_num` ASC),
  CONSTRAINT `fk_basketTbl_userTbl1`
    FOREIGN KEY (`userTbl_idx`)
    REFERENCES `AppleMarket`.`userTbl` (`idx`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_basketTbl_RegProductTbl1`
    FOREIGN KEY (`product_num`)
    REFERENCES `AppleMarket`.`RegProductTbl` (`idx`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `AppleMarket`.`chatTbl`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AppleMarket`.`chatTbl` (
  `idx` INT NOT NULL AUTO_INCREMENT,
  `userTbl_idx` INT NOT NULL,
  `chatDate` TIMESTAMP NOT NULL,
  `text` TINYTEXT NULL,
  PRIMARY KEY (`idx`),
  INDEX `fk_chatTbl_userTbl1_idx` (`userTbl_idx` ASC),
  CONSTRAINT `fk_chatTbl_userTbl1`
    FOREIGN KEY (`userTbl_idx`)
    REFERENCES `AppleMarket`.`userTbl` (`idx`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `AppleMarket`.`Scategorytbl`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AppleMarket`.`Scategorytbl` (
  `idx` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `CategoryTbl_idx` INT NOT NULL,
  `RegProductTbl_idx` INT NOT NULL,
  PRIMARY KEY (`idx`),
  INDEX `fk_Scategorytbl_CategoryTbl1_idx` (`CategoryTbl_idx`),
  INDEX `fk_Scategorytbl_RegProductTbl1_idx` (`RegProductTbl_idx`),
  CONSTRAINT `fk_Scategorytbl_CategoryTbl1`
    FOREIGN KEY (`CategoryTbl_idx`)
    REFERENCES `AppleMarket`.`CategoryTbl` (`idx`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Scategorytbl_RegProductTbl1`
    FOREIGN KEY (`RegProductTbl_idx`)
    REFERENCES `AppleMarket`.`RegProductTbl` (`idx`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
  
) ENGINE = InnoDB;



-- -----------------------------------------------------
-- Table `AppleMarket`.`filepathTbl`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AppleMarket`.`filepathTbl` (
  `idx` INT NOT NULL AUTO_INCREMENT,
  `path` VARCHAR(45) NULL,
  `RegProductTbl_idx` INT NOT NULL,
  PRIMARY KEY (`idx`),
  INDEX `fk_filepathTbl_RegProductTbl1_idx` (`RegProductTbl_idx` ASC),
  CONSTRAINT `fk_filepathTbl_RegProductTbl1`
    FOREIGN KEY (`RegProductTbl_idx`)
    REFERENCES `AppleMarket`.`RegProductTbl` (`idx`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
