-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema autocare
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema autocare
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `autocare` DEFAULT CHARACTER SET utf8mb3 ;
USE `autocare` ;

-- -----------------------------------------------------
-- Table `autocare`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `autocare`.`usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(50) NOT NULL,
  `sobrenome` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `telefone` VARCHAR(11) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `tipo` VARCHAR(20) NOT NULL,
  `id_prestador` INT,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE,
    INDEX `fk_id_prestador_usuario_idx` (`id_prestador` ASC) VISIBLE,
  CONSTRAINT `fk_id_prestador_usuario`
    FOREIGN KEY (`id_prestador`)
    REFERENCES `autocare`.`prestador` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;

-- -----------------------------------------------------
-- Table `autocare`.`prestador`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `autocare`.`prestador` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `apelido` VARCHAR(45) NOT NULL,
  `endereco_cep` VARCHAR(8) NULL DEFAULT NULL,
  `endereco_numero` INT NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `autocare`.`fabricante_veiculo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `autocare`.`fabricante_veiculo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `autocare`.`modelo_veiculo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `autocare`.`modelo_veiculo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `id_fabricante_veiculo` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_id_fabricante_idx` (`id_fabricante_veiculo` ASC) VISIBLE,
  CONSTRAINT `fk_id_fabricante`
    FOREIGN KEY (`id_fabricante_veiculo`)
    REFERENCES `autocare`.`fabricante_veiculo` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `autocare`.`veiculo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `autocare`.`veiculo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `ano` INT NOT NULL,
  `apelido` VARCHAR(45) NOT NULL,
  `id_usuario` INT NOT NULL,
  `id_modelo_veiculo` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_usuario_veiculo_idx` (`id_usuario` ASC) VISIBLE,
  INDEX `fk_modelo_veiculo_idx` (`id_modelo_veiculo` ASC) VISIBLE,
  CONSTRAINT `fk_modelo_veiculo`
    FOREIGN KEY (`id_modelo_veiculo`)
    REFERENCES `autocare`.`modelo_veiculo` (`id`),
  CONSTRAINT `fk_usuario_veiculo`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `autocare`.`usuario` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `autocare`.`servico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `autocare`.`servico` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NOT NULL,
  `data` DATE NOT NULL,
  `id_usuario` INT NOT NULL,
  `id_prestador` INT NOT NULL,
  `id_veiculo` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_id_usuario_idx` (`id_usuario` ASC) VISIBLE,
  INDEX `fk_id_prestador_idx` (`id_prestador` ASC) VISIBLE,
  INDEX `fk_id_veiculo_servico_idx` (`id_veiculo` ASC) VISIBLE,
  CONSTRAINT `fk_id_prestador_servico`
    FOREIGN KEY (`id_prestador`)
    REFERENCES `autocare`.`prestador` (`id`),
  CONSTRAINT `fk_id_usuario_servico`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `autocare`.`usuario` (`id`),
  CONSTRAINT `fk_id_veiculo_servico`
    FOREIGN KEY (`id_veiculo`)
    REFERENCES `autocare`.`veiculo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `autocare`.`avaliacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `autocare`.`avaliacao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_usuario` INT NOT NULL,
  `id_servico` INT NOT NULL,
  `nota` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_id_usuario_idx` (`id_usuario` ASC) VISIBLE,
  INDEX `fk_id_servico_idx` (`id_servico` ASC) VISIBLE,
  CONSTRAINT `fk_id_servico_avaliacao`
    FOREIGN KEY (`id_servico`)
    REFERENCES `autocare`.`servico` (`id`),
  CONSTRAINT `fk_id_usuario_avaliacao`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `autocare`.`usuario` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `autocare`.`funcionario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `autocare`.`funcionario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL DEFAULT NULL,
  `sobrenome` VARCHAR(45) NULL DEFAULT NULL,
  `email` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(45) NOT NULL,
  `id_empresa` INT NULL DEFAULT NULL,
  `administrador` TINYINT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE,
  UNIQUE INDEX `id_empresa_UNIQUE` (`id_empresa` ASC) VISIBLE,
  CONSTRAINT `fk_id_prestador`
    FOREIGN KEY (`id_empresa`)
    REFERENCES `autocare`.`prestador` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `autocare`.`chat`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `autocare`.`chat` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_usuario` INT NOT NULL,
  `id_prestador` INT NULL DEFAULT NULL,
  `id_funcionario` INT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_id_usuario_idx` (`id_usuario` ASC) VISIBLE,
  INDEX `fk_id_prestador_idx` (`id_prestador` ASC) VISIBLE,
  INDEX `fk_id_funcionario_idx` (`id_funcionario` ASC) VISIBLE,
  CONSTRAINT `fk_id_funcionario_chat`
    FOREIGN KEY (`id_funcionario`)
    REFERENCES `autocare`.`funcionario` (`id`),
  CONSTRAINT `fk_id_prestador_chat`
    FOREIGN KEY (`id_prestador`)
    REFERENCES `autocare`.`prestador` (`id`),
  CONSTRAINT `fk_id_usuario_chat`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `autocare`.`usuario` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `autocare`.`comentario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `autocare`.`comentario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_usuario` INT NOT NULL,
  `id_servico` INT NOT NULL,
  `texto` VARCHAR(400) NOT NULL,
  `data` DATE NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_id_usuario_idx` (`id_usuario` ASC) VISIBLE,
  INDEX `fk_id_servico_idx` (`id_servico` ASC) VISIBLE,
  CONSTRAINT `fk_id_servico`
    FOREIGN KEY (`id_servico`)
    REFERENCES `autocare`.`servico` (`id`),
  CONSTRAINT `fk_id_usuario`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `autocare`.`usuario` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `autocare`.`especialidade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `autocare`.`especialidade` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome_especialidade` VARCHAR(45) NOT NULL,
  `id_fabricante_veiculo_especialidade` INT NULL DEFAULT NULL,
  `id_modelo_veiculo` INT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_fabricante_veiculo_idx` (`id_fabricante_veiculo_especialidade` ASC) VISIBLE,
  INDEX `fk_modelo_veiculo_idx` (`id_modelo_veiculo` ASC) VISIBLE,
  CONSTRAINT `fk_fabricante_veiculo_especialidade`
    FOREIGN KEY (`id_fabricante_veiculo_especialidade`)
    REFERENCES `autocare`.`fabricante_veiculo` (`id`),
  CONSTRAINT `fk_modelo_veiculo_especialidade`
    FOREIGN KEY (`id_modelo_veiculo`)
    REFERENCES `autocare`.`modelo_veiculo` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `autocare`.`localizacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `autocare`.`localizacao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `latitude` DECIMAL(10,0) NOT NULL,
  `longitude` DECIMAL(10,0) NOT NULL,
  `id_prestador` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_prestador_idx` (`id_prestador` ASC) VISIBLE,
  CONSTRAINT `fk_prestador_localizacao`
    FOREIGN KEY (`id_prestador`)
    REFERENCES `autocare`.`prestador` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `autocare`.`mensagem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `autocare`.`mensagem` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `texto` VARCHAR(400) NOT NULL,
  `data` DATE NOT NULL,
  `cliente` TINYINT NOT NULL,
  `id_chat` INT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_id_chat_idx` (`id_chat` ASC) VISIBLE,
  CONSTRAINT `fk_id_chat`
    FOREIGN KEY (`id_chat`)
    REFERENCES `autocare`.`chat` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `autocare`.`prestador_especialidade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `autocare`.`prestador_especialidade` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_prestador` INT NOT NULL,
  `id_especialidade` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_prestador_idx` (`id_prestador` ASC) VISIBLE,
  INDEX `fk_especialidade_idx` (`id_especialidade` ASC) VISIBLE,
  CONSTRAINT `fk_especialidade`
    FOREIGN KEY (`id_especialidade`)
    REFERENCES `autocare`.`especialidade` (`id`),
  CONSTRAINT `fk_prestador`
    FOREIGN KEY (`id_prestador`)
    REFERENCES `autocare`.`prestador` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
