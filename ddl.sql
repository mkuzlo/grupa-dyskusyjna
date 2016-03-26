SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Utworzenie bazy danych
-- -----------------------------------------------------
CREATE DATABASE IF NOT EXISTS grupa DEFAULT  CHARACTER SET utf8 COLLATE utf8_unicode_ci;
use grupa;

-- -----------------------------------------------------
-- Table `USERS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `USERS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(30) NOT NULL,
  `password` VARCHAR(40) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `GROUPS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GROUPS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(30) NOT NULL,
  `description` VARCHAR(200),
  `type` VARCHAR(10) NOT NULL, 
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `USER_GROUPS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `USER_GROUPS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user` INT NOT NULL,
  `group` INT NOT NULL,
  `role` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `POSTS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `POSTS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user` INT NOT NULL,
  `group` INT NOT NULL,
  `message` VARCHAR(2000),
  `image` VARCHAR(30),
  `date` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;