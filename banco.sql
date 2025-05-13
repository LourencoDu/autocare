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
  `sobrenome` VARCHAR(45),
  `email` VARCHAR(45) NOT NULL,
  `telefone` VARCHAR(11) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `tipo` ENUM("usuario", "prestador", "funcionario", "moderador", "administrador") NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;

-- -----------------------------------------------------
-- Table `autocare`.`prestador`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `autocare`.`prestador` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `documento` VARCHAR(255) NOT NULL,
  `id_usuario` INT NOT NULL,
  PRIMARY KEY (`id`),
	INDEX `fk_prestador_usuario_idx` (`id_usuario` ASC) VISIBLE,
  CONSTRAINT `fk_prestador_usuario`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `autocare`.`usuario` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `autocare`.`funcionario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `autocare`.`funcionario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `administrador` TINYINT NULL DEFAULT NULL,
  `id_prestador` INT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_id_prestador_funcionario` (`id_prestador` ASC) VISIBLE,
  CONSTRAINT `fk_id_prestador_funcionario`
    FOREIGN KEY (`id_prestador`)
    REFERENCES `autocare`.`prestador` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


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
  `id_prestador` INT NULL DEFAULT NULL,
  `id_funcionario` INT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE,
  INDEX `fk_id_prestador_usuario_idx` (`id_prestador` ASC) VISIBLE,
  INDEX `fk_id_funcionario_usuario` (`id_funcionario` ASC) VISIBLE,
  CONSTRAINT `fk_id_funcionario_usuario`
    FOREIGN KEY (`id_funcionario`)
    REFERENCES `autocare`.`funcionario` (`id`),
  CONSTRAINT `fk_id_prestador_usuario`
    FOREIGN KEY (`id_prestador`)
    REFERENCES `autocare`.`prestador` (`id`))
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
AUTO_INCREMENT = 20
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
AUTO_INCREMENT = 61
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
    REFERENCES `autocare`.`veiculo` (`id`))
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
  `administrador` TINYINT NULL DEFAULT NULL,
  `id_prestador` INT NULL DEFAULT NULL,
  `id_usuario` INT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_id_prestador_funcionario`
    FOREIGN KEY (`id_prestador`)
    REFERENCES `autocare`.`prestador` (`id`),
	CONSTRAINT `fk_funcionario_usuario`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `autocare`.`usuario` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `autocare`.`chat`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `autocare`.`chat` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_usuario` INT NOT NULL,
  `id_prestador` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_id_usuario_idx` (`id_usuario` ASC) VISIBLE,
  INDEX `fk_id_prestador_idx` (`id_prestador` ASC) VISIBLE,
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
  `id_fabricante_veiculo` INT NULL DEFAULT NULL,
  `id_modelo_veiculo` INT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_fabricante_veiculo_idx` (`id_fabricante_veiculo` ASC) VISIBLE,
  INDEX `fk_modelo_veiculo_idx` (`id_modelo_veiculo` ASC) VISIBLE,
  CONSTRAINT `fk_fabricante_veiculo`
    FOREIGN KEY (`id_fabricante_veiculo`)
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
  `remetente_tipo` ENUM('cliente', 'funcionario') NOT NULL,
  `id_usuario` INT NULL DEFAULT NULL,
  `id_funcionario` INT NULL DEFAULT NULL,
  `id_chat` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_id_chat_idx` (`id_chat` ASC) VISIBLE,
  INDEX `fk_id_usuario_chat_idx` (`id_usuario` ASC) VISIBLE,
  INDEX `fk_id_funcionario_chat_idx` (`id_funcionario` ASC) VISIBLE,
  CONSTRAINT `fk_id_chat`
    FOREIGN KEY (`id_chat`)
    REFERENCES `autocare`.`chat` (`id`),
  CONSTRAINT `fk_id_funcionario_mensagem`
    FOREIGN KEY (`id_funcionario`)
    REFERENCES `autocare`.`funcionario` (`id`),
  CONSTRAINT `fk_id_usuario_mensagem`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `autocare`.`usuario` (`id`))
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


INSERT INTO autocare.fabricante_veiculo (id, nome) VALUES
(1, 'Chevrolet'),
(2, 'Volkswagen'),
(3, 'Fiat'),
(4, 'Ford'),
(5, 'Toyota'),
(6, 'Hyundai'),
(7, 'Renault'),
(8, 'Honda'),
(9, 'Jeep'),
(10, 'Nissan'),
(11, 'BMW'),
(12, 'Audi'),
(13, 'Mercedes-Benz'),
(14, 'Peugeot'),
(15, 'Kia'),
(16, 'Yamaha'),
(17, 'Suzuki'),
(18, 'Harley-Davidson'),
(19, 'BMW'),
(20, 'Chery'),
(21, 'Mitsubishi'),
(22, 'Subaru'),
(23, 'Volvo'),
(24, 'Land Rover'),
(25, 'Porsche'),
(26, 'Lexus'),
(27, 'Dodge'),
(28, 'JAC Motors'),
(29, 'Triumph');

INSERT INTO autocare.modelo_veiculo (id, nome, id_fabricante_veiculo) VALUES
(121, 'Bolt EV', 1),
(2, 'Cruze', 1),
(92, 'Montana', 1),
(1, 'Onix', 1),
(3, 'S10', 1),
(91, 'Spin', 1),
(122, 'Tracker', 1),
(124, 'Amarok', 2),
(4, 'Gol', 2),
(93, 'Nivus', 2),
(5, 'Polo', 2),
(123, 'Saveiro', 2),
(6, 'T-Cross', 2),
(94, 'Virtus', 2),
(7, 'Argo', 3),
(96, 'Fastback', 3),
(95, 'Mobi', 3),
(8, 'Pulse', 3),
(125, 'Strada', 3),
(9, 'Toro', 3),
(126, 'Uno', 3),
(128, 'Bronco Sport', 4),
(11, 'EcoSport', 4),
(98, 'Edge', 4),
(97, 'Fiesta', 4),
(10, 'Ka', 4),
(127, 'Maverick', 4),
(12, 'Ranger', 4),
(13, 'Corolla', 5),
(100, 'Corolla Cross', 5),
(129, 'Etios', 5),
(15, 'Hilux', 5),
(130, 'Prius', 5),
(99, 'SW4', 5),
(14, 'Yaris', 5),
(132, 'Azera', 6),
(17, 'Creta', 6),
(16, 'HB20', 6),
(131, 'Ioniq 5', 6),
(101, 'Santa Fe', 6),
(18, 'Tucson', 6),
(102, 'i30', 6),
(21, 'Captur', 7),
(20, 'Duster', 7),
(19, 'Kwid', 7),
(104, 'Logan', 7),
(103, 'Sandero', 7),
(133, 'Stepway', 7),
(134, 'Trafic', 7),
(47, 'CB 500F', 8),
(46, 'CG 160', 8),
(23, 'City', 8),
(22, 'Civic', 8),
(106, 'Fit', 8),
(24, 'HR-V', 8),
(136, 'Integra', 8),
(105, 'WR-V', 8),
(48, 'XRE 300', 8),
(135, 'ZRV', 8),
(137, 'Avenger', 9),
(138, 'Cherokee', 9),
(27, 'Commander', 9),
(26, 'Compass', 9),
(107, 'Compass 4xe', 9),
(108, 'Grand Cherokee', 9),
(25, 'Renegade', 9),
(109, 'Frontier', 10),
(29, 'Kicks', 10),
(139, 'Leaf', 10),
(110, 'March', 10),
(30, 'Sentra', 10),
(28, 'Versa', 10),
(140, 'X-Trail', 10),
(31, '320i', 11),
(112, 'M3', 11),
(32, 'X1', 11),
(33, 'X5', 11),
(111, 'X6', 11),
(142, 'Z4', 11),
(141, 'iX3', 11),
(34, 'A3', 12),
(113, 'A4', 12),
(35, 'Q3', 12),
(36, 'Q5', 12),
(114, 'Q7', 12),
(143, 'RS Q3', 12),
(144, 'e-tron GT', 12),
(39, 'C 180', 13),
(116, 'CLS 450', 13),
(37, 'Classe A', 13),
(146, 'EQC', 13),
(38, 'GLA 200', 13),
(145, 'GLB 200', 13),
(115, 'GLC 200', 13),
(41, '2008', 14),
(40, '208', 14),
(42, '3008', 14),
(147, '3008 GT', 14),
(117, '408', 14),
(148, '408 GT', 14),
(118, '5008', 14),
(44, 'Cerato', 15),
(150, 'EV6', 15),
(149, 'Mohave', 15),
(119, 'Picanto', 15),
(120, 'Seltos', 15),
(43, 'Sportage', 15),
(45, 'Stonic', 15),
(49, 'Fazer 250', 16),
(51, 'Lander 250', 16),
(50, 'MT-03', 16),
(54, 'Burgman 125i', 17),
(52, 'GSX-R1000', 17),
(53, 'V-Strom 650', 17),
(57, 'Fat Boy 114', 18),
(55, 'Iron 883', 18),
(56, 'Street Glide', 18),
(59, 'F 850 GS', 19),
(58, 'G 310 R', 19),
(60, 'R 1250 GS', 19),
(63, 'Arrizo 6', 20),
(61, 'Tiggo 5X', 20),
(62, 'Tiggo 8', 20),
(151, 'ASX', 21),
(158, 'Eclipse', 21),
(66, 'Eclipse Cross', 21),
(159, 'Galant', 21),
(64, 'L200 Triton', 21),
(155, 'Lancer', 21),
(156, 'Lancer Evolution X', 21),
(65, 'Outlander', 21),
(157, 'Outlander Sport', 21),
(152, 'Pajero Full', 21),
(153, 'Pajero Sport', 21),
(154, 'Pajero TR4', 21),
(160, 'Space Star', 21),
(68, 'Forester', 22),
(67, 'Impreza', 22),
(69, 'XV', 22),
(72, 'S90', 23),
(70, 'XC40', 23),
(71, 'XC60', 23),
(75, 'Defender', 24),
(74, 'Discovery Sport', 24),
(73, 'Range Rover Evoque', 24),
(77, '911 Carrera', 25),
(76, 'Cayenne', 25),
(78, 'Macan', 25),
(80, 'NX 350h', 26),
(81, 'RX 500h', 26),
(79, 'UX 250h', 26),
(83, 'Challenger', 27),
(82, 'Durango', 27),
(84, 'RAM 1500', 27),
(86, 'E-JS1', 28),
(85, 'T40', 28),
(87, 'T60', 28),
(90, 'Rocket 3 R', 29),
(88, 'Street Twin', 29),
(89, 'Tiger 900', 29);
