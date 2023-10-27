CREATE TABLE IF NOT EXISTS `hotel_maravillas`.`Categorias` (
  `categoria_habitacion_id` INT NOT NULL AUTO_INCREMENT,
  `nombre_categoria` VARCHAR(45) NOT NULL,
  `precio_categoria` DOUBLE NOT NULL,
  `Descripcion_categoria` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`categoria_habitacion_id`))
ENGINE = InnoDB

CREATE TABLE IF NOT EXISTS `hotel_maravillas`.`Disponibilidades` (
  `disponibilidad_id` INT NOT NULL AUTO_INCREMENT,
  `nombre_disponbilidad` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`disponibilidad_id`))
ENGINE = InnoDB

CREATE TABLE IF NOT EXISTS `hotel_maravillas`.`Hoteles` (
  `hotel_id` INT NOT NULL AUTO_INCREMENT,
  `nombre_hotel` VARCHAR(100) NOT NULL,
  `direccion_hotel` VARCHAR(255) NOT NULL,
  `telefono` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`hotel_id`))
ENGINE = InnoDB

CREATE TABLE IF NOT EXISTS `hotel_maravillas`.`Habitaciones` (
  `habitacion_id` INT NOT NULL AUTO_INCREMENT,
  `precio_habitacion` DOUBLE NOT NULL,
  PRIMARY KEY (`habitacion_id`))
ENGINE = InnoDB


CREATE TABLE IF NOT EXISTS `hotel_maravillas`.`Metodos_de_Pago` (
  `metodo_pago_id` INT NOT NULL AUTO_INCREMENT,
  `nombre_metodo_pago` VARCHAR(45) NOT NULL,
  `Descripcion_metodo_pago` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`metodo_pago_id`))
ENGINE = InnoDB

CREATE TABLE IF NOT EXISTS `hotel_maravillas`.`Pagos` (
  `pago_id` INT NOT NULL AUTO_INCREMENT,
  `monto` DOUBLE NOT NULL,
  `fecha_pago` DATE NOT NULL,
  PRIMARY KEY (`pago_id`))
ENGINE = InnoDB

CREATE TABLE IF NOT EXISTS `hotel_maravillas`.`Reservas` (
  `reserva_id` INT NOT NULL AUTO_INCREMENT,
  `fecha_inicio` DATE NOT NULL,
  `fecha_fin` DATE NOT NULL,
  PRIMARY KEY (`reserva_id`))
ENGINE = InnoDB

CREATE TABLE IF NOT EXISTS `hotel_maravillas`.`Clientes` (
`cliente_id` INT NOT NULL AUTO_INCREMENT,
`nombre_cliente` VARCHAR(45) NOT NULL,
`cedula_cliente` VARCHAR(45) NOT NULL,
`email_cliente` VARCHAR(45) NOT NULL,
`telefono_cliente` VARCHAR(45) NOT NULL,
PRIMARY KEY (`cliente_id`))
ENGINE = InnoDB
-- 
-- 
-- 
ALTER TABLE Habitaciones
ADD CONSTRAINT fk_habitaciones_hoteles
FOREIGN KEY (hotel_id)
REFERENCES Hoteles(hotel_id);

ALTER TABLE Habitaciones
ADD CONSTRAINT fk_habitaciones_disponibilidades
FOREIGN KEY (disponibilidad_id)
REFERENCES Disponibilidades(disponibilidad_id);

ALTER TABLE Habitaciones
ADD CONSTRAINT fk_habitaciones_categoria_habitacion
FOREIGN KEY (categoria_habitacion_id)
REFERENCES Categorias(categoria_habitacion_id);


ALTER TABLE Reservas
ADD CONSTRAINT fk_reservas_hoteles
FOREIGN KEY (hotel_id)
REFERENCES Hoteles(hotel_id);

ALTER TABLE Reservas
ADD CONSTRAINT fk_reservas_habitaciones
FOREIGN KEY (habitacion_id)
REFERENCES Habitaciones(habitacion_id);

ALTER TABLE Reservas
ADD CONSTRAINT fk_reservas_clientes
FOREIGN KEY (cliente_id)
REFERENCES Clientes(cliente_id);