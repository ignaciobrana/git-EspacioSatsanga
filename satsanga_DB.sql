-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.18 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.3.0.5771
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para satsanga_dev
CREATE DATABASE IF NOT EXISTS `satsanga_dev` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `satsanga_dev`;

-- Volcando estructura para tabla satsanga_dev.adelanto
CREATE TABLE IF NOT EXISTS `adelanto` (
  `idAdelanto` int(11) NOT NULL AUTO_INCREMENT,
  `idMovimientoCajaChica` int(11) DEFAULT NULL,
  `idEmpleado` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `idCajaGrande` int(11) DEFAULT NULL,
  PRIMARY KEY (`idAdelanto`),
  KEY `IX_cajagrande_adelanto` (`idCajaGrande`),
  KEY `IX_movimientocajachica_adelanto` (`idMovimientoCajaChica`),
  KEY `IX_empleado_adelanto` (`idEmpleado`),
  CONSTRAINT `FK_empleado_adelanto` FOREIGN KEY (`idEmpleado`) REFERENCES `empleado` (`idEmpleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla satsanga_dev.cajachica
CREATE TABLE IF NOT EXISTS `cajachica` (
  `idCajaChica` int(11) NOT NULL AUTO_INCREMENT,
  `apertura` datetime DEFAULT NULL,
  `cierre` datetime DEFAULT NULL,
  `idEmpleado` int(11) NOT NULL,
  `valorInicial` int(11) NOT NULL,
  PRIMARY KEY (`idCajaChica`),
  KEY `FK_cajachica_empleado` (`idEmpleado`),
  CONSTRAINT `FK_cajachica_empleado` FOREIGN KEY (`idEmpleado`) REFERENCES `empleado` (`idEmpleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla satsanga_dev.cajagrande
CREATE TABLE IF NOT EXISTS `cajagrande` (
  `idCajaGrande` int(11) NOT NULL AUTO_INCREMENT,
  `idTipoEgresoFijo` int(11) DEFAULT NULL COMMENT 'Sí el valor es NULL significa que es un ingresoa la caja grande y tiene asociado un idMovimientoCajaChica',
  `observacion` varchar(50) DEFAULT NULL,
  `fecha` date NOT NULL,
  `idMovimientoCajaChica` int(11) DEFAULT NULL,
  `valor` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idCajaGrande`),
  KEY `FK_movimientocajachica_cajagrande` (`idMovimientoCajaChica`),
  CONSTRAINT `FK_movimientocajachica_cajagrande` FOREIGN KEY (`idMovimientoCajaChica`) REFERENCES `movimientocajachica` (`idMovimientoCajaChica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla satsanga_dev.clase
CREATE TABLE IF NOT EXISTS `clase` (
  `idClase` int(11) NOT NULL AUTO_INCREMENT,
  `idEmpleado` int(11) NOT NULL COMMENT 'Solo puede ser un empleado del tipo "Profesor"',
  `idEstadoClase` int(11) NOT NULL,
  `idDia` int(11) NOT NULL,
  `horaInicio` time NOT NULL,
  `horaFin` time NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idClase`),
  KEY `fk_ClaseEmpleado` (`idEmpleado`),
  KEY `fk_ClaseDia` (`idDia`),
  KEY `fk_ClaseEstadoClase` (`idEstadoClase`),
  CONSTRAINT `fk_ClaseDia` FOREIGN KEY (`idDia`) REFERENCES `dia` (`idDia`),
  CONSTRAINT `fk_ClaseEmpleado` FOREIGN KEY (`idEmpleado`) REFERENCES `empleado` (`idEmpleado`),
  CONSTRAINT `fk_ClaseEstadoClase` FOREIGN KEY (`idEstadoClase`) REFERENCES `estadoclase` (`idEstadoClase`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla satsanga_dev.comoconocio
CREATE TABLE IF NOT EXISTS `comoConocio` (
  `idComoConocio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idComoConocio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla satsanga_dev.comocontacto
CREATE TABLE IF NOT EXISTS `comoContacto` (
  `idComoContacto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idComoContacto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `comoContacto` (`idComoContacto`, `nombre`, `descripcion`) VALUES 
(NULL, 'Formulario web', NULL), 
(NULL, 'E-mail', NULL), 
(NULL, 'WhatsApp', NULL), 
(NULL, 'Teléfono', NULL),
(NULL, 'Facebook', NULL), 
(NULL, 'Instagram', NULL), 
(NULL, 'Personalmente', NULL), 
(NULL, 'Otros', NULL);

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla satsanga_dev.dia
CREATE TABLE IF NOT EXISTS `dia` (
  `idDia` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`idDia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla satsanga_dev.empleado
CREATE TABLE IF NOT EXISTS `empleado` (
  `idEmpleado` int(11) NOT NULL AUTO_INCREMENT,
  `nombreApellido` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `idTipoEmpleado` int(11) NOT NULL,
  `idEstadoEmpleado` int(11) NOT NULL,
  `idGenero` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fechaAlta` date NOT NULL,
  `fechaNacimiento` date DEFAULT NULL,
  PRIMARY KEY (`idEmpleado`),
  KEY `fk_TipoEmpleado_idx` (`idTipoEmpleado`),
  KEY `fk_EstadoEmpleado_idx` (`idEstadoEmpleado`),
  KEY `fk_GeneroEmpleado_idx` (`idGenero`),
  CONSTRAINT `fk_EstadoEmpleado` FOREIGN KEY (`idEstadoEmpleado`) REFERENCES `estadoempleado` (`idEstadoEmpleado`),
  CONSTRAINT `fk_GeneroEmpleado` FOREIGN KEY (`idGenero`) REFERENCES `genero` (`idGenero`),
  CONSTRAINT `fk_TipoEmpleado` FOREIGN KEY (`idTipoEmpleado`) REFERENCES `tipoempleado` (`idTipoEmpleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla satsanga_dev.empresa
CREATE TABLE IF NOT EXISTS `empresa` (
  `idEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `razonSocial` varchar(50) NOT NULL,
  `domicilio` varchar(50) DEFAULT NULL,
  `localidad` varchar(50) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `cuit` varchar(20) DEFAULT NULL,
  `contacto` varchar(20) DEFAULT NULL,
  `observaciones` varchar(100) DEFAULT NULL,
  `idGestor` int(11) DEFAULT NULL COMMENT 'está relacionado a Empleado pero sólo aquellos que son del tipo Gestor',
  PRIMARY KEY (`idEmpresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla satsanga_dev.empresaempleado
CREATE TABLE IF NOT EXISTS `empresaempleado` (
  `idEmpresa` int(11) NOT NULL,
  `idEmpleado` int(11) NOT NULL COMMENT 'Sólo del tipo profesor',
  PRIMARY KEY (`idEmpresa`,`idEmpleado`),
  KEY `FK_EmpresaEmpleadoEmpleado` (`idEmpleado`),
  CONSTRAINT `FK_EmpresaEmpleadoEmpleado` FOREIGN KEY (`idEmpleado`) REFERENCES `empleado` (`idEmpleado`),
  CONSTRAINT `FK_EmpresaEmpleadoEmpresa` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla satsanga_dev.estadoclase
CREATE TABLE IF NOT EXISTS `estadoclase` (
  `idEstadoClase` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(10) NOT NULL,
  PRIMARY KEY (`idEstadoClase`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla satsanga_dev.estadoempleado
CREATE TABLE IF NOT EXISTS `estadoempleado` (
  `idEstadoEmpleado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idEstadoEmpleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla satsanga_dev.estadoestudiante
CREATE TABLE IF NOT EXISTS `estadoestudiante` (
  `idEstadoEstudiante` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idEstadoEstudiante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla satsanga_dev.estudiante
CREATE TABLE IF NOT EXISTS `estudiante` (
  `idEstudiante` int(11) NOT NULL AUTO_INCREMENT,
  `nombreApellido` varchar(255) NOT NULL,
  `fechaAlta` date NOT NULL,
  `idEstadoEstudiante` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fechaNacimiento` date NOT NULL,
  `idComoConocio` int(11) NOT NULL,
  `idGenero` int(11) NOT NULL,
  `fechaBaja` date DEFAULT NULL,
  PRIMARY KEY (`idEstudiante`),
  KEY `fk_EstadoEstudiante_idx` (`idEstadoEstudiante`),
  KEY `fk_ComoConocio_idx` (`idComoConocio`),
  KEY `fk_Genero_idx` (`idGenero`),
  CONSTRAINT `fk_ComoConocio` FOREIGN KEY (`idComoConocio`) REFERENCES `comoconocio` (`idComoConocio`),
  CONSTRAINT `fk_EstadoEstudiante` FOREIGN KEY (`idEstadoEstudiante`) REFERENCES `estadoestudiante` (`idEstadoEstudiante`),
  CONSTRAINT `fk_Genero` FOREIGN KEY (`idGenero`) REFERENCES `genero` (`idGenero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla satsanga_dev.factura
CREATE TABLE IF NOT EXISTS `factura` (
  `idFactura` int(11) NOT NULL AUTO_INCREMENT,
  `numeroFactura` int(11) NOT NULL,
  `idEstudiante` int(11) DEFAULT NULL,
  `idEmpresa` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `cliente` varchar(50) NOT NULL,
  `cuit` varchar(20) DEFAULT NULL,
  `domicilio` varchar(50) DEFAULT NULL,
  `localidad` varchar(20) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `respNoInscripto` bit(1) DEFAULT b'0',
  `respInscripto` bit(1) DEFAULT b'0',
  `exento` bit(1) DEFAULT b'0',
  `noResponsable` bit(1) DEFAULT b'0',
  `consumidorFinal` bit(1) DEFAULT b'0',
  `respMonotributista` bit(1) DEFAULT b'0',
  `contado` bit(1) DEFAULT b'0',
  `cuentaCorriente` bit(1) DEFAULT b'0',
  `numeroRemito` int(11) DEFAULT NULL,
  `detalle` varchar(200) DEFAULT NULL,
  `total` float NOT NULL,
  PRIMARY KEY (`idFactura`),
  UNIQUE KEY `numeroFactura` (`numeroFactura`),
  KEY `FK_FacturaEmpresa` (`idEmpresa`),
  KEY `FK_FacturaEstudiante` (`idEstudiante`),
  CONSTRAINT `FK_FacturaEmpresa` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`) ON DELETE SET NULL,
  CONSTRAINT `FK_FacturaEstudiante` FOREIGN KEY (`idEstudiante`) REFERENCES `estudiante` (`idEstudiante`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla satsanga_dev.genero
CREATE TABLE IF NOT EXISTS `genero` (
  `idGenero` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  PRIMARY KEY (`idGenero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla satsanga_dev.liquidacionsueldo
CREATE TABLE IF NOT EXISTS `liquidacionsueldo` (
  `idLiquidacionSueldo` int(11) NOT NULL AUTO_INCREMENT,
  `idEmpleado` int(11) DEFAULT '0' COMMENT 'Si el valor es NULL tomamos que es correspondiente a Satsanga',
  `mes` smallint(6) NOT NULL,
  `valor` float NOT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `año` int(11) NOT NULL,
  PRIMARY KEY (`idLiquidacionSueldo`),
  KEY `FK_Empleado` (`idEmpleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla satsanga_dev.movimientocajachica
CREATE TABLE IF NOT EXISTS `movimientocajachica` (
  `idMovimientoCajaChica` int(11) NOT NULL AUTO_INCREMENT,
  `idCajaChica` int(11) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `valor` int(11) NOT NULL DEFAULT '0',
  `idTipoMovimientoCC` int(11) NOT NULL,
  `idRecibo` int(11) DEFAULT NULL,
  PRIMARY KEY (`idMovimientoCajaChica`),
  KEY `FK_cajaChica_movimientoCajaChica` (`idCajaChica`),
  KEY `FK_tipoMovimientoCC_movimientoCajaChica` (`idTipoMovimientoCC`),
  CONSTRAINT `FK_cajaChica_movimientoCajaChica` FOREIGN KEY (`idCajaChica`) REFERENCES `cajachica` (`idCajaChica`),
  CONSTRAINT `FK_tipoMovimientoCC_movimientoCajaChica` FOREIGN KEY (`idTipoMovimientoCC`) REFERENCES `tipomovimientocc` (`idTipoMovimientoCC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla satsanga_dev.recibo
CREATE TABLE IF NOT EXISTS `recibo` (
  `idRecibo` int(11) NOT NULL AUTO_INCREMENT,
  `idEstudiante` int(11) DEFAULT NULL,
  `idFactura` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `numeroRecibo` int(11) NOT NULL,
  `valor` int(5) NOT NULL,
  `vecesPorSemana` tinyint(4) NOT NULL,
  `observaciones` varchar(100) DEFAULT NULL,
  `promocion` varchar(15) DEFAULT NULL,
  `proximoMes` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idRecibo`),
  UNIQUE KEY `numeroRecibo` (`numeroRecibo`),
  KEY `fk_ReciboEstudiante` (`idEstudiante`),
  KEY `fk_ReciboFactura` (`idFactura`),
  CONSTRAINT `fk_ReciboEstudiante` FOREIGN KEY (`idEstudiante`) REFERENCES `estudiante` (`idEstudiante`),
  CONSTRAINT `fk_ReciboFactura` FOREIGN KEY (`idFactura`) REFERENCES `factura` (`idFactura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla satsanga_dev.reciboclase
CREATE TABLE IF NOT EXISTS `reciboclase` (
  `idRecibo` int(11) NOT NULL,
  `idClase` int(11) NOT NULL,
  PRIMARY KEY (`idRecibo`,`idClase`),
  KEY `fk_ReciboClaseClase` (`idClase`),
  CONSTRAINT `fk_ReciboClaseClase` FOREIGN KEY (`idClase`) REFERENCES `clase` (`idClase`),
  CONSTRAINT `fk_ReciboClaseRecibo` FOREIGN KEY (`idRecibo`) REFERENCES `recibo` (`idRecibo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla satsanga_dev.tipoegresofijo
CREATE TABLE IF NOT EXISTS `tipoegresofijo` (
  `idTipoEgresoFijo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  PRIMARY KEY (`idTipoEgresoFijo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla satsanga_dev.tipoempleado
CREATE TABLE IF NOT EXISTS `tipoempleado` (
  `idTipoEmpleado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idTipoEmpleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla satsanga_dev.tipomovimientocc
CREATE TABLE IF NOT EXISTS `tipomovimientocc` (
  `idTipoMovimientoCC` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  PRIMARY KEY (`idTipoMovimientoCC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla satsanga_dev.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `NombreUsuario` varchar(25) NOT NULL,
  `Password` varchar(255) NOT NULL COMMENT 'Se guarda el hash creado a partir de una función en php',
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

INSERT INTO usuario (NombreUsuario, PASSWORD)
VALUES ('satsanga', '8fb/Vv822QjwWS76SahafjAkeA2pv8yBjBi5+dtyMBc='); --pass => upasaka0

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla satsanga_dev.usuario
CREATE TABLE IF NOT EXISTS `clasePrueba` (
	`idClasePrueba` BIGINT(20) NOT NULL AUTO_INCREMENT,
	`fecha` DATE NOT NULL,
	`nombre` VARCHAR(50) NOT NULL,
	`telefono` VARCHAR(50) NOT NULL,
	`email` VARCHAR(255) NOT NULL,
	`idClase` INT(11) NOT NULL,
	`asistio` INT(11) NULL DEFAULT NULL,
	`pago` INT(11) NULL DEFAULT NULL,
	`promo` INT(11) NULL DEFAULT NULL COMMENT 'es en %',
	`idComoConocio` INT(11) NOT NULL,
	`idComoContacto` INT(11) NOT NULL,
	`observaciones` VARCHAR(255) NOT NULL DEFAULT '',
	`cancelada` TINYINT(1) NOT NULL DEFAULT '0',
	PRIMARY KEY (`idClasePrueba`),
	CONSTRAINT `FK_claseprueba_clase` FOREIGN KEY (`idClase`) REFERENCES `clase` (`idClase`),
	CONSTRAINT `FK_claseprueba_comoconocio` FOREIGN KEY (`idComoConocio`) REFERENCES `comoconocio` (`idComoConocio`),
	CONSTRAINT `FK_claseprueba_comocontacto` FOREIGN KEY (`idComoContacto`) REFERENCES `comocontacto` (`idComoContacto`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para procedimiento satsanga_dev.deleteMovimientoCajaChica
DELIMITER //
CREATE PROCEDURE `deleteMovimientoCajaChica`(
	IN `_idMovimientoCajaChica` INT
)
BEGIN

	delete from cajaGrande where idMovimientoCajaChica = _idMovimientoCajaChica;
	delete from adelanto where idMovimientoCajaChica = _idMovimientoCajaChica;
	
	delete r from recibo r
	left join movimientoCajaChica mcc on mcc.idRecibo = r.idRecibo
	where mcc.idMovimientoCajaChica = _idMovimientoCajaChica;
	
	delete from movimientoCajaChica where idMovimientoCajaChica = _idMovimientoCajaChica;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.generateLiquidacionSueldo
DELIMITER //
CREATE PROCEDURE `generateLiquidacionSueldo`(
	IN `_mes` INT,
	IN `_año` INT
)
BEGIN
-- declaracion de variables locales
declare v_idRecibo int(11);
declare v_numeroRecibo int(11);
declare v_idEstudiante int(11);
declare v_idFactura int(11);
declare v_valor int;
declare v_cantEmpleados int default 0;
declare v_idGestor int;

declare no_hay_mas_registros int default 0;

declare cursorRecibos cursor for
select r.idRecibo, r.numeroRecibo, r.idEstudiante, r.idFactura, r.valor
from recibo r 
where month(r.fecha) = _mes and year(r.fecha) = _año;

declare continue handler for not found set no_hay_mas_registros = 1;

-- tabla temporal
drop temporary table if exists ttLiquidacion;
create temporary table ttLiquidacion (idEmpleado int(11), valor float, observaciones varchar(200));

-- se abre el cursor
open cursorRecibos;

-- se van tomando los datos hasta que el cursor llegue al final
bucle: loop

	fetch cursorRecibos into v_idRecibo, v_numeroRecibo, v_idEstudiante, v_idFactura, v_valor;
	if (no_hay_mas_registros = 1) then
		leave bucle;
	end if;
		
	if (not isnull(v_idEstudiante)) then
		-- Recibo perteneciente a clases que toma un estudiante
				
		-- seleccionamos la cantidad de empleados asignados al recibo para luego ser dividido el 50% del mismo entre la cantidad que son
		set v_cantEmpleados = (select count(c.idEmpleado) 
									from reciboclase rc 
									inner join clase c on c.idClase = rc.idClase 
									where rc.idRecibo = v_idRecibo);
		
		-- insertamos el registro correspondiente a Satsanga en la tabla temporal. Le corresponde el 50% del total del recibo
		insert into ttLiquidacion (idEmpleado, valor) values (0, (v_valor / 2));
		
		-- insertamos los registros correspondientes a los empleados en la tabla temporal
		insert into ttLiquidacion (idEmpleado, valor, observaciones) 
		select c.idEmpleado, ((v_valor / 2) / v_cantEmpleados), v_numeroRecibo
		from reciboclase rc 
		inner join clase c on c.idClase = rc.idClase 
		where rc.idRecibo = v_idRecibo;
		
	else
		-- Recibo perteneciente a una factura de empresa
				
		-- guardamos en variable el id de gestor
		set v_idGestor = (select e.idGestor 
								from factura f
								inner join empresa e on e.idEmpresa = f.idEmpresa where f.idFactura = v_idFactura);
		
		-- guardamos la cantidad de profes que dan clases en la empresa
		set v_cantEmpleados = (select count(ee.idEmpleado)
										from factura f
										inner join empresaEmpleado ee on ee.idEmpresa = f.idEmpresa
										where f.idFactura = v_idFactura);
				
		-- con idgestor <> null -> 30% sat, 30% gestor, 40% entre profes
		-- con idgestor == null -> 60% sat, 40% entre profes
		if (isnull(v_idGestor)) then
			-- insertamos el registro correspondiente a Satsanga en la tabla temporal. Le corresponde el 60% del total del recibo
			insert into ttLiquidacion (idEmpleado, valor) values (0, (v_valor * 0.6));
		else
			-- insertamos el registro correspondiente a Satsanga en la tabla temporal. Le corresponde el 30% del total del recibo
			insert into ttLiquidacion (idEmpleado, valor) values (0, (v_valor * 0.3));
			-- insertamos el registro correspondiente al Gestor en la tabla temporal. Le corresponde el 30% del total del recibo
			insert into ttLiquidacion (idEmpleado, valor, observaciones) values (v_idGestor, (v_valor * 0.3), v_numeroRecibo);
		end if;
		
		-- insertamos los registros correspondientes a los empleados en la tabla temporal. Les corresponde el 40% dividido entre todos ellos
		insert into ttLiquidacion (idEmpleado, valor, observaciones) 
		select ee.idEmpleado, ((v_valor * 0.4) / v_cantEmpleados), v_numeroRecibo
		from factura f
		inner join empresaEmpleado ee on ee.idEmpresa = f.idEmpresa
		where f.idFactura = v_idFactura;
		
	end if;
	
end loop bucle;
close cursorRecibos;

-- limpiamos tabla liquidación para el mes en cuestion
delete from liquidacionSueldo where mes = _mes and año = _año;

-- insertamos registros con las liquidaciones del mes
insert into liquidacionSueldo	(mes, idEmpleado, año, observaciones, valor)
select 	_mes, ttl.idEmpleado, _año, concat('#Recibos: ', group_concat(distinct ttl.observaciones)), 
			(sum(ttl.valor) + (
									IFNULL(
										(select sum(mcc.valor)
										from movimientoCajaChica mcc 
										left join adelanto a on a.idMovimientoCajaChica = mcc.idMovimientoCajaChica
										where a.idEmpleado = ttl.idEmpleado and month(a.fecha) = _mes and year(a.fecha) = _año)
									, 0) +
									IFNULL(
											(select sum(cg.valor) 
											from cajaGrande cg 
											inner join adelanto a on a.idCajaGrande = cg.idCajaGrande
											where a.idEmpleado = ttl.idEmpleado and month(a.fecha) = _mes and year(a.fecha) = _año)
									, 0)
									)
			)
from ttLiquidacion ttl
group by ttl.idEmpleado;

drop temporary table if exists ttLiquidacion;

-- Actualizamos los estados de estudiantes a 'Activo' si tiene un recibo ese mes y a 'Inactivo' si es que no tiene
update estudiante
set 
	idEstadoEstudiante = 1, -- 1 = activo
	fechaBaja = null
where 
	idEstudiante in (	
							select idEstudiante 
							from recibo 
							where 
								year(fecha) = _año and idEstudiante is not null and 
								(month(fecha) = month(CURRENT_DATE()) OR (month(fecha) = month(CURRENT_DATE())-1 AND proximoMes = 1))
						 );

update estudiante
set 
	idEstadoEstudiante = 3, -- 3 = inactivo
	fechaBaja = CURDATE()
where 
	idEstudiante not in (	
							select idEstudiante 
							from recibo 
							where 
								year(fecha) = _año and idEstudiante is not null and 
								(month(fecha) = month(CURRENT_DATE()) OR (month(fecha) = month(CURRENT_DATE())-1 AND proximoMes = 1))
						 ) and fechaBaja is null;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getAdelantos
DELIMITER //
CREATE PROCEDURE `getAdelantos`(
	IN `_mes` INT,
	IN `_año` INT,
	IN `_idEmpleado` INT
)
BEGIN

	SELECT 	a.idAdelanto, DATE_FORMAT(a.fecha,'%m/%d/%Y') as fecha, a.idMovimientoCajaChica, cg.idCajaGrande, 
			ifnull(mcc.valor, cg.valor) AS valor
	from adelanto a 
	left join movimientoCajaChica mcc on mcc.idMovimientoCajaChica = a.idMovimientoCajaChica 
	left join cajaGrande cg on cg.idCajaGrande = a.idCajaGrande
	where
		month(a.fecha) = _mes and year(a.fecha) = _año and a.idEmpleado = _idEmpleado;
	
END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getCajaChicaActual
DELIMITER //
CREATE PROCEDURE `getCajaChicaActual`()
BEGIN
	SELECT 	cc.idCajaChica, cc.apertura, cc.cierre, cc.idEmpleado, e.nombreApellido AS emple_nombreApellido,
				cc.valorInicial
	FROM cajaChica cc
	INNER JOIN empleado e ON e.idEmpleado = cc.idEmpleado
	WHERE
		cc.cierre is NULL;
END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getCajaChicaByFilter
DELIMITER //
CREATE PROCEDURE `getCajaChicaByFilter`(
	IN `_nombreEmpleado` VARCHAR(50),
	IN `_aperturaDesde` DATE,
	IN `_aperturaHasta` DATE,
	IN `_cierreDesde` DATE,
	IN `_cierreHasta` DATE,
	IN `_valorInicial` INT
)
BEGIN
	set @filtro = '';
	
	set @consulta = 'SELECT cc.idCajaChica, cc.apertura, cc.cierre, cc.valorInicial, cc.idEmpleado, e.nombreApellido AS emple_nombreApellido, ';
	set @consulta = concat(@consulta, 'cc.valorInicial + (SELECT sum(mcc.valor) FROM movimientoCajaChica mcc WHERE mcc.idcajaChica = cc.idCajaChica) AS valorFinal ');
	set @consulta = concat(@consulta, 'FROM cajaChica cc ');
	set @consulta = concat(@consulta, 'INNER JOIN empleado e ON e.idEmpleado = cc.idEmpleado ');
	set @consulta = concat(@consulta, 'WHERE cc.cierre is not null ');
    
	if (_nombreEmpleado <> '' and _nombreEmpleado is not null) then
		set @filtro = concat('e.nombreApellido like ''%', _nombreEmpleado, '%''');
	end if;

	if (_aperturaDesde is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	     end if;
		set @filtro = concat(@filtro, 'CAST(cc.apertura AS DATE) >= ''', _aperturaDesde, '''');
	end if;
	 
	if (_aperturaHasta is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	     end if;
		set @filtro = concat(@filtro, 'CAST(cc.apertura AS DATE) <= ''', _aperturaHasta, '''');
	end if;
	
	if (_cierreDesde is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	     end if;
		set @filtro = concat(@filtro, 'CAST(cc.cierre AS DATE) >= ''', _cierreDesde, '''');
	end if;
	 
	if (_cierreHasta is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	     end if;
		set @filtro = concat(@filtro, 'CAST(cc.cierre AS DATE) <= ''', _cierreHasta, '''');
	end if;

	if (_valorInicial <> 0 and _valorInicial is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
		end if;
		set @filtro = concat(@filtro, 'cc.valorInicial = ', _valorInicial);
	end if;

	if (@filtro <> '') then
		set @consulta = concat(@consulta, ' and ', @filtro);
	end if;
	set @consulta = concat(@consulta, ' order by cc.apertura desc');
    
	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @consulta;
	-- ejecutamos el Statement
	EXECUTE smpt;
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getCajaGrandeByFilter
DELIMITER //
CREATE PROCEDURE `getCajaGrandeByFilter`(
	IN `_idTipoEgresoFijo` INT,
	IN `_fechaDesde` DATE,
	IN `_fechaHasta` DATE,
	IN `_observacion` VARCHAR(50),
	IN `_soloEgresos` INT
)
BEGIN

	set @filtro = '';
	
	/*En el select se coloca el formato fecha como: "m/d/y" ya que necesita este formato el objeto date de javascript*/
   
	set @consulta = 'SELECT cg.idCajaGrande, cg.idTipoEgresoFijo, cg.observacion, DATE_FORMAT(cg.fecha,''%m/%d/%Y'') as fecha, ';
	set @consulta = CONCAT(@consulta, 'cg.idMovimientoCajaChica, cg.valor, a.idAdelanto, a.idEmpleado ');
	set @consulta = CONCAT(@consulta, 'FROM cajaGrande cg ');
	set @consulta = CONCAT(@consulta, 'LEFT JOIN adelanto a on a.idCajaGrande = cg.idCajaGrande ');
	 
	if (_idTipoEgresoFijo is not null and _idTipoEgresoFijo <> 0) then
		set @filtro = concat('cg.idTipoEgresoFijo = ', _idTipoEgresoFijo);
	end if;

	if (_fechaDesde is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	   end if;
		set @filtro = concat(@filtro, 'cg.fecha >= ''', _fechaDesde, '''');
	end if;
	 
	if (_fechaHasta is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	   end if;
		set @filtro = concat(@filtro, 'cg.fecha <= ''', _fechaHasta, '''');
	end if;
	
	if (_observacion <> '' and _observacion is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	   end if;
		set @filtro = concat(@filtro, 'cg.observacion like ''%', _observacion, '%''');
	end if;
	
	if (_soloEgresos = 1) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	   end if;
		set @filtro = concat(@filtro, 'cg.idTipoEgresoFijo is not null');
	END if;
	
	if (@filtro <> '') then
		set @consulta = concat(@consulta, ' where ', @filtro);
	end if;
	set @consulta = concat(@consulta, ' order by cg.fecha desc');
	
	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @consulta;
	-- ejecutamos el Statement
	EXECUTE smpt;
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getClaseById
DELIMITER //
CREATE PROCEDURE `getClaseById`(
	IN `_idClase` INT
)
BEGIN

	select 	c.idClase, time_format(c.horaInicio, "%H:%i") as horaInicio, 
				time_format(c.horaFin, "%H:%i") as horaFin, c.descripcion,
				e.idEmpleado, ec.idEstadoClase, ec.nombre as nombreEstado, 
				d.idDia, d.nombre as nombreDia, 
				time_format( TIMEDIFF(c.horaFin, c.horaInicio), "%H:%i") as duracion,
				SUBSTRING_INDEX(e.nombreApellido, ' ', 1) as nombreApellido, e.celular
	from clase c
	inner join empleado e on e.idEmpleado = c.idEmpleado
	inner join dia d on d.idDia = c.idDia
	inner join estadoClase ec on ec.idEstadoClase = c.idEstadoClase
	where
		c.idClase = _idClase;
END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getClaseByEstado
DELIMITER //
CREATE PROCEDURE `getClaseByEstado`(
	IN `_idEstadoClase` INT
)
BEGIN

	select 	c.idClase, time_format(c.horaInicio, "%H:%i") as horaInicio, 
				time_format(c.horaFin, "%H:%i") as horaFin, c.descripcion,
				e.idEmpleado, ec.idEstadoClase, ec.nombre as nombreEstado, 
				d.idDia, d.nombre as nombreDia, 
				time_format( TIMEDIFF(c.horaFin, c.horaInicio), "%H:%i") as duracion,
				SUBSTRING_INDEX(e.nombreApellido, ' ', 1) as nombreApellido
	from clase c
	inner join empleado e on e.idEmpleado = c.idEmpleado
	inner join dia d on d.idDia = c.idDia
	inner join estadoclase ec on ec.idEstadoClase = c.idEstadoClase
	where
		c.idEstadoClase = _idEstadoClase
	order by d.idDia asc, c.horaInicio asc;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getClaseByRecibo
DELIMITER //
CREATE PROCEDURE `getClaseByRecibo`(
	IN `_idRecibo` BIGINT


)
BEGIN
	select 	c.idClase, time_format(c.horaInicio, "%H:%i") as horaInicio, 
				time_format(c.horaFin, "%H:%i") as horaFin, c.descripcion,
				e.idEmpleado, e.nombreApellido, ec.idEstadoClase, ec.nombre as nombreEstado, 
				d.idDia, d.nombre as nombreDia,
				time_format( TIMEDIFF(c.horaFin, c.horaInicio), "%H:%i") as duracion
	from clase c
	inner join reciboclase rc on rc.idClase = c.idClase
	inner join empleado e on e.idEmpleado = c.idEmpleado
	inner join dia d on d.idDia = c.idDia
	inner join estadoclase ec on ec.idEstadoClase = c.idEstadoClase
	where
		rc.idRecibo = _idRecibo;
END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getClasesByFilter
DELIMITER //
CREATE PROCEDURE `getClasesByFilter`(
	IN `_emple_nombreApellido` VARCHAR(100),
	IN `_idEstadoClase` INT,
	IN `_idDia` INT,
	IN `_descripcion` VARCHAR(50)
)
BEGIN

	set @filtro = '';
	
	/*En el select se coloca el formato fecha como: "m/d/y" ya que necesita este formato el objeto date de javascript*/
   
	set @consulta = 'select c.idClase, c.idEmpleado, c.idEstadoClase, c.idDia, time_format(c.horaInicio, ''%H:%i'') as horaInicio, ';
	set @consulta = CONCAT(@consulta, 'time_format(c.horaFin, ''%H:%i'') as horaFin, c.descripcion, ');
	set @consulta = CONCAT(@consulta, 'time_format(TIMEDIFF(c.horaFin, c.horaInicio), ''%H:%i'') as duracion, ');
	set @consulta = CONCAT(@consulta, 'e.nombreApellido as nombreApellido, d.nombre as nombreDia, ec.nombre as nombreEstado ');
	set @consulta = CONCAT(@consulta, 'from clase c ');
	set @consulta = CONCAT(@consulta, 'inner join empleado e on e.idEmpleado = c.idEmpleado ');
	set @consulta = CONCAT(@consulta, 'inner join dia d on d.idDia = c.idDia ');
	set @consulta = CONCAT(@consulta, 'inner join estadoclase ec on ec.idEstadoClase = c.idEstadoClase');
	 
	if (_emple_nombreApellido <> '' && _emple_nombreApellido is not null) then
		set @filtro = concat(@filtro, 'e.nombreApellido like ''%', _emple_nombreApellido, '%''');
	end if;
	 
	if (_idEstadoClase <> '' and _idEstadoClase is not null and _idEstadoClase <> 0) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	   end if;
		set @filtro = concat(@filtro, 'c.idEstadoClase = ', _idEstadoClase);
	end if;
	
	if (_idDia <> '' and _idDia is not null and _idDia <> 0) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	   end if;
		set @filtro = concat(@filtro, 'c.idDia = ', _idDia);
	end if;
	
	if (_descripcion <> '' and _descripcion is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	   end if;
		set @filtro = concat(@filtro, 'c.descripcion like ''%', _descripcion, '%''');
	end if;
	
	if (@filtro <> '') then
		set @consulta = concat(@consulta, ' where ', @filtro);
	end if;
	set @consulta = concat(@consulta, ' order by c.idDia, c.horaInicio');
	
	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @consulta;
	-- ejecutamos el Statement
	EXECUTE smpt;
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getClasesPruebaByFilter
DELIMITER //
CREATE PROCEDURE `getClasesPruebaByFilter`(
	IN `_fechaDesde` DATE,
	IN `_fechaHasta` DATE,
	IN `_nombre` VARCHAR(50),
	IN `_telefono` VARCHAR(50),
	IN `_email` VARCHAR(255),
	IN `_idClase` INT,
	IN `_asistio` INT,
	IN `_pago` INT,
	IN `_promo` INT,
	IN `_idComoConocio` INT,
	IN `_idComoContacto` INT,
	IN `_observaciones` VARCHAR(255)
)
Begin
	set @filtro = '';
	   
	set @consulta = 'select cp.idClasePrueba, DATE_FORMAT(cp.fecha,''%m/%d/%Y'') as fecha, cp.nombre, cp.telefono, cp.email, cp.idClase, cp.asistio, cp.pago, ';
	set @consulta = CONCAT(@consulta, 'cp.promo, cp.idComoConocio, cp.idComoContacto, cp.observaciones, cp.cancelada, ');
	set @consulta = CONCAT(@consulta, 'time_format(c.horaInicio, ''%H:%i'') as horaInicio, ');
	set @consulta = CONCAT(@consulta, 'e.celular as emple_celular, e.nombreApellido as emple_nombre, d.idDia, d.nombre as dia_nombre ');
	set @consulta = CONCAT(@consulta, 'from clasePrueba cp ');
	set @consulta = CONCAT(@consulta, 'inner join clase c on c.idClase = cp.idClase ');
	set @consulta = CONCAT(@consulta, 'inner join dia d on d.idDia = c.idDia ');
	set @consulta = CONCAT(@consulta, 'inner join empleado e on c.idEmpleado = e.idEmpleado ');

	if (_fechaDesde is not null) then
		set @filtro = concat(@filtro, 'cp.fecha >= ''', _fechaDesde, '''');
	end if;
	
	if (_fechaHasta is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	   end if;
		set @filtro = concat(@filtro, 'cp.fecha <= ''', _fechaHasta, '''');
	end if;

	if (_nombre <> '' && _nombre is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	   end if;
		set @filtro = concat(@filtro, 'cp.nombre like ''%', _nombre, '%''');
	end if;
	
	if (_telefono <> '' && _telefono is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	   end if;
		set @filtro = concat(@filtro, 'cp.telefono like ''%', _telefono, '%''');
	end if;
	
	if (_email <> '' && _email is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	   end if;
		set @filtro = concat(@filtro, 'cp.email like ''%', _email, '%''');
	end if;
	
	if (_idClase <> '' and _idClase is not null and _idClase <> 0) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	   end if;
		set @filtro = concat(@filtro, 'cp.idClase = ', _idClase);
	end if;
	 
	if (_asistio <> '' and _asistio is not null and _asistio <> 0) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	   end if;
		set @filtro = concat(@filtro, 'cp.asistio = ', _asistio);
	end if;
	
	if (_pago <> '' and _pago is not null and _pago <> 0) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	   end if;
		set @filtro = concat(@filtro, 'cp.pago = ', _pago);
	end if;

	if (_promo <> '' and _promo is not null and _promo <> 0) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	   end if;
		set @filtro = concat(@filtro, 'cp.promo = ', _promo);
	end if;
	
	if (_idComoConocio <> '' and _idComoConocio is not null and _idComoConocio <> 0) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	   end if;
		set @filtro = concat(@filtro, 'cp.idComoConocio = ', _idComoConocio);
	end if;
	
	if (_idComoContacto <> '' and _idComoContacto is not null and _idComoContacto <> 0) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	   end if;
		set @filtro = concat(@filtro, 'cp.idComoContacto = ', _idComoContacto);
	end if;
	
	if (_observaciones <> '' and _observaciones is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	   end if;
		set @filtro = concat(@filtro, 'cp.observaciones like ''%', _observaciones, '%''');
	end if;
	
	if (@filtro <> '') then
		set @consulta = concat(@consulta, ' where ', @filtro);
	end if;
	set @consulta = concat(@consulta, ' order by cp.fecha desc, c.horaInicio asc');
	
	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @consulta;
	-- ejecutamos el Statement
	EXECUTE smpt;
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;
END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getComoConocio_All
DELIMITER //
CREATE PROCEDURE `getComoConocio_All`()
BEGIN

	SELECT idComoConocio, Nombre, Descripcion from comoConocio;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getComoContacto_All
DELIMITER //
CREATE PROCEDURE `getComoContacto_All`()
BEGIN

	SELECT idComoContacto, Nombre, Descripcion from comoContacto;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getComprobantesDePagoByIdEmpleado
DELIMITER //
CREATE PROCEDURE `getComprobantesDePagoByIdEmpleado`(
	IN `_mes` INT,
	IN `_año` INT,
	IN `_idEmpleado` INT


)
BEGIN
-- declaracion de variables locales
declare v_idRecibo int(11);
declare v_numeroRecibo int(11);
declare v_idEstudiante int(11);
declare v_idFactura int(11);
declare v_valor int;
declare v_cantEmpleados int default 0;
declare v_idGestor int;
declare v_distinctCantEmpleados TINYINT;

declare no_hay_mas_registros int default 0;

declare cursorRecibos cursor for
select r.idRecibo, r.numeroRecibo, r.idEstudiante, r.idFactura, r.valor
from recibo r 
where month(r.fecha) = _mes and year(r.fecha) = _año;

declare continue handler for not found set no_hay_mas_registros = 1;

-- tabla temporal
drop temporary table if exists ttComprobantePago;
create temporary table ttComprobantePago (
	idEmpleado int(11), 
	idRecibo int(11),
	valorProfe float, 
	reciboCompartido TINYINT, -- Si este valor es mayor que 1 indica que es compartido. Si es 0 ó 1 indica que no lo es!
	reciboDeEmpresa TINYINT -- Si este valor es 1 indica que es un recibo de clases en Empresa
);

-- se abre el cursor
open cursorRecibos;

-- se van tomando los datos hasta que el cursor llegue al final
bucle: loop

	fetch cursorRecibos into v_idRecibo, v_numeroRecibo, v_idEstudiante, v_idFactura, v_valor;
	if (no_hay_mas_registros = 1) then
		leave bucle;
	end if;
		
	if (not isnull(v_idEstudiante)) then
		-- Recibo perteneciente a clases que toma un estudiante
				
		-- seleccionamos la cantidad de empleados asignados al recibo para luego ser dividido el 50% del mismo entre la cantidad que son
		set v_cantEmpleados = (select count(c.idEmpleado) 
									from reciboclase rc 
									inner join clase c on c.idClase = rc.idClase 
									where rc.idRecibo = v_idRecibo);

		-- seleccionamos la cantidad de empleados distintos hay implicados en el recibo
		set v_distinctCantEmpleados = (select count(distinct c.idEmpleado) 
									from reciboclase rc 
									inner join clase c on c.idClase = rc.idClase 
									where rc.idRecibo = v_idRecibo);
		
		-- insertamos los registros correspondientes a los empleados en la tabla temporal
		insert into ttComprobantePago (idEmpleado, idRecibo, valorProfe, reciboCompartido, reciboDeEmpresa) 
		select c.idEmpleado, v_idRecibo, ((v_valor / 2) / v_cantEmpleados), v_distinctCantEmpleados, 0
		from reciboclase rc 
		inner join clase c on c.idClase = rc.idClase 
		where rc.idRecibo = v_idRecibo;
		
	else
		-- Recibo perteneciente a una factura de empresa
				
		-- guardamos en variable el id de gestor
		set v_idGestor = (select e.idGestor 
								from factura f
								inner join empresa e on e.idEmpresa = f.idEmpresa where f.idFactura = v_idFactura);
		
		-- guardamos la cantidad de profes que dan clases en la empresa
		set v_cantEmpleados = (select count(ee.idEmpleado)
										from factura f
										inner join empresaEmpleado ee on ee.idEmpresa = f.idEmpresa
										where f.idFactura = v_idFactura);
										
		-- seleccionamos la cantidad de empleados distintos hay implicados en el recibo
		set v_distinctCantEmpleados = (select count(distinct ee.idEmpleado)
										from factura f
										inner join empresaEmpleado ee on ee.idEmpresa = f.idEmpresa
										where f.idFactura = v_idFactura);
				
		-- con idgestor <> null -> 30% sat, 30% gestor, 40% entre profes
		-- con idgestor == null -> 60% sat, 40% entre profes
		if (not isnull(v_idGestor)) then			
			insert into ttComprobantePago (idEmpleado, idRecibo, valorProfe, reciboCompartido, reciboDeEmpresa) 
			values (v_idGestor, v_idRecibo, (v_valor * 0.3), 0, 1);
		end if;
		
		-- insertamos los registros correspondientes a los empleados en la tabla temporal. Les corresponde el 40% dividido entre todos ellos		
		insert into ttComprobantePago (idEmpleado, idRecibo, valorProfe, reciboCompartido, reciboDeEmpresa) 
		select ee.idEmpleado, v_idRecibo, ((v_valor * 0.4) / v_cantEmpleados), v_distinctCantEmpleados, 1
		from factura f
		inner join empresaEmpleado ee on ee.idEmpresa = f.idEmpresa
		where f.idFactura = v_idFactura;
		
	end if;
	
end loop bucle;
close cursorRecibos;

select 	tt.idEmpleado, e.nombreApellido, tt.idRecibo, r.numeroRecibo, round(r.valor, 2) as valorRecibo, 
			round(sum(tt.valorProfe),2) as valorProfe, tt.reciboCompartido, tt.reciboDeEmpresa
from ttComprobantePago tt
left join recibo r on r.idRecibo = tt.idRecibo
left join empleado e on e.idEmpleado = tt.idEmpleado
where
	e.idEmpleado = _idEmpleado
group by tt.idEmpleado, tt.idRecibo;

drop temporary table if exists ttComprobantePago;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getComprobantesPago
DELIMITER //
CREATE PROCEDURE `getComprobantesPago`(
	IN `_mes` INT,
	IN `_año` INT




)
BEGIN
-- declaracion de variables locales
declare v_idRecibo int(11);
declare v_numeroRecibo int(11);
declare v_idEstudiante int(11);
declare v_idFactura int(11);
declare v_valor int;
declare v_cantEmpleados int default 0;
declare v_idGestor int;
declare v_distinctCantEmpleados TINYINT;

declare no_hay_mas_registros int default 0;

declare cursorRecibos cursor for
select r.idRecibo, r.numeroRecibo, r.idEstudiante, r.idFactura, r.valor
from recibo r 
where month(r.fecha) = _mes and year(r.fecha) = _año;

declare continue handler for not found set no_hay_mas_registros = 1;

-- tabla temporal
drop temporary table if exists ttComprobantePago;
create temporary table ttComprobantePago (
	idEmpleado int(11), 
	idRecibo int(11),
	valorProfe float, 
	reciboCompartido TINYINT, -- Si este valor es mayor que 1 indica que es compartido. Si es 0 ó 1 indica que no lo es!
	reciboDeEmpresa TINYINT -- Si este valor es 1 indica que es un recibo de clases en Empresa
);

-- se abre el cursor
open cursorRecibos;

-- se van tomando los datos hasta que el cursor llegue al final
bucle: loop

	fetch cursorRecibos into v_idRecibo, v_numeroRecibo, v_idEstudiante, v_idFactura, v_valor;
	if (no_hay_mas_registros = 1) then
		leave bucle;
	end if;
		
	if (not isnull(v_idEstudiante)) then
		-- Recibo perteneciente a clases que toma un estudiante
				
		-- seleccionamos la cantidad de empleados asignados al recibo para luego ser dividido el 50% del mismo entre la cantidad que son
		set v_cantEmpleados = (select count(c.idEmpleado) 
									from reciboclase rc 
									inner join clase c on c.idClase = rc.idClase 
									where rc.idRecibo = v_idRecibo);

		-- seleccionamos la cantidad de empleados distintos hay implicados en el recibo
		set v_distinctCantEmpleados = (select count(distinct c.idEmpleado) 
									from reciboclase rc 
									inner join clase c on c.idClase = rc.idClase 
									where rc.idRecibo = v_idRecibo);
		
		-- insertamos los registros correspondientes a los empleados en la tabla temporal
		insert into ttComprobantePago (idEmpleado, idRecibo, valorProfe, reciboCompartido, reciboDeEmpresa) 
		select c.idEmpleado, v_idRecibo, ((v_valor / 2) / v_cantEmpleados), v_distinctCantEmpleados, 0
		from reciboclase rc 
		inner join clase c on c.idClase = rc.idClase 
		where rc.idRecibo = v_idRecibo;
		
	else
		-- Recibo perteneciente a una factura de empresa
				
		-- guardamos en variable el id de gestor
		set v_idGestor = (select e.idGestor 
								from factura f
								inner join empresa e on e.idEmpresa = f.idEmpresa where f.idFactura = v_idFactura);
		
		-- guardamos la cantidad de profes que dan clases en la empresa
		set v_cantEmpleados = (select count(ee.idEmpleado)
										from factura f
										inner join empresaEmpleado ee on ee.idEmpresa = f.idEmpresa
										where f.idFactura = v_idFactura);
										
		-- seleccionamos la cantidad de empleados distintos hay implicados en el recibo
		set v_distinctCantEmpleados = (select count(distinct ee.idEmpleado)
										from factura f
										inner join empresaEmpleado ee on ee.idEmpresa = f.idEmpresa
										where f.idFactura = v_idFactura);
				
		-- con idgestor <> null -> 30% sat, 30% gestor, 40% entre profes
		-- con idgestor == null -> 60% sat, 40% entre profes
		if (not isnull(v_idGestor)) then			
			insert into ttComprobantePago (idEmpleado, idRecibo, valorProfe, reciboCompartido, reciboDeEmpresa) 
			values (v_idGestor, v_idRecibo, (v_valor * 0.3), 0, 1);
		end if;
		
		-- insertamos los registros correspondientes a los empleados en la tabla temporal. Les corresponde el 40% dividido entre todos ellos		
		insert into ttComprobantePago (idEmpleado, idRecibo, valorProfe, reciboCompartido, reciboDeEmpresa) 
		select ee.idEmpleado, v_idRecibo, ((v_valor * 0.4) / v_cantEmpleados), v_distinctCantEmpleados, 1
		from factura f
		inner join empresaEmpleado ee on ee.idEmpresa = f.idEmpresa
		where f.idFactura = v_idFactura;
		
	end if;
	
end loop bucle;
close cursorRecibos;

select 	tt.idEmpleado, e.nombreApellido, tt.idRecibo, r.numeroRecibo, round(r.valor,2) as valorRecibo, 
			round(sum(tt.valorProfe),2) as valorProfe, tt.reciboCompartido, tt.reciboDeEmpresa
from ttComprobantePago tt
inner join recibo r on r.idRecibo = tt.idRecibo
inner join empleado e on e.idEmpleado = tt.idEmpleado
group by tt.idEmpleado, tt.idRecibo;

drop temporary table if exists ttComprobantePago;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getDia_All
DELIMITER //
CREATE PROCEDURE `getDia_All`()
BEGIN

	select idDia, Nombre
	from Dia;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getEmpleadosByFilter
DELIMITER //
CREATE PROCEDURE `getEmpleadosByFilter`(
	IN `_nombreApellido` varchar(100),
	IN `_email` varchar(255),
	IN `_idTipoEmpleado` int,
	IN `_idEstadoEmpleado` int,
	IN `_fechaAltaDesde` date,
	IN `_fechaAltaHasta` date
)
BEGIN
	set @filtro = '';
	
    /*En el select se coloca el formato fecha como: "m/d/y" ya que necesita este formato el objeto date de javascript*/
    
    set @consulta = 'select e.idEmpleado, e.nombreApellido, DATE_FORMAT(e.fechaAlta,''%m/%d/%Y'') as fechaAlta, ';
	set @consulta = CONCAT(@consulta, 'e.idEstadoEmpleado, ee.nombre estado, e.email, e.celular, e.telefono, ');
	set @consulta = CONCAT(@consulta, 'DATE_FORMAT(e.fechaNacimiento,''%m/%d/%Y'') as fechaNacimiento, e.idTipoEmpleado, ');
    set @consulta = CONCAT(@consulta, 'te.nombre tipoEmpleado, e.idGenero, g.nombre genero ');
	set @consulta = CONCAT(@consulta, 'from empleado e ');
	set @consulta = CONCAT(@consulta, 'inner join estadoEmpleado ee on ee.idEstadoEmpleado = e.idEstadoEmpleado ');
	set @consulta = CONCAT(@consulta, 'inner join tipoEmpleado te on te.idtipoEmpleado = e.idTipoEmpleado ');
	set @consulta = CONCAT(@consulta, 'inner join genero g on g.idGenero = e.idGenero ');
    
	if (_nombreApellido <> '' and _nombreApellido is not null) then
		set @filtro = concat('e.nombreApellido like ''%', _nombreApellido, '%''');
	end if;
    
    if (_email <> '' && _email is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
        end if;
		set @filtro = concat(@filtro, 'e.email like ''%', _email, '%''');
	end if;
    
	if (_idTipoEmpleado <> '' and _idTipoEmpleado is not null and _idTipoEmpleado <> 0) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
        end if;
		set @filtro = concat(@filtro, 'e.idTipoEmpleado = ', _idTipoEmpleado);
	end if;
    
	if (_idEstadoEmpleado <> '' and _idEstadoEmpleado is not null and _idEstadoEmpleado <> 0) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
        end if;
		set @filtro = concat(@filtro, 'e.idEstadoEmpleado = ', _idEstadoEmpleado);
	end if;
    
	if (_fechaAltaDesde is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
        end if;
		set @filtro = concat(@filtro, 'e.fechaAlta >= ''', _fechaAltaDesde, '''');
	end if;
    
	if (_fechaAltaHasta is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
        end if;
		set @filtro = concat(@filtro, 'e.fechaAlta <= ''', _fechaAltaHasta, '''');
	end if;

	if (@filtro <> '') then
		set @consulta = concat(@consulta, ' where ', @filtro);
	end if;
	set @consulta = concat(@consulta, ' order by e.nombreApellido');

	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @consulta;
	-- ejecutamos el Statement
	EXECUTE smpt;
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;
END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getEmpresasByFilter
DELIMITER //
CREATE PROCEDURE `getEmpresasByFilter`(
	IN `_razonSocial` VARCHAR(50),
	IN `_contacto` VARCHAR(20),
	IN `_telefono` VARCHAR(20),
	IN `_domicilio` VARCHAR(50),
	IN `_cuit` VARCHAR(20),
	IN `_idGestor` INT



)
BEGIN
	set @filtro = '';
	
	set @consulta = 'select e.idEmpresa, e.razonSocial, e.domicilio, e.localidad, e.telefono, ';
	set @consulta = concat(@consulta, 'e.email, e.cuit, e.contacto, e.observaciones, e.idGestor, em.nombreApellido as gestor_nombre ');
	set @consulta = concat(@consulta, 'from empresa e ');
	set @consulta = concat(@consulta, 'left join empleado em on e.idGestor = em.idEmpleado ');
    
	if (_razonSocial <> '' and _razonSocial is not null) then
		set @filtro = concat('e.razonSocial like ''%', _razonSocial, '%''');
	end if;
    
	if (_contacto <> '' and _contacto is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
   	end if;
		set @filtro = concat(@filtro, 'e.contacto like ''%', _contacto, '%''');
	end if;
	
	if (_telefono <> '' and _telefono is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
		end if;
		set @filtro = concat(@filtro, 'e.telefono like ''%', _telefono, '%''');
	end if;
	
	if (_domicilio <> '' and _domicilio is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
		end if;
		set @filtro = concat(@filtro, 'e.domicilio like ''%', _domicilio, '%''');
	end if;
	
	if (_cuit <> '' and _cuit is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
		end if;
		set @filtro = concat(@filtro, 'e.cuit like ''%', _cuit, '%''');
	end if;
    
	if (_idGestor <> 0 and _idGestor is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
      end if;
		set @filtro = concat(@filtro, 'e.idGestor = ', _idGestor);
	end if;

	if (@filtro <> '') then
		set @consulta = concat(@consulta, ' where ', @filtro);
	end if;
	set @consulta = concat(@consulta, ' order by e.razonSocial desc');
    
	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @consulta;
	-- ejecutamos el Statement
	EXECUTE smpt;
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;
END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getEmpresas_All
DELIMITER //
CREATE PROCEDURE `getEmpresas_All`()
BEGIN

	select 	e.idEmpresa, e.razonSocial, e.domicilio, e.localidad, 
				e.telefono, e.email, e.cuit
	from empresa e;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getEstadoClase_All
DELIMITER //
CREATE PROCEDURE `getEstadoClase_All`()
BEGIN

	select ec.idEstadoClase, ec.nombre
	from estadoClase ec;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getEstadoEmpleado_All
DELIMITER //
CREATE PROCEDURE `getEstadoEmpleado_All`()
BEGIN

	SELECT idEstadoEmpleado, Nombre, Descripcion from estadoEmpleado;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getEstadoEstudiante_All
DELIMITER //
CREATE PROCEDURE `getEstadoEstudiante_All`()
BEGIN

	SELECT idEstadoEstudiante, Nombre, Descripcion from estadoEstudiante;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getEstudiantesByFilter
DELIMITER //
CREATE PROCEDURE `getEstudiantesByFilter`(
	IN `_nombreApellido` varchar(255),
	IN `_email` varchar(255),
	IN `_celular` varchar(20),
	IN `_idEstadoEstudiante` int,
	IN `_fechaAltaDesde` date,
	IN `_fechaAltaHasta` date


,
	IN `_idComoConocio` INT
,
	IN `_fechaBajaDesde` DATE,
	IN `_fechaBajaHasta` DATE

)
BEGIN
	set @filtro = '';
	
    /*En el select se coloca el formato fecha como: "m/d/y" ya que necesita este formato el objeto date de javascript*/
    
	set @consulta = 'select e.idEstudiante, e.nombreApellido, DATE_FORMAT(e.fechaAlta,''%m/%d/%Y'') as fechaAlta, ';
	set @consulta = concat(@consulta, 'e.idEstadoEstudiante, ee.nombre estado, e.email, e.observaciones, e.celular, e.telefono, ');
	set @consulta = concat(@consulta, 'DATE_FORMAT(e.fechaNacimiento,''%m/%d/%Y'') as fechaNacimiento, e.idComoConocio, ');
	set @consulta = concat(@consulta, 'cc.nombre comoConocio, e.idGenero, g.nombre genero, DATE_FORMAT(e.fechaBaja,''%m/%d/%Y'') as fechaBaja ');
	set @consulta = concat(@consulta, 'from estudiante e ');
	set @consulta = concat(@consulta, 'inner join estadoEstudiante ee on ee.idEstadoEstudiante = e.idEstadoEstudiante ');
	set @consulta = concat(@consulta, 'inner join comoConocio cc on cc.idComoConocio = e.idComoConocio ');
	set @consulta = concat(@consulta, 'inner join genero g on g.idGenero = e.idGenero');
    
    if (_nombreApellido <> '' and _nombreApellido is not null) then
		set @filtro = concat('e.nombreApellido like ''%', _nombreApellido, '%''');
	end if;
    
    if (_email <> '' and _email is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
        end if;
		set @filtro = concat(@filtro, 'e.email like ''%', _email, '%''');
	end if;
    
	if (_celular <> '' and _celular is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
        end if;
		set @filtro = concat(@filtro, 'e.celular like ''%', _celular, '%''');
	end if;
    
	if (_idEstadoEstudiante <> '' and _idEstadoEstudiante is not null and _idEstadoEstudiante <> '0') then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
        end if;
		set @filtro = concat(@filtro, 'e.idEstadoEstudiante = ', _idEstadoEstudiante);
	end if;
    
	if (_fechaAltaDesde is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
      end if;
		set @filtro = concat(@filtro, 'e.fechaAlta >= ''', _fechaAltaDesde, '''');
	end if;
    
	if (_fechaAltaHasta is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
      end if;
		set @filtro = concat(@filtro, 'e.fechaAlta <= ''', _fechaAltaHasta, '''');
	end if;
	
	if (_idComoConocio <> '' and _idComoConocio is not null and _idComoConocio <> '0') then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
      end if;
		set @filtro = concat(@filtro, 'cc.idComoConocio = ', _idComoConocio);
	end if;
	
	if (_fechaBajaDesde is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
      end if;
		set @filtro = concat(@filtro, 'e.fechaBaja >= ''', _fechaBajaDesde, '''');
	end if;
    
	if (_fechaBajaHasta is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
      end if;
		set @filtro = concat(@filtro, 'e.fechaBaja <= ''', _fechaBajaHasta, '''');
	end if;

	if (@filtro <> '') then
		set @consulta = concat(@consulta, ' where ', @filtro);
	end if;
	set @consulta = concat(@consulta, ' order by e.nombreApellido');
    
	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @consulta;
	-- ejecutamos el Statement
	EXECUTE smpt;
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;
END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getEstudiantesByIdClase
DELIMITER //
CREATE PROCEDURE `getEstudiantesByIdClase`(
	IN `_idClase` INT,
	IN `_año` INT,
	IN `_mes` INT
)
BEGIN

	SELECT distinct e.*
	FROM reciboClase rc
	INNER JOIN recibo r ON r.idRecibo = rc.idRecibo
	INNER JOIN estudiante e ON e.idEstudiante = r.idEstudiante
	WHERE
		rc.idClase = _idClase AND year(r.fecha) = _año AND
		(month(r.fecha) = _mes OR (month(r.fecha) = (_mes -1) AND r.proximoMes = 1));

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getFacturasByFilter
DELIMITER //
CREATE PROCEDURE `getFacturasByFilter`(
	IN `_numeroFactura` INT,
	IN `_cliente` VARCHAR(50),
	IN `_total` FLOAT,
	IN `_fechaDesde` DATE,
	IN `_fechaHasta` DATE
)
BEGIN

	set @filtro = '';
	
	/*En el select se coloca el formato fecha como: "m/d/y" ya que necesita este formato el objeto date de javascript*/
   
	set @consulta = 'select f.idFactura, f.numeroFactura, f.idEstudiante, f.idEmpresa, DATE_FORMAT(f.fecha,''%m/%d/%Y'') as fecha, ';
	set @consulta = CONCAT(@consulta, 'f.cliente, f.cuit, f.domicilio, f.localidad, f.telefono, f.respNoInscripto, f.respInscripto, ');
	set @consulta = CONCAT(@consulta, 'f.exento, f.noResponsable, f.consumidorFinal, f.respMonotributista, f.contado, ');
	set @consulta = CONCAT(@consulta, 'f.cuentaCorriente, f.numeroRemito, f.detalle, f.total, ');
	set @consulta = CONCAT(@consulta, 'es.nombreApellido as est_nombre, es.email as est_email, es.celular as est_celular, es.telefono as est_telefono, ');
	set @consulta = CONCAT(@consulta, 'em.razonSocial as emp_razonSocial, em.email as emp_email, em.cuit as emp_cuit, em.telefono as emp_telefono, ');
	set @consulta = CONCAT(@consulta, 'em.domicilio as emp_domicilio, em.localidad as emp_localidad ');
	set @consulta = CONCAT(@consulta, 'from factura f ');
	set @consulta = CONCAT(@consulta, 'left join estudiante es on es.idEstudiante = f.idEstudiante ');
	set @consulta = CONCAT(@consulta, 'left join empresa em on em.idEmpresa = f.idEmpresa');
	 
	if (_numeroFactura <> '' and _numeroFactura is not null and _numeroFactura <> 0) then
		set @filtro = concat('f.numeroFactura = ', _numeroFactura);
	end if;
	 
	 if (_cliente <> '' && _cliente is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	     end if;
		set @filtro = concat(@filtro, 'f.cliente like ''%', _cliente, '%''');
	end if;
	 
	if (_total <> '' and _total is not null and _total <> 0) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	     end if;
		set @filtro = concat(@filtro, 'f.total = ', _total);
	end if;
	 
	if (_fechaDesde is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	     end if;
		set @filtro = concat(@filtro, 'f.fecha >= ''', _fechaDesde, '''');
	end if;
	 
	if (_fechaHasta is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	     end if;
		set @filtro = concat(@filtro, 'f.fecha <= ''', _fechaHasta, '''');
	end if;
	
	if (@filtro <> '') then
		set @consulta = concat(@consulta, ' where ', @filtro);
	end if;
	set @consulta = concat(@consulta, ' order by f.numeroFactura desc');
	
	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @consulta;
	-- ejecutamos el Statement
	EXECUTE smpt;
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getGenero_All
DELIMITER //
CREATE PROCEDURE `getGenero_All`()
BEGIN

	SELECT idGenero, Nombre from genero;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getIdsEmpleadosForComprobanteDePago
DELIMITER //
CREATE PROCEDURE `getIdsEmpleadosForComprobanteDePago`(
	IN `_mes` INT,
	IN `_año` INT


)
BEGIN

SELECT DISTINCT c.idEmpleado
FROM reciboclase rc 
INNER JOIN clase c ON c.idClase = rc.idClase
INNER JOIN recibo r ON r.idRecibo = rc.idRecibo
WHERE
	MONTH(r.fecha) = _mes AND 
	YEAR(r.fecha) = _año AND NOT ISNULL(c.idEmpleado)
UNION
select distinct ee.idEmpleado
from factura f
inner join empresaEmpleado ee on ee.idEmpresa = f.idEmpresa
left JOIN recibo r ON r.idFactura = f.idFactura
WHERE
	MONTH(r.fecha) = _mes AND 
	YEAR(r.fecha) = _año AND NOT ISNULL(ee.idEmpleado)
UNION
select e.idGestor 
from factura f
inner join empresa e on e.idEmpresa = f.idEmpresa
left JOIN recibo r ON r.idFactura = f.idFactura
WHERE
	MONTH(r.fecha) = _mes AND 
	YEAR(r.fecha) = _año AND NOT ISNULL(e.idGestor);

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getLiquidacionSueldoByFilter
DELIMITER //
CREATE PROCEDURE `getLiquidacionSueldoByFilter`(
	IN `_mes` INT,
	IN `_año` INT,
	IN `_empNombreApellido` VARCHAR(50),
	IN `_valor` INT,
	IN `_observaciones` VARCHAR(50)

)
BEGIN

	set @filtro = '';
	   
	set @consulta = 'select ls.idLiquidacionSueldo, ls.mes, ls.año, ifnull(ls.idEmpleado, 0) as idEmpleado, ls.valor, ls.observaciones, ';
	set @consulta = CONCAT(@consulta, 'ifnull(e.nombreApellido, ''Satsanga'') as emp_nombreApellido ');
	set @consulta = CONCAT(@consulta, 'from liquidacionsueldo ls ');
	set @consulta = CONCAT(@consulta, 'left join empleado e on e.idEmpleado = ls.idEmpleado ');
	 
	if (_mes <> '' and _mes is not null and _mes <> 0) then
		set @filtro = concat('ls.mes = ', _mes);
	end if;
	 
	if (_año <> '' and _año is not null and _año <> 0) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	     end if;
		set @filtro = concat(@filtro, 'ls.año = ', _año);
	end if;
	
	if (_empNombreApellido <> '' && _empNombreApellido is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	     end if;
		set @filtro = concat(@filtro, 'ifnull(e.nombreApellido, ''Satsanga'') like ''%', _empNombreApellido, '%''');
	end if;
	 
	if (_valor <> '' and _valor is not null and _valor <> 0) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	     end if;
		set @filtro = concat(@filtro, 'ls.valor = ', _valor);
	end if;
	 
	if (_observaciones <> '' && _observaciones is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
	     end if;
		set @filtro = concat(@filtro, 'ls.observaciones like ''%', _observaciones, '%''');
	end if;
	
	if (@filtro <> '') then
		set @consulta = concat(@consulta, ' where ', @filtro);
	end if;
	set @consulta = concat(@consulta, ' order by ls.mes desc, ls.año desc');
	
	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @consulta;
	-- ejecutamos el Statement
	EXECUTE smpt;
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getMovimientosCCByIdCajaChica
DELIMITER //
CREATE PROCEDURE `getMovimientosCCByIdCajaChica`(
	IN `_idCajaChica` INT,
	IN `_descripcion` VARCHAR(50),
	IN `_idTipoMovimientoCC` INT

)
BEGIN

	set @filtro = '';
	
	set @consulta = 'SELECT mcc.idMovimientoCajaChica, mcc.descripcion, mcc.valor, mcc.idTipoMovimientoCC, mcc.idRecibo, ';
	set @consulta = concat(@consulta, 'tmcc.nombre AS tmcc_nombre, r.numeroRecibo, r.valor AS valorRecibo, ');
	set @consulta = concat(@consulta, 'a.idAdelanto, e.idEmpleado as empleAdelanto_idEmpleado, e.NombreApellido as empleAdelanto_NombreApellido ');
	set @consulta = concat(@consulta, 'FROM movimientoCajaChica mcc ');
	set @consulta = concat(@consulta, 'INNER JOIN tipoMovimientoCC tmcc ON tmcc.idTipoMovimientoCC = mcc.idTipoMovimientoCC ');
	set @consulta = concat(@consulta, 'LEFT JOIN recibo r ON r.idRecibo = mcc.idRecibo ');
	set @consulta = concat(@consulta, 'LEFT JOIN adelanto a ON a.idMovimientoCajaChica = mcc.idMovimientoCajaChica ');
	set @consulta = concat(@consulta, 'LEFT JOIN empleado e ON a.idEmpleado = e.idEmpleado');

	set @filtro = concat('mcc.idCajaChica = ', _idCajaChica);
    
   if (_descripcion <> '' and _descripcion is not null) then
		set @filtro = concat(@filtro, ' and mcc.descripcion like ''%', _descripcion, '%''');
	end if;
    
	if (_idTipoMovimientoCC <> '' and _idTipoMovimientoCC <> 0 and _idTipoMovimientoCC is not null) then
		set @filtro = concat(@filtro, ' and mcc.idTipoMovimientoCC = ', _idTipoMovimientoCC);
	end if;

	set @consulta = concat(@consulta, ' where ', @filtro);
	set @consulta = concat(@consulta, ' order by mcc.idMovimientoCajaChica desc');
    
	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @consulta;
	-- ejecutamos el Statement
	EXECUTE smpt;
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getRecibosByFilter
DELIMITER //
CREATE PROCEDURE `getRecibosByFilter`(
	IN `_numeroRecibo` INT(11),
	IN `_nombreEstudiante` VARCHAR(30),
	IN `_valor` INT,
	IN `_fechaDesde` DATE,
	IN `_fechaHasta` DATE,
	IN `_promocion` VARCHAR(15)
)
BEGIN
	set @filtro = '';
	
    /*En el select se coloca el formato fecha como: "m/d/y" ya que necesita este formato el objeto date de javascript*/
    
	set @consulta = 'select r.idRecibo, r.fecha, DATE_FORMAT(r.fecha,''%m/%d/%Y'') as fecha, r.valor, r.numeroRecibo, ';
	set @consulta = concat(@consulta, 'r.vecesPorSemana, r.observaciones, r.idEstudiante, e.nombreApellido as est_NombreApellido, ');
	set @consulta = concat(@consulta, 'r.idFactura, f.numeroFactura as fact_numeroFactura, f.fecha as fact_fecha, f.cuit as fact_cuit, ');
	set @consulta = concat(@consulta, 'f.detalle as fact_detalle, f.total as fact_total, f.cliente as fact_cliente, r.promocion, ');
	set @consulta = concat(@consulta, 'r.proximoMes ');
	set @consulta = concat(@consulta, 'from recibo r ');
	set @consulta = concat(@consulta, 'left join estudiante e on e.idEstudiante = r.idEstudiante ');
	set @consulta = concat(@consulta, 'left join factura f on f.idFactura = r.idFactura ');
    
	if (_numeroRecibo <> '' and _numeroRecibo <> 0 and _numeroRecibo is not null) then
		set @filtro = concat('r.numeroRecibo = ', _numeroRecibo);
	end if;
    
	if (_nombreEstudiante <> '' and _nombreEstudiante is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
   	end if;
		set @filtro = concat(@filtro, 'e.nombreApellido like ''%', _nombreEstudiante, '%''');
	end if;
	
	if (_promocion <> '' and _promocion is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
		end if;
		set @filtro = concat(@filtro, 'r.promocion like ''%', _promocion, '%''');
	end if;
    
	if (_valor <> '' and _valor is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
      end if;
		set @filtro = concat(@filtro, 'r.valor = ', _valor);
	end if;
    
	if (_fechaDesde is not null) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
   	end if;
		set @filtro = concat(@filtro, 'r.fecha >= ''', _fechaDesde, '''');
	end if;
    
	if (_fechaHasta is not NULL) then
		if (@filtro <> '') then
			set @filtro = concat(@filtro, ' and ');
		end if;
		set @filtro = concat(@filtro, 'r.fecha <= ''', _fechaHasta, '''');
	end if;

	if (@filtro <> '') then
		set @consulta = concat(@consulta, ' where ', @filtro);
	end if;
	set @consulta = concat(@consulta, ' order by r.numeroRecibo desc');
    
	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @consulta;
	-- ejecutamos el Statement
	EXECUTE smpt;
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;
END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getRecibosIncompletos
DELIMITER //
CREATE PROCEDURE `getRecibosIncompletos`()
BEGIN	
	/*En el select se coloca el formato fecha como: "m/d/y" ya que necesita este formato el objeto date de javascript*/
	set @consulta = 'select r.idRecibo, r.fecha, DATE_FORMAT(r.fecha,''%m/%d/%Y'') as fecha, r.valor, r.numeroRecibo, ';
	set @consulta = concat(@consulta, 'r.vecesPorSemana, r.observaciones, r.idEstudiante, e.nombreApellido as est_NombreApellido, ');
	set @consulta = concat(@consulta, 'r.idFactura, f.numeroFactura as fact_numeroFactura, f.fecha as fact_fecha, f.cuit as fact_cuit, ');
	set @consulta = concat(@consulta, 'f.detalle as fact_detalle, f.total as fact_total, f.cliente as fact_cliente, r.promocion, ');
	set @consulta = concat(@consulta, 'r.proximoMes ');
	set @consulta = concat(@consulta, 'from recibo r ');
	set @consulta = concat(@consulta, 'left join estudiante e on e.idEstudiante = r.idEstudiante ');
	set @consulta = concat(@consulta, 'left join factura f on f.idFactura = r.idFactura ');
    
	set @consulta = concat(@consulta, 'where r.idEstudiante is null and r.idFactura is null ');
	set @consulta = concat(@consulta, 'and r.idRecibo not in (select distinct rc.idRecibo from reciboClase rc) ');
	set @consulta = concat(@consulta, 'order by r.numeroRecibo desc');
    
	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @consulta;
	-- ejecutamos el Statement
	EXECUTE smpt;
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;
	-- select @consulta;
END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getTipoEgresoFijo_All
DELIMITER //
CREATE PROCEDURE `getTipoEgresoFijo_All`()
BEGIN

	select idTipoEgresoFijo, nombre
	from tipoEgresoFijo;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getTipoEmpleado_All
DELIMITER //
CREATE PROCEDURE `getTipoEmpleado_All`()
BEGIN

	SELECT idTipoEmpleado, Nombre, Descripcion from tipoEmpleado;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getTipoMovimientoCC_All
DELIMITER //
CREATE PROCEDURE `getTipoMovimientoCC_All`()
BEGIN
	SELECT idTipoMovimientoCC, nombre FROM tipoMovimientoCC WHERE nombre = 'Recibo'
	UNION
	SELECT idTipoMovimientoCC, nombre FROM tipoMovimientoCC WHERE nombre = 'Venta del Shop'
	UNION
	SELECT idTipoMovimientoCC, nombre FROM tipoMovimientoCC WHERE nombre = 'Egreso'
	UNION
	SELECT idTipoMovimientoCC, nombre FROM tipoMovimientoCC WHERE nombre = 'Retiro'
	UNION
	SELECT idTipoMovimientoCC, nombre FROM tipoMovimientoCC WHERE nombre = 'Adelanto'
	UNION
	SELECT idTipoMovimientoCC, nombre FROM tipoMovimientoCC WHERE nombre = 'Ingreso'
	UNION
	SELECT idTipoMovimientoCC, nombre FROM tipoMovimientoCC 
	WHERE nombre <> 'Ingreso' AND nombre <> 'Adelanto' AND nombre <> 'Venta del Shop' AND nombre <> 'Egreso' AND nombre <> 'Recibo' AND nombre <> 'Retiro';
END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.getUsuarioByLogin
DELIMITER //
CREATE PROCEDURE `getUsuarioByLogin`(
	IN `_nombreUsuario` VARCHAR(20),
	IN `_password` VARCHAR(255)
)
BEGIN

	SELECT u.idUsuario, u.NombreUsuario, u.Password
	from usuario u
	where
   	u.NombreUsuario = _nombreUsuario and u.Password = _password;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.setAdelanto
DELIMITER //
CREATE PROCEDURE `setAdelanto`(
	IN `_idAdelanto` INT,
	IN `_idMovimientoCajaChica` INT,
	IN `_idEmpleado` INT


,
	IN `_fecha` DATE
,
	IN `_idCajaGrande` INT

)
BEGIN
	set @queryInsertUpdate = '';
	set @idMovCC = '';
	set @idCajaG = '';
	
	if (_idMovimientoCajaChica = 0 OR _idMovimientoCajaChica is null) then
		set @idMovCC = 'null';
	else
		set @idMovCC = _idMovimientoCajaChica;
	end if;
	
	if (_idCajaGrande = 0 OR _idCajaGrande is null) then
		set @idCajaG = 'null';
	else
		set @idCajaG = _idCajaGrande;
	end if;
	
	if (_idAdelanto = '0' or _idAdelanto = 0) then
		set @queryInsertUpdate = 'insert into adelanto (idMovimientoCajaChica, idEmpleado, fecha, idCajaGrande) values (';
		set @queryInsertUpdate = concat(@queryInsertUpdate, @idMovCC, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, _idEmpleado, ', ''');
		set @queryInsertUpdate = concat(@queryInsertUpdate, _fecha, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, @idCajaG, ')');
	else
		set @queryInsertUpdate = 'update adelanto set ';
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idMovimientoCajaChica = ', @idMovCC, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idEmpleado = ', _idEmpleado, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'fecha = ''', _fecha, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idCajaGrande = ', @idCajaG);
		set @queryInsertUpdate = concat(@queryInsertUpdate, ' where idAdelanto = ', _idAdelanto);
	end if;

	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @queryInsertUpdate;
	-- ejecutamos el Statement
	EXECUTE smpt;
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;
   -- select @queryInsertUpdate;
END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.setCajaChica
DELIMITER //
CREATE PROCEDURE `setCajaChica`(
	IN `_idCajaChica` INT,
	IN `_apertura` DATETIME,
	IN `_cierre` DATETIME,
	IN `_idEmpleado` INT,
	IN `_valorInicial` INT




)
BEGIN

	set @queryInsertUpdate = '';
	/*set @valorInicial = 0;*/
	
	set @proxValor = 0;
	set @idMax = 0;

	if (_idCajaChica = '0' or _idCajaChica = 0) then
		set @idMax = (select IFNULL(MAX(idCajaChica), 0) from cajaChica);
		set @proxValor = (SELECT (IFNULL(cc.valorInicial, 0) + IFNULL(SUM(mcc.valor), 0))
								FROM movimientoCajaChica mcc 
								INNER JOIN cajaChica cc on cc.idCajaChica = mcc.idCajaChica
								where mcc.idCajaChica = @idMax);
				
		set @queryInsertUpdate = 'insert into cajaChica (apertura, cierre, idEmpleado, valorInicial) values (';
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _apertura, ''', ');
		
		if (NOT ISNULL(_cierre)) then
			set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _cierre, ''', ');
		else
			set @queryInsertUpdate = concat(@queryInsertUpdate, 'null, ');
		end if;

		set @queryInsertUpdate = concat(@queryInsertUpdate, _idEmpleado, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, @proxValor, ')');
	else
		set @queryInsertUpdate = 'update cajaChica set ';
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'apertura = ''', _apertura, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'cierre = ''', _cierre, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idEmpleado = ', _idEmpleado, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'valorInicial = ', _valorInicial);
		set @queryInsertUpdate = concat(@queryInsertUpdate, ' where idCajaChica = ', _idCajaChica);
	end if;

	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @queryInsertUpdate;
	-- ejecutamos el Statement
	EXECUTE smpt;
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;
   -- select @queryInsertUpdate;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.setCajaGrande
DELIMITER //
CREATE PROCEDURE `setCajaGrande`(
	IN `_idCajaGrande` INT,
	IN `_idTipoEgresoFijo` INT,
	IN `_idMovimientoCajaChica` INT,
	IN `_fecha` DATE,
	IN `_observacion` VARCHAR(50),
	IN `_valor` INT


,
	IN `_idAdelanto` INT,
	IN `_idEmpleado` INT


)
BEGIN
	declare valor int default 0;
	declare idTipoEgresoAdelanto int;
	declare lastIdCajaG BIGINT;
	
	set @queryInsertUpdate = '';
	set @idTipoEgresoFijo = '';
	set @idMovimientoCajaChica = '';
	
	if (_idTipoEgresoFijo = 0) then
		set @idTipoEgresoFijo = 'null';
	else
		set @idTipoEgresoFijo = _idTipoEgresoFijo;
	end if;
	
	if (_idMovimientoCajaChica = 0 or _idMovimientoCajaChica is null) then
		set @idMovimientoCajaChica = 'null';
	else
		set @idMovimientoCajaChica = _idMovimientoCajaChica;
	end if;
	
	if (_idTipoEgresoFijo <> 0 and _idTipoEgresoFijo is not null and _valor > 0) then
		set valor = (_valor * -1);
	else
		set valor = _valor;
	end if;
	
	set idTipoEgresoAdelanto = (select idTipoEgresoFijo from tipoEgresoFijo where nombre = 'Adelanto');
	
	if (_idCajaGrande = '0' or _idCajaGrande = 0) then
		set @queryInsertUpdate = 'insert into cajaGrande (idTipoEgresoFijo, idMovimientoCajaChica, fecha, observacion, valor) values (';
		set @queryInsertUpdate = concat(@queryInsertUpdate, @idTipoEgresoFijo, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, @idMovimientoCajaChica, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _fecha, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _observacion, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, valor, ' )');
	else
		set @queryInsertUpdate = 'update cajaGrande set ';
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idTipoEgresoFijo = ', @idTipoEgresoFijo, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idMovimientoCajaChica = ', @idMovimientoCajaChica, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'fecha = ''', _fecha, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'observacion = ''', _observacion, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'valor = ', valor);
		set @queryInsertUpdate = concat(@queryInsertUpdate, ' where idCajaGrande = ', _idCajaGrande);
	end if;

	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @queryInsertUpdate;
	-- ejecutamos el Statement
	EXECUTE smpt;
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;
   -- select @queryInsertUpdate;
   
   if (_idCajaGrande = '0' or _idCajaGrande = 0) then
	   set lastIdCajaG = LAST_INSERT_ID();
	else
		set lastIdCajaG = _idCajaGrande;
	end if;
   
	-- Si es del tipo Adelanto insertamos el 'Adelanto'
	if (_idTipoEgresoFijo = idTipoEgresoAdelanto) then
		call setAdelanto(_idAdelanto, null, _idEmpleado, CURDATE(), lastIdCajaG);
	else
		if (_idAdelanto <> 0 or _idAdelanto <> '0' or _idAdelanto is not null) then
			delete from adelanto where idAdelanto = _idAdelanto;
		end if;
	end if;
	
END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.setClase
DELIMITER //
CREATE PROCEDURE `setClase`(
	IN `_idClase` INT,
	IN `_idEmpleado` INT,
	IN `_idEstadoClase` INT,
	IN `_idDia` INT,
	IN `_horaInicio` TIME,
	IN `_horaFin` TIME,
	IN `_descripcion` VARCHAR(255)

)
BEGIN

	set @queryInsertUpdate = '';
	if (_idClase = '0' or _idClase = 0) then
		set @queryInsertUpdate = 'insert into clase (idEmpleado, idEstadoClase, idDia, horaInicio, horaFin, descripcion) values (';
		set @queryInsertUpdate = concat(@queryInsertUpdate, _idEmpleado, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, _idEstadoClase, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, _idDia, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _horaInicio, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _horaFin, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _descripcion, ''')');
	else
		set @queryInsertUpdate = 'update clase set ';
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idEmpleado = ', _idEmpleado, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idEstadoClase = ', _idEstadoClase, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idDia = ', _idDia, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'horaInicio = ''', _horaInicio, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'horaFin = ''', _horaFin, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'descripcion = ''', _descripcion, ''' ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'where idClase = ', _idClase);
	end if;

	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @queryInsertUpdate;
	-- ejecutamos el Statement
	EXECUTE smpt;
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;
   -- select @queryInsertUpdate;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.setClasePrueba
DELIMITER //
CREATE PROCEDURE `setClasePrueba`(
	IN `_idClasePrueba` INT,
	IN `_fecha` DATE,
	IN `_nombre` VARCHAR(50),
	IN `_telefono` VARCHAR(50),
	IN `_email` VARCHAR(255),
	IN `_idClase` INT,
	IN `_asistio` INT,
	IN `_pago` INT,
	IN `_promo` INT,
	IN `_idComoConocio` INT,
	IN `_idComoContacto` INT,
	IN `_observaciones` VARCHAR(255),
	IN `_cancelada` INT
)
BEGIN

	set @queryInsertUpdate = '';
	if (_idClasePrueba = '0' or _idClasePrueba = 0) then
		set @queryInsertUpdate = 'insert into clasePrueba (fecha, nombre, telefono, email, idClase, asistio, pago, promo, idComoConocio, idComoContacto, observaciones, cancelada) values (';
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _fecha, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _nombre, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _telefono, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _email, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, _idClase, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, ifnull(_asistio, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, ifnull(_pago, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, ifnull(_promo, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, _idComoConocio, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, _idComoContacto, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _observaciones, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, _cancelada, ')');
	else
		set @queryInsertUpdate = 'update clasePrueba set ';
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'fecha = ''', _fecha, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'nombre = ''', _nombre, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'telefono = ''', _telefono, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'email = ''', _email, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idClase = ', _idClase, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'asistio = ', ifnull(_asistio, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'pago = ', ifnull(_pago, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'promo = ', ifnull(_promo, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idComoConocio = ', _idComoConocio, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idComoContacto = ', _idComoContacto, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'observaciones = ''', _observaciones, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'cancelada = ', _cancelada, ' ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'where idClasePrueba = ', _idClasePrueba);
	end if;

	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @queryInsertUpdate;
	-- ejecutamos el Statement
	EXECUTE smpt;
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;
   -- select @queryInsertUpdate;

END//


-- Volcando estructura para procedimiento satsanga_dev.setEmpleado
DELIMITER //
CREATE PROCEDURE `setEmpleado`(
in _idEmpleado int(11), 
in _nombreApellido varchar(100), 
in _fechaNacimiento date, 
in _idGenero int, 
in _idEstadoEmpleado int, 
in _idTipoEmpleado int, 
in _email varchar(255), 
in _celular varchar(20), 
in _telefono varchar (20), 
in _fechaAlta date
)
BEGIN

	set @queryInsertUpdate = '';
	if (_idEmpleado = '0' or _idEmpleado = 0) then
		set @queryInsertUpdate = 'insert into empleado (nombreApellido, fechaNacimiento, idGenero, idEstadoEmpleado, idTipoEmpleado, email, celular, telefono, fechaAlta) values (';
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _nombreApellido, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _fechaNacimiento, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, _idGenero, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, _idEstadoEmpleado, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, _idTipoEmpleado, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _email, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _celular, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _telefono, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _fechaAlta, ''')');
	else
		set @queryInsertUpdate = 'update empleado set ';
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'nombreApellido = ''', _nombreApellido, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'fechaNacimiento = ''', _fechaNacimiento, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idGenero = ', _idGenero, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idEstadoEmpleado = ', _idEstadoEmpleado, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idTipoEmpleado = ', _idTipoEmpleado, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'email = ''', _email, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'celular = ''', _celular, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'telefono = ''', _telefono, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'fechaAlta = ''', _fechaAlta, ''' ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'where idEmpleado = ', _idEmpleado);
	end if;

	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @queryInsertUpdate;
	-- ejecutamos el Statement
	EXECUTE smpt;
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;
    -- select @queryInsertUpdate;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.setEmpresa
DELIMITER //
CREATE PROCEDURE `setEmpresa`(
	IN `_idEmpresa` INT,
	IN `_razonSocial` VARCHAR(50),
	IN `_domicilio` VARCHAR(50),
	IN `_localidad` VARCHAR(50),
	IN `_telefono` VARCHAR(20),
	IN `_email` VARCHAR(50),
	IN `_cuit` VARCHAR(20),
	IN `_contacto` VARCHAR(20),
	IN `_observaciones` VARCHAR(100),
	IN `_idGestor` INT




)
BEGIN

	set @queryInsertUpdate = "";
   
	if (_idEmpresa = "0" or _idEmpresa = 0) then
		set @queryInsertUpdate = "insert into empresa (razonSocial, domicilio, localidad, telefono, email, cuit, contacto, observaciones, idGestor) values (";
		set @queryInsertUpdate = concat(@queryInsertUpdate, "'", _razonSocial, "', ");
		set @queryInsertUpdate = concat(@queryInsertUpdate, "'", _domicilio, "', ");
		set @queryInsertUpdate = concat(@queryInsertUpdate, "'", _localidad, "', ");
		set @queryInsertUpdate = concat(@queryInsertUpdate, "'", _telefono, "', ");
		set @queryInsertUpdate = concat(@queryInsertUpdate, "'", _email, "', ");
		set @queryInsertUpdate = concat(@queryInsertUpdate, "'", _cuit, "', ");
		set @queryInsertUpdate = concat(@queryInsertUpdate, "'", _contacto, "', ");
		set @queryInsertUpdate = concat(@queryInsertUpdate, "'", _observaciones, "', ");
		set @queryInsertUpdate = concat(@queryInsertUpdate, ifnull(_idGestor, "null"), ")");
	else
		set @queryInsertUpdate = "update empresa set ";
		set @queryInsertUpdate = concat(@queryInsertUpdate, "razonSocial = '", _razonSocial, "', ");
		set @queryInsertUpdate = concat(@queryInsertUpdate, "domicilio = '", _domicilio, "', ");
		set @queryInsertUpdate = concat(@queryInsertUpdate, "localidad = '", _localidad, "', ");
		set @queryInsertUpdate = concat(@queryInsertUpdate, "telefono = '", _telefono, "', ");
		set @queryInsertUpdate = concat(@queryInsertUpdate, "email = '", _email, "', ");
		set @queryInsertUpdate = concat(@queryInsertUpdate, "cuit = '", _cuit, "', ");
		set @queryInsertUpdate = concat(@queryInsertUpdate, "contacto = '", _contacto, "', ");
		set @queryInsertUpdate = concat(@queryInsertUpdate, "observaciones = '", _observaciones, "', ");
		set @queryInsertUpdate = concat(@queryInsertUpdate, "idGestor = ", ifnull(_idGestor, "null"));
		set @queryInsertUpdate = concat(@queryInsertUpdate, " where idEmpresa = ", _idEmpresa);
	end if;
	
	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @queryInsertUpdate;
	-- ejecutamos el Statement
	EXECUTE smpt;
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.setEstudiante
DELIMITER //
CREATE PROCEDURE `setEstudiante`(
	IN `_idEstudiante` int(11),
	IN `_nombreApellido` varchar(255),
	IN `_fechaNacimiento` date,
	IN `_idGenero` int,
	IN `_idEstadoEstudiante` int,
	IN `_idComoConocio` int,
	IN `_email` varchar(255),
	IN `_observaciones` VARCHAR(255),
	IN `_celular` varchar(20),
	IN `_telefono` varchar(20),
	IN `_fechaAlta` date


,
	IN `_fechaBaja` DATE





)
BEGIN

	/*declare @queryInsertUpdate text;*/
	set @queryInsertUpdate = '';
   set @fechaBaja = '';
   set @idEstado_old = 0;
   
   /*if(isnull(_fechaBaja)) then
   	set @fechaBaja = 'null';
   else
   	set @fechaBaja = concat('''', _fechaBaja, '''');
   end if;*/
   
	if (_idEstudiante = '0' or _idEstudiante = 0) then
		if (_idEstadoEstudiante = 1) then
			set @fechaBaja = 'null';
		else
			if (_idEstadoEstudiante = 3) then
				set @fechaBaja = concat('''', current_date() , '''');
			end if;
		end if;
	
		set @queryInsertUpdate = 'insert into estudiante (nombreApellido, fechaNacimiento, idGenero, idEstadoEstudiante, idComoConocio, email, observaciones, celular, telefono, fechaAlta, fechaBaja) values (';
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _nombreApellido, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _fechaNacimiento, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, _idGenero, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, _idEstadoEstudiante, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, _idComoConocio, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'lower(''', _email, '''), ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _observaciones, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _celular, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _telefono, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _fechaAlta, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, @fechaBaja, ')');
	else
		set @idEstado_old = (select idEstadoEstudiante from estudiante where idEstudiante = _idEstudiante);
		-- estado = 1 -> activo; estado = 3 -> inactivo
		if (@idEstado_old = 3 and _idEstadoEstudiante = 1) then
			set @fechaBaja = 'null';
		else
			if (@idEstado_old = 1 and _idEstadoEstudiante = 3) then
				set @fechaBaja = concat('''', current_date() , '''');
			else
				if(isnull(_fechaBaja)) then
			   	set @fechaBaja = 'null';
			   else
			   	set @fechaBaja = concat('''', _fechaBaja, '''');
			   end if;
			end if;
		end if;
	
		set @queryInsertUpdate = 'update estudiante set ';
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'nombreApellido = ''', _nombreApellido, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'fechaNacimiento = ''', _fechaNacimiento, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idGenero = ', _idGenero, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idEstadoEstudiante = ', _idEstadoEstudiante, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idComoConocio = ', _idComoConocio, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'email = lower(''', _email, '''), ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'observaciones = ''', _observaciones, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'celular = ''', _celular, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'telefono = ''', _telefono, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'fechaAlta = ''', _fechaAlta, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'fechaBaja = ', @fechaBaja);
		set @queryInsertUpdate = concat(@queryInsertUpdate, ' where idEstudiante = ', _idEstudiante);
	end if;
	
	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @queryInsertUpdate;
	-- ejecutamos el Statement
	EXECUTE smpt;
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;
END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.setFactura
DELIMITER //
CREATE PROCEDURE `setFactura`(
	IN `_idFactura` INT,
	IN `_numeroFactura` INT,
	IN `_idEstudiante` INT,
	IN `_idEmpresa` INT,
	IN `_fecha` DATE,
	IN `_cliente` VARCHAR(50),
	IN `_cuit` VARCHAR(20),
	IN `_domicilio` VARCHAR(50),
	IN `_localidad` VARCHAR(20),
	IN `_telefono` VARCHAR(20),
	IN `_respNoInscripto` TINYINT,
	IN `_respInscripto` TINYINT,
	IN `_exento` TINYINT,
	IN `_noResponsable` TINYINT,
	IN `_consumidorFinal` TINYINT,
	IN `_respMonotributista` TINYINT,
	IN `_contado` TINYINT,
	IN `_cuentaCorriente` TINYINT,
	IN `_numeroRemito` INT,
	IN `_detalle` VARCHAR(200),
	IN `_total` FLOAT


)
BEGIN

	set @queryInsertUpdate = '';
   
	if (_idFactura = '0' or _idFactura = 0) then
		set @queryInsertUpdate = 'insert into factura (numeroFactura, idEstudiante, idEmpresa, fecha, cliente, cuit, domicilio, localidad, telefono, respNoInscripto, respInscripto, exento, noResponsable, consumidorFinal, respMonotributista, contado, cuentaCorriente, numeroRemito, detalle, total) values (';
		set @queryInsertUpdate = concat(@queryInsertUpdate, _numeroFactura, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, ifnull(_idEstudiante, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, ifnull(_idEmpresa, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _fecha, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _cliente, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _cuit, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _domicilio, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _localidad, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _telefono, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, ifnull(_respNoInscripto, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, ifnull(_respInscripto, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, ifnull(_exento, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, ifnull(_noResponsable, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, ifnull(_consumidorFinal, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, ifnull(_respMonotributista, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, ifnull(_contado, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, ifnull(_cuentaCorriente, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, ifnull(_numeroRemito, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _detalle, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, _total, ')');
	else
		set @queryInsertUpdate = 'update factura set ';
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'numeroFactura = ', _numeroFactura, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idEstudiante = ', ifnull(_idEstudiante, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idEmpresa = ', ifnull(_idEmpresa, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'fecha = ''', _fecha, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'cliente = ''', _cliente, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'cuit = ''', _cuit, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'domicilio = ''', _domicilio, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'localidad = ''', _localidad, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'telefono = ''', _telefono, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'respNoInscripto = ', ifnull(_respNoInscripto, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'respInscripto = ', ifnull(_respInscripto, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'exento = ', ifnull(_exento, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'noResponsable = ', ifnull(_noResponsable, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'consumidorFinal = ', ifnull(_consumidorFinal, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'respMonotributista = ', ifnull(_respMonotributista, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'contado = ', ifnull(_contado, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'cuentaCorriente = ', ifnull(_cuentaCorriente, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'numeroRemito = ', ifnull(_numeroRemito, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'detalle = ''', _detalle, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'total = ', _total);
		set @queryInsertUpdate = concat(@queryInsertUpdate, ' where idFactura = ', _idFactura);
	end if;
	
	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @queryInsertUpdate;
	-- ejecutamos el Statement
	EXECUTE smpt;
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.setLiquidacionSueldo
DELIMITER //
CREATE PROCEDURE `setLiquidacionSueldo`(
	IN `_idLiquidacionSueldo` INT,
	IN `_mes` INT,
	IN `_año` INT,
	IN `_idEmpleado` INT,
	IN `_valor` FLOAT,
	IN `_observaciones` VARCHAR(50)


)
BEGIN

	set @queryInsertUpdate = '';
   
	if (_idLiquidacionSueldo = '0' or _idLiquidacionSueldo = 0) then
		set @queryInsertUpdate = 'insert into liquidacionsueldo (mes, año, idEmpleado, valor, observaciones) values (';
		set @queryInsertUpdate = concat(@queryInsertUpdate, _mes, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, _año, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, _idEmpleado, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, _valor, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _observaciones, ''')');
	else
		set @queryInsertUpdate = 'update liquidacionsueldo set ';
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'mes = ', _mes, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'año = ', _año, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idEmpleado = ', _idEmpleado, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'valor = ', _valor, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'observaciones = ''', _observaciones, '''');
		set @queryInsertUpdate = concat(@queryInsertUpdate, ' where idLiquidacionSueldo = ', _idLiquidacionSueldo);
	end if;
	
	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @queryInsertUpdate;
	-- ejecutamos el Statement
	EXECUTE smpt;
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;

END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.setMovimientoCajaChica
DELIMITER //
CREATE PROCEDURE `setMovimientoCajaChica`(
	IN `_idMovimientoCajaChica` INT,
	IN `_idCajaChica` INT,
	IN `_idTipoMovimientoCC` INT,
	IN `_idRecibo` INT,
	IN `_descripcion` VARCHAR(50),
	IN `_valor` INT










,
	IN `_idAdelanto` INT,
	IN `_idEmpleado` INT






)
BEGIN
	declare lastIdRecibo BIGINT;
	declare lastIdMovCC BIGINT;
	declare lastIdTipoMovimientoCC int default 0;
	
	declare idTipoMovRecibo int default null;
	declare idTipoMovRetiro int;
	declare idTipoMovEgreso int;
	declare idTipoMovAdelanto int;
	declare valor int;
	
	set @queryInsertUpdate = '';
	
	set idTipoMovRecibo = (select idTipoMovimientoCC from tipoMovimientoCC where nombre = 'Recibo');
	set idTipoMovReTiro = (select idTipoMovimientoCC from tipoMovimientoCC where nombre = 'Retiro');
	set idTipoMovEgreso = (select idTipoMovimientoCC from tipoMovimientoCC where nombre = 'Egreso');
	set idTipoMovAdelanto = (select idTipoMovimientoCC from tipoMovimientoCC where nombre = 'Adelanto');
	
	-- Verificamos si se trata de una edición en el registro
	if (_idMovimientoCajaChica <> '0' or _idMovimientoCajaChica <> 0) then
		set lastIdTipoMovimientoCC = (select idTipoMovimientoCC from movimientoCajaChica where idMovimientoCajaChica = _idMovimientoCajaChica);
		-- dependendiendo de que tipoMovimiento era realizamos el eliminado de los registros que no son necesarios
		-- 1)Sí se trataba de un 'Adelanto' y ahora cambia a otro tipo, eliminamos el adelanto viejo
		if (lastIdTipoMovimientoCC = idTipoMovAdelanto and _idTipoMovimientoCC <> idTipoMovAdelanto) then
			delete from adelanto where idMovimientoCajaChica = _idMovimientoCajaChica;
		else
			-- 2)Sí se trataba de un 'Recibo' y ahora cambia a otro tipo, eliminamos el recibo viejo y
			-- seteamos como null en el idRecibo del Movimiento
			if (lastIdTipoMovimientoCC = idTipoMovRecibo and _idTipoMovimientoCC <> idTipoMovRecibo) then
				delete from recibo where idRecibo = (select idRecibo from movimientoCajaChica where idMovimientoCajaChica = _idMovimientoCajaChica);
				set _idRecibo = null;
			else
				-- 3)Sí se trataba de un 'Retiro' y ahora cambia a otro tipo, eliminamos el ingreso que se había realizado en la cajaGrande
				if (lastIdTipoMovimientoCC = idTipoMovReTiro and _idTipoMovimientoCC <> idTipoMovReTiro) then
					delete from cajaGrande where idMovimientoCajaChica = _idMovimientoCajaChica;
				end if;
			end if;
		end if;
	end if;
	
	-- Siendo un Egreso, un Retiro o un Adelanto insertamos el valor como negativo
	if (_idTipoMovimientoCC = idTipoMovReTiro and _valor > 0) then
		set valor = (_valor * -1);
	else 
		if (_idTipoMovimientoCC = idTipoMovEgreso and _valor > 0) then
			set valor = (_valor * -1);
		else
			if (_idTipoMovimientoCC = idTipoMovAdelanto and _valor > 0) then
				set valor = (_valor * -1);
			else
				set valor = _valor;
			end if;
		end if;
	end if;
	
	-- Verificamos tipoMovimientoCC y sí es del tipo 'Recibo', primero insertamos el mismo
	if (_idTipoMovimientoCC = idTipoMovRecibo and _idRecibo = 0) then
		call setRecibo(0, 0, CURDATE(), null, 0, 'Recibo generado automaticamente', valor, '', '', null, 0);
		set lastIdRecibo = LAST_INSERT_ID();
	else
		if (_idRecibo = '0' or _idRecibo = 0 or _idRecibo is null) then
		   set lastIdRecibo = null;
		else
		   set lastIdRecibo = _idRecibo;
	   end if;
	end if;
	
	if (_idMovimientoCajaChica = '0' or _idMovimientoCajaChica = 0) then
		set @queryInsertUpdate = 'insert into movimientoCajaChica (idCajaChica, idTipoMovimientoCC, idRecibo, descripcion, valor) values (';
		set @queryInsertUpdate = concat(@queryInsertUpdate, _idCajaChica, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, _idTipoMovimientoCC, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, ifnull(lastIdRecibo, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _descripcion, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, valor, ' )');
	else
		set @queryInsertUpdate = 'update movimientoCajaChica set ';
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idCajaChica = ', _idCajaChica, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idTipoMovimientoCC = ', _idTipoMovimientoCC, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idRecibo = ', ifnull(lastIdRecibo, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'descripcion = ''', _descripcion, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'valor = ', valor);
		set @queryInsertUpdate = concat(@queryInsertUpdate, ' where idMovimientoCajaChica = ', _idMovimientoCajaChica);
	end if;

	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @queryInsertUpdate;
	-- ejecutamos el Statement
	EXECUTE smpt;
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;
	
   -- select @queryInsertUpdate;
   
   if (_idMovimientoCajaChica = '0' or _idMovimientoCajaChica = 0) then
	   set lastIdMovCC = LAST_INSERT_ID();
	else
		set lastIdMovCC = _idMovimientoCajaChica;
	end if;
	
   
   -- Verificamos tipoMovimientoCC y sí es del tipo 'Retiro' insertamos el ingreso en la cajaGrande
	if (_idTipoMovimientoCC = idTipoMovReTiro) then
		call setCajaGrande(0, 0, lastIdMovCC, CURDATE(), 'Ingreso a la caja!', (valor * -1), null, null);
	else
		-- Si es del tipo Adelanto insertamos el 'Adelanto'
		if (_idTipoMovimientoCC = idTipoMovAdelanto) then
			call setAdelanto(_idAdelanto, lastIdMovCC, _idEmpleado, CURDATE(), null);
		end if;
	end if;
	
END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.setRecibo
DELIMITER //
CREATE PROCEDURE `setRecibo`(
	IN `_idRecibo` BIGINT,
	IN `_numeroRecibo` INT,
	IN `_fecha` DATE,
	IN `_idEstudiante` BIGINT,
	IN `_vecesPorSemana` INT,
	IN `_observaciones` VARCHAR(100),
	IN `_valor` INT,
	IN `_idsClases` VARCHAR(100)

,
	IN `_promocion` VARCHAR(15)
,
	IN `_idFactura` INT







,
	IN `_proximoMes` TINYINT
)
BEGIN
	declare lastIdRecibo BIGINT;
	declare numeroReciboNuevo int;
	set @queryInsertUpdate = '';
	
	if (_numeroRecibo = '0' or _numeroRecibo = 0) then
		set numeroReciboNuevo = (select MAX(numeroRecibo) + 1 from recibo);
	else
		set numeroReciboNuevo = _numeroRecibo;
	end if;
	
	if (_idRecibo = '0' or _idRecibo = 0) then
		set @queryInsertUpdate = 'insert into recibo (numeroRecibo, fecha, idEstudiante, vecesPorSemana, observaciones, valor, idFactura, promocion, proximoMes) values (';
		set @queryInsertUpdate = concat(@queryInsertUpdate, numeroReciboNuevo, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _fecha, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, ifnull(_idEstudiante, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, _vecesPorSemana, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _observaciones, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, _valor, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, ifnull(_idFactura, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, '''', _promocion, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, _proximoMes, ')');
	else
		set @queryInsertUpdate = 'update recibo set ';
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'numeroRecibo = ''', numeroReciboNuevo, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'fecha = ''', _fecha, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idEstudiante = ', ifnull(_idEstudiante, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'vecesPorSemana = ', _vecesPorSemana, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'observaciones = ''', _observaciones, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'valor = ', _valor, ',  ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'idFactura = ', ifnull(_idFactura, 'null'), ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'promocion = ''', _promocion, ''', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, 'proximoMes = ', _proximoMes);
		set @queryInsertUpdate = concat(@queryInsertUpdate, ' where idRecibo = ', _idRecibo);
	end if;

	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @queryInsertUpdate;
	-- ejecutamos el Statement
	EXECUTE smpt;
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;
   -- select @queryInsertUpdate;
   
   if (_idsClases <> '') then
	   if (_idRecibo = '0' or _idRecibo = 0) then
		   set lastIdRecibo = LAST_INSERT_ID();
		else
		   set lastIdRecibo = _idRecibo;
	   end if;
	   
	   call setReciboClase(lastIdRecibo, _idsClases);
	end if;
END//
DELIMITER ;

-- Volcando estructura para procedimiento satsanga_dev.setReciboClase
DELIMITER //
CREATE PROCEDURE `setReciboClase`(
	IN `_idRecibo` BIGINT,
	IN `_idsClases` VARCHAR(100)
)
BEGIN

	declare contador int default 0;
	declare cantClases int default 0;
	declare IdClase int default 0;
	declare ids varchar(100);

	set ids = _idsClases;
	set @queryInsertUpdate = '';
	-- Primero eliminamos las clases asociadas al recibo
	set @queryInsertUpdate = concat('delete from reciboclase where idRecibo = ', _idRecibo, ';');
	-- preparamos el objeto Statement a partir de nuestra variable
	PREPARE smpt FROM @queryInsertUpdate;
	-- ejecutamos el Statement
	EXECUTE smpt;
	
	
	#Primeramente cuento cuantas comas ',' hay en la cadena asi se cuantas vueltas dar.
	SELECT LENGTH(_idsClases) - LENGTH(REPLACE(ids, ',', '')) into cantClases;

	#Ahora que se cuantas comas ',' hay que separan cada codigo, hago el while para recorrer e ir sacando cada codigo del string.

	WHILE contador  <= cantClases DO
		#Separo cada numero de codigo pero en la primera vuelta (contador = 0) saco el
		#primer codigo hasta la primer coma ','
		
		if contador = 0 then
			set IdClase = CAST(SUBSTRING_INDEX(ids, ',', 1) as unsigned);            	
		else 
			#Ya que pasamos la primer vuelta, voy achicando el _idsClases asi siempre
			#Saco los primeros digitos hasta la primer coma, es como si saco y achico, saco y
			#achico.......
			-- set ids = REPLACE(ids, CONCAT(SUBSTRING_INDEX(ids, ',', 1), ','), "");
			-- set IdClase = CAST(SUBSTRING_INDEX(ids, ',', contador + 1) as unsigned);
			set idClase = ltrim(replace(substring(substring_index(ids, ',', contador + 1), length(substring_index(ids, ',', contador)) + 1), ',', ''));
		end if;
		      
		set contador = contador + 1;
		
		#Aqui comenzaria el codigo de ustedes, sabiendo que en la variable IdClase esta quedando
		#cada codigo que se va tomando de la variable o parametro ids que está seteada con _idsClases
		set @queryInsertUpdate = 'insert into reciboclase (idRecibo, idClase) values (';
		set @queryInsertUpdate = concat(@queryInsertUpdate, _idRecibo, ', ');
		set @queryInsertUpdate = concat(@queryInsertUpdate, IdClase, ');');
		-- preparamos el objeto Statement a partir de nuestra variable
		PREPARE smpt FROM @queryInsertUpdate;
		-- ejecutamos el Statement
		EXECUTE smpt;

	END WHILE;
	
	-- liberamos la memoria
	DEALLOCATE PREPARE smpt;
	-- select @queryInsertUpdate;
END//
DELIMITER ;

DELIMITER //
CREATE PROCEDURE `getBalanceCajaGrande`(
	IN `_año` INT,
	IN `_mes` INT
)
BEGIN
   
SET @_where = '';
set @consulta = 'SELECT YEAR(cg.fecha) año, MONTH(cg.fecha) mes, ';
set @consulta = CONCAT(@consulta, '(SELECT SUM(cg1.valor) FROM cajaGrande cg1 ');
set @consulta = CONCAT(@consulta, 'WHERE cg1.idTipoEgresoFijo IS NULL AND cg1.idMovimientoCajaChica IS NOT NULL AND ');
set @consulta = CONCAT(@consulta, 'YEAR(cg1.fecha) = YEAR(cg.fecha) AND MONTH(cg1.fecha) = MONTH(cg.fecha)) AS ingresos, ');
set @consulta = CONCAT(@consulta, '(SELECT SUM(cg2.valor) FROM cajaGrande cg2 ');
set @consulta = CONCAT(@consulta, 'WHERE cg2.idMovimientoCajaChica IS NULL AND cg2.idTipoEgresoFijo IS NOT NULL AND ');
set @consulta = CONCAT(@consulta, 'YEAR(cg2.fecha) = YEAR(cg.fecha) AND MONTH(cg2.fecha) = MONTH(cg.fecha)) AS egresos, ');
set @consulta = CONCAT(@consulta, 'SUM(cg.valor) AS utilidadMes ');
set @consulta = CONCAT(@consulta, 'FROM cajaGrande cg ');

IF (_año IS NOT NULL AND _año <> 0) THEN
	set @_where = CONCAT(@_where, 'YEAR(cg.fecha) = ', _año);
END IF;

IF (_mes IS NOT NULL AND _mes <> 0) THEN
	IF (@_where <> '') THEN
		set @_where = CONCAT(@_where, ' and ');
	END iF;
	set @_where = CONCAT(@_where, 'MONTH(cg.fecha) = ', _mes);
END IF;

IF (@_where <> '') THEN
	set @consulta = CONCAT(@consulta, 'WHERE ', @_where, ' ');
END IF;

set @consulta = CONCAT(@consulta, 'GROUP BY YEAR(cg.fecha), MONTH(cg.fecha) ORDER BY YEAR(cg.fecha) desc, MONTH(cg.fecha) desc');

-- preparamos el objeto Statement a partir de nuestra variable
PREPARE smpt FROM @consulta;
-- ejecutamos el Statement
EXECUTE smpt;
-- liberamos la memoria
DEALLOCATE PREPARE smpt;

END//
DELIMITER ;


/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
