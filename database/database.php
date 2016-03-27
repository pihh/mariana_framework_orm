<?php
/**
| Created by: Filipe Mota de Sá - pihh.rocks@gmail.com
| Date: 26/03/2016
| Time: 23:42
| Requirements:
|  .env file
|  framework configuration
| Description: singleton database
 */

class mDatabase implements iConnection, iDatabase{

    /**
    |---------------------------
    | Properties
    |---------------------------
     */

    private static $instances = array();
    public static $connection;
    public static $connection_status;

    /**
    |---------------------------
    | Gets class instances
    |---------------------------
     */
    public static function get_instance(){

        // late-static-bound class name
        $class = get_called_class();

        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static;
        }

        return self::$instances[$class];
    }

    public static function set_table(){
        // TODO: Implement set_table() method.
    }

    public static function get_table(){
        // TODO: Implement get_table() method.
    }

    public static function connect(){
        if(!static::$connection){
            self::setup_connection();
        }
        return static::$connection;
    }

    public static function setup_connection(){

        // If connection not set
        if(!static::$connection) {


           // Fetch parameters

           if ($_ENV['DB_DRIVER'] == 'mysql') {
                try {
                    static::$connection = new \PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_DATABASE'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
                    static::$connection->setAttribute(\PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    static::$connection_status = self::$connection->getAttribute(PDO::ATTR_CONNECTION_STATUS);
                    static::$connection->query('SET CHARACTER SET '.$_ENV['DB_CHARSET']);
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    exit;
                }
            }

            if ($_ENV['DB_DRIVER'] === 'SQLite3') {
                try {
                    $sq3Path = ROOT.DS.'app'.DS.'files'.DS.'database'.DS.'databases'.DS.$_ENV['DB_DATABASE'].'.sq3';
                    static::$connection = new \PDO('sqlite:'.$sq3Path);
                    static::$connection_status = self::$connection->getAttribute(PDO::ATTR_CONNECTION_STATUS);
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    exit;
                }
            }
        }
        return static::$connection;
    }

}