<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 26/09/17
 * Time: 17:14
 */

class Util_CardNumber {

    private $valuesNumber = array(
        1=>array(
            0=>7,
            1=>5,
            2=>1,
            3=>3,
            4=>6,
            5=>9,
            6=>0,
            7=>8,
            8=>2,
            9=>4
        ),
        2=>array(
            0=>2,
            1=>4,
            2=>7,
            3=>9,
            4=>0,
            5=>1,
            6=>3,
            7=>5,
            8=>8,
            9=>6
        ),
        3=>array(
            0=>4,
            1=>0,
            2=>9,
            3=>6,
            4=>8,
            5=>7,
            6=>1,
            7=>2,
            8=>5,
            9=>3
        ),
        4=>array(
            0=>1,
            1=>9,
            2=>4,
            3=>8,
            4=>2,
            5=>0,
            6=>6,
            7=>3,
            8=>7,
            9=>5
        ),
        5=>array(
            0=>3,
            1=>2,
            2=>8,
            3=>5,
            4=>6,
            5=>7,
            6=>4,
            7=>1,
            8=>2,
            9=>9
        ),
        6=>array(
            0=>8,
            1=>3,
            2=>2,
            3=>0,
            4=>7,
            5=>9,
            6=>1,
            7=>4,
            8=>5,
            9=>6
        ),
        7=>array(
            0=>6,
            1=>8,
            2=>3,
            3=>9,
            4=>2,
            5=>1,
            6=>7,
            7=>5,
            8=>4,
            9=>0
        )
    );

    private $date = "";
    private $dateArray = array();
    private $idCode = "";
    private $id;
    private $idDependente;
    private $numberCard;
    private $valid=0;
    private $checkDependente=false;

    public function __construct($id=null, $idDependente=null){
        $this->date = Util_Util::getDateMysqlNow();
        $this->dateArray = explode("-", $this->date);
        if($id!=null) {
            $this->id = $id;
            $this->setNumberCard();
        }elseif($idDependente!=null){
            $this->idDependente = $idDependente;
            $this->setNumberCard();
        }
    }

    private function getCalcPartDate(){
        return (((intval($this->dateArray[0])*7)+intval($this->dateArray[1])+intval($this->dateArray[2]))-7000);
    }

    private function getMonthPart(){
        $calc = ((intval($this->dateArray[1])*7)+97);
        $d=intval($calc/2);
        if($calc%2==0){
            $this->valid=($this->idDependente==null)?0:2;
        }else{
            $this->valid=($this->idDependente==null)?1:3;
        }
        return $d;
    }

    private function getYearPart(){
        return (intval(substr($this->dateArray[0], -2)));
    }

    private function getCodePart(){
        $id = ($this->id!=null)?$this->id:$this->idDependente;
        $array = str_split($id);
        for($i=1; strlen((string)$id)>=$i; $i++){
            $this->idCode = $this->valuesNumber[$i][$array[$i-1]].$this->idCode;
        }
        $sizeValuesNumber = count($this->valuesNumber);
        $size = intval($sizeValuesNumber) - ($i-1);

        for($j=1; $size >= $j; $j++){
            $this->idCode = $this->valuesNumber[$j+($i-1)][0].$this->idCode;
        }
        return $this->idCode;
    }

    private function setNumberCard(){
        $this->numberCard = $this->getMonthPart().$this->getCalcPartDate().$this->valid.$this->getYearPart().$this->getCodePart();
    }

    public function getNumberCard(){
        return $this->numberCard;
    }

    public function getDateOfCardNumber($numberCard, $checkDependente=false){
        $this->numberCard = $numberCard;
        $this->checkDependente = $checkDependente;
        $this->valid = substr($this->numberCard, -10, 1);
        $ano = $this->getYear();
        $mes = $this->getMonth();
        $dia = $this->getDay($ano, $mes);
        $mes=(strlen($mes."")==1)?"0".$mes:$mes;
        $dia=(strlen($dia."")==1)?"0".$dia:$dia;
        return ($dia.$mes.$ano);
    }

    private function getDay($ano, $mes){
        $fb = intval(substr($this->numberCard, -14, 4));
        return ($fb+7000-(7*$ano)-$mes);
    }

    private function getYear(){
        return (intval(substr($this->numberCard, -9, 2))+2000);
    }

    private function getMonth(){
        $valid = ($this->checkDependente==true)?intval($this->valid-2):$this->valid;
        $fa = ($valid==0)?intval(substr($this->numberCard, -16, 2)):intval(substr($this->numberCard, -16, 2))+0.5;
        return (($fa*2 - (97))/7);
    }

}