<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DB
 *
 * @author linux
 */
namespace App\Sys;
require 'Helper.php';

use App\Sys\Helper;

class DB extends PDO{

    private $stmt;
    static private $_instance=null;
    function __construct(){

        $dbconf=$this->getConfig();

        $dsn=$dbconf['driver'].':host='.$dbconf['dbhost'].';dbname='.$dbconf['dbname'];
        $usr=$dbconf['dbuser'];
        $pwd=$dbconf['dbpass'];

        parent::__construct($dsn,$usr,$pwd);
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    static function getInstance(){
        if(!(self::$_instance instanceof self)){
            self::$_instance=new self();
        }
        return self::$_instance;
    }

    private function getConfig(): array {
        $json = file_get_contents(__DIR__."/../Config.json");
        return (array) json_decode($json);
    }
    private function getParam($param){
            $tipo = gettype($param);
            $res = 0;

            switch($tipo) {
                case "integer":
                    $res = PDO::PARAM_INT;
                    break;
                case "boolean":
                     $res = PDO::PARAM_BOOL;
                     break;
                case "string":
                    $res = PDO::PARAM_STR;
                    break;
                default:
                    $res = PDO::PARAM_NULL;
            }
            return $res;
        }
    public function query(string $querys){
        $this->stmt = parent::prepare($querys);
    }

    public function bind ($param,$value,$type=null) {
      if($type == null) {
          $type = $this->getParam($val);
      }

      $this->stmt->bindValue($param, $value, $type);
    }
    public function execute (){
        return $this->stmt->execute();
    }
    /*PREGUNTAR*/
    public function resultSet(){
       return $this -> $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }
    public function single(){
        return  $this-> $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }
    public function rowCount(){
	     return  $this-> $stmt -> rowCount();

    }
    public function lastInsertId($tabla =null){
	     return parent::lastInsertId($tabla);
    }
    public function debugDumpParams(){
	     $this-> $stmt -> debugDumpParams();
    }
   public function beginTransaction(){
        return parent::beginTransaction();
    }
    public function endTransaction(){
        return parent::commit();
    }
    public function cancelTransaction(){
        return parent::rollBack();
    }
}
