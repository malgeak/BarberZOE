# BarberZOE
PROYECTO EXPERIMENTAL
Para presentar en el TESCHA por TEAM Sam/@malgeak/Joelira/@adzlbroo
Este proyecto es para Ingeniería en Sistemas Computacionales.

Objetivos
Crear un Sistema de Administración de productos y materiales para la Barbería “Barber Shop Zoe” que satisfaga las necesidades del negocio.
Así mismo, permitirle llevar un registro de ventas, gastos y ganancias.
Como complemento desarrollar una agenda que permita insertar, registrar y eliminar eventos próximos

Planeación
Este proyecto comenzó buscando algún cliente que necesitará de algún sistema que le permitiera llevar el control y administración de su negocio, y entre algunos conocidos, nos encontramos con el dueño de Barber Shop Zoe, quien pidió un Sistema para llevar el control de el inventario, así como también llevar el control de gastos y ventas, las demás funciones ya fueron parte de nosotros.

Lenguajes:
PHP 7.x
MYSQL (Anteriormente PostgreSQL)
Javascript (Framework W3.JS)
CSS3 (Framework W3.CSS)

Visual:
HTML5

MONTADO:
Servidor barberzoe.omcodem.com (INACTIVO 24/10/18 HASTA 4/11/18)

GUÍA DE "INSTALACIÓN"
EL proyecto se puede descomprimir en cualquier carpeta que permita el sistema de archivos de php, es necesario recordar la RUTA ABSOLUTA de donde se descomprime, se utilizará en las
configuraciones.
Para configurar la conexión con postgresql es necesario crear manualmente la base de datos, el nombre con el que se crea la base de datos se guardará en el archivo “config.php” que se encuentra en la carpeta raíz del archivo a descomprimir.
El archivo “config.php” es el único que requiere modificaciones, a continuación se muestran las
requeridas.

Cambia por equipo en el que se instala:
	$user = "postgres"; //Usuario de Shell SQL
	$pass = "tescha"; //Contraseña de Shell SQL
	$dbname = "barberzoe"; //CREAR MANUALMENTE EN PostgreSQL-
	$port = "5433"; //Cambiar si es necesario
	$host = "localhost";
	$negocio = "Barber Shop ZOE"; //Nombre del negocio

-Es el mismo nombre que utilizamos para crear la base de datos manualmente desde la consola de
comandos.

Carpeta en la que se encuentra el proyecto--
$raiz = "/";
-- Si el archivo .rar es descomprimido en una subcarpeta es necesario colocar la ruta raíz en $raiz,
por ejemplo si descomprimes este .rar en la carpeta proyectoBarber la ruta sería:
$raiz = "proyectoBarber/";

Tiempo de redireccion---
$tiempoRedir = 0; //Segundos en redireccionar
---Si se desea visualizar los cambios realizados entre tablas se cambia el valor de $tiempoRedir, está marcado en segundos así que poner 60 es un minuto que tarda en redireccionar de vuelta a las tablas. -> Recomendado dejarlo en 0
Y ya está, el archivo “database.php” genera las tablas de la base de datos y el proyecto va
generando lo necesario para que funcione correctamente.