<?php

/**
| Created by: Filipe Mota de Sá - pihh.rocks@gmail.com
| Date: 26/03/2016
| Time: 23:07
| Description: Database methods interface
 */

interface iConnection{
    static function connect();
    static function setup_connection();
}