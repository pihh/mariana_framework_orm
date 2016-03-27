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

           $config = Config::get('database');
           $driver = $config['driver'];
           $charset = $config['charset'];

           // Fetch parameters

           if ($driver == 'mysql') {
                try {
                    static::$connection = new \PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['database'], $config['username'], $config['password']);
                    static::$connection->setAttribute(\PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    static::$connection_status = self::$connection->getAttribute(PDO::ATTR_CONNECTION_STATUS);
                    static::$connection->query("SET CHARACTER SET $charset");
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    exit;
                }
            }

            if ($driver === 'SQLite3') {
                try {
                    static::$connection = new \PDO('sqlite:'.ROOT.DS.'app'.DS.'files'.DS.'database'.DS.'databases'.DS.$config['database'].'.sq3');
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