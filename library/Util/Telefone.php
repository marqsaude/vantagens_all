<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 15/09/17
 * Time: 17:35
 */

class Util_Telefone {

    private $dataRL=array();
    private $modelRL=null;
    private $telefonesExistentes=null;
    private $i=0;
    private $dataTelefone = array();

    function __construct(){

    }

    public function registraTelefone($arrayTelefone, $type, $id){
        foreach($arrayTelefone as $key=>$value){
            $modelTelefone = new Default_Model_DbTable_Telefone();
            $this->setModelRL($type);
            $this->dataTelefone = array();
            if($value!=false){
                $this->dataTelefone["nu_telefone"] = substr($value, 5);
                $this->dataTelefone["nu_telefone"] = str_replace("-", "", $this->dataTelefone["nu_telefone"]);
                $this->dataTelefone["nu_ddd"] = substr($value, 1, 2);
                $dataTelefone = $modelTelefone->getByTelefone($this->dataTelefone["nu_telefone"], $this->dataTelefone["nu_ddd"]);
                if(count($dataTelefone)==0) {
                    switch ($key) {
                        case "nu_telefone":
                            $this->dataTelefone["tp_telefone"] = "T";
                            break;
                        case "nu_celular":
                            $this->dataTelefone["tp_telefone"] = "C";
                            break;
                        case "nu_whatsapp":
                            $this->dataTelefone["tp_telefone"] = "W";
                            break;
                    }
                    $modelDdd = new Default_Model_DbTable_Ddd();
                    $dataDdd=$modelDdd->getDdd($this->dataTelefone["nu_ddd"]);
                    $this->dataTelefone["co_ddd"] = $dataDdd[0]["co_seq_ddd"];
                    $this->dataRL["co_telefone"] = $modelTelefone->telefone->insertOne($this->dataTelefone);
                    $this->dataRL["co_".$type] = $id;
                    $this->modelRL->{$type.'Telefone'}->insertOne($this->dataRL);
                }else{
                    $this->dataRL["co_telefone"] = $dataTelefone[0]["co_seq_telefone"];
                    $this->dataRL["co_".$type] = $id;
                    $this->modelRL->{$type.'Telefone'}->insertOne($this->dataRL);
                    $this->telefonesExistentes[$this->i] = array("Telefone"=>$this->dataTelefone["nu_telefone"], "DDD"=>$this->dataTelefone["nu_ddd"]);
                }
            }
            $this->i++;
        }
        return $this->telefonesExistentes;
    }

    private function setModelRL($type){
        if($type=="contato"){
            $this->modelRL = new Default_Model_DbTable_RLContatoTelefone();
        }else if($type=="cliente"){
            $this->modelRL = new Default_Model_DbTable_RLClienteTelefone();
        }
    }

    private function splitTelefone($arrayTelefone){

    }

}