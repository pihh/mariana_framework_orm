<?php

/**
| Created by: Filipe Mota de Sá - pihh.rocks@gmail.com
| Date: 26/03/2016
| Time: 22:07
 */

interface iProcesses
{
    // Static functions
    public static function where();
    public static function find();
    public static function first();
    public static function last();
    public static function raw();
    public static function all();

    // Functions
    public function also();
    public function delete();
    public function select();
    public function join();
    public function save();
    public function get();

    // Joins
    public function hasOne();
    public function hasMany();
    public function manyToMany();

    // Observers and triggers
    public function observe();
    public function broadcast();

    // Array treatment
    public function detatch();
    public function as_array();
    public function as_object();

}