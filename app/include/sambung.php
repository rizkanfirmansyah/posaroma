<?php //localhost

class DB
{

	/*private static $db_server 	= '192.168.1.4:3306';
	private static $db_port 	= '3306';
	private static $db_database = 'erparoma';
	private static $db_user 	= 'kasir3';
	private static $db_password	= '1qaz2wsx';*/

	private static $db_server 	= 'localhost';
	private static $db_port 	= '3306';
	private static $db_database = 'erp_aroma';
	private static $db_user 	= 'root';
	private static $db_password	= '';

	private static $dbpdo = null;

	public static function create()
	{
		if (self::$dbpdo == null) {
			try {
				//self::$dbpdo = new PDO("mysql:server=".$db_server.";port=".$db_port.";dbname=".self::$db_database.";", self::$db_user, self::$db_password);

				//$dbh = new PDO('mysql:host=hotsname;port=3309;dbname=dbname', 'root', 'root');

				self::$dbpdo = new PDO("mysql:server=" . self::$db_server . ";dbname=" . self::$db_database . ";", self::$db_user, self::$db_password);

				self::$dbpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		}

		return self::$dbpdo;
	}
}
