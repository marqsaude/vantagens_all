<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyandersonbrinckxavier
 * Date: 05/05/14
 * Time: 15:42
 */


class Util_Util {

    public function getTypeTable($table){
        $tamanho = strlen($table);
        $tamanhoTirar = $tamanho-3;
        return array($table{0}.$table{1}.$table{2}, substr($table, -$tamanhoTirar));
    }

    public static function getDataMysql($data){
        return "'".date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $data)))."'";
    }

    public static function getDataMysqlNoHour($data){
        return "'".date('Y-m-d', strtotime(str_replace('-', '/', $data)))."'";
    }

    public static function getDataSomaNoHour($data){
        return "'".date('Ymd', strtotime(str_replace('-', '/', $data)))."'";
    }

    public static function getDataClient($data){
        return date('d/m/Y H:i:s', strtotime(str_replace('/', '-', $data)));
    }

    public static function getDataClientNoHour($data){
        return date('d/m/Y', strtotime(str_replace('/', '-', $data)));
    }

    public static function getDataMesExtenso(){
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        return strftime('%d de %B de %Y', strtotime('today'));
    }

    public static function getNameController(){
        $controller = Zend_Controller_Front::getInstance();
        return $controller->getRequest()->getControllerName();
    }

    public static function getNameAction(){
        $controller = Zend_Controller_Front::getInstance();
        return $controller->getRequest()->getActionName();
    }

    public static function isMobile() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }

    public static function getDateMysqlNow(){
        return date("Y-m-d");
    }

    public static function getDateBoletoNow($day=null){
        if($day==null) {
            return date("Ymd");
        }else{
            $date = new DateTime('+'.$day.' day');
            return $date->format('Ymd');
        }
    }

    public static function getDateMysqlBoletoNow($day=null){
        if($day==null) {
            return date("Y-m-d");
        }else{
            $date = new DateTime('+'.$day.' day');
            return $date->format('Y-m-d');
        }
    }

    public static function getDateTimeMysqlNow(){
        return date("Y-m-d H:i:s");
    }

    public static function getDateNowClean(){
        return date("YmdHis");
    }

    public static function addMonthToDate($data, $month){
        return date('Y-m-d', strtotime("+".$month." months", strtotime($data)));
    }

    public static function addMonthToDateBoleto($data, $month){
        return date('Ymd', strtotime("+".$month." months", strtotime($data)));
    }

    public static function getDateBoleto($dataAdd=null, $monthAdd=0){
        return array("boleto"=>self::addMonthToDateBoleto(self::getDateBoletoNow($dataAdd), $monthAdd), "banco"=>self::addMonthToDate(self::getDateMysqlBoletoNow($dataAdd), $monthAdd));
    }

    public static function whichOS(){
        if(PHP_OS=="Darwin"){
            return true;
        }else{
            return false;
        }
    }

    public static function changeDateToSql($data){
        return substr($data, -4)."-".substr($data, 3, -5)."-".substr($data, 0, -8);
    }

    public static function justNumbers($c){
        return preg_replace("/[^0-9]/", "",$c);
    }

    public static function getGenerateCode(){
        $array = array('A','B','C','D','E','F','G','H','I','J','L','M','N','O','P','Q','R','S','T','U','V','X','Z','0','1','2','3','4','5','6','7','8','9');
        $rand_keys = self::array_random($array, 17);
        $code="";
        foreach($rand_keys as $value){
            $code.=$value;
        }
        return $code;
    }

    private static function array_random($arr, $num = 1) {
        shuffle($arr);

        $r = array();
        for ($i = 0; $i < $num; $i++) {
            $r[] = $arr[$i];
        }
        return $num == 1 ? $r[0] : $r;
    }

    public static function strReplaceFirst($from, $to, $subject)
    {
        $from = '/'.preg_quote($from, '/').'/';

        return preg_replace($from, $to, $subject, 1);
    }

    public static function isAjax(){
        $isAjax=false;
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            $isAjax=true;
        }else{
            $isAjax=false;
        }
        return $isAjax;
    }

    public static function getDateNameDayNameMonth($date){
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        try {
            $var_DateTime = strtotime($date);
            return strftime('%A, %d, de %B de %Y', $var_DateTime);
        }catch (Exception $e){
            echo "Data Informada errada!";
            return null;
        }
    }

    public static function getTextMinBlog($text, $sizeOn=200){
        $size = strlen($text);
        if($size > $sizeOn){
            $menos = $size - $sizeOn;
            $textReturn = substr($text, 0, -$menos)."...";
            return $textReturn;
        }else{
            return $text;
        }
    }

    public static function organizeCPF($cpf){
        $cpf = substr_replace($cpf, ".", 3, 0);
        $cpf = substr_replace($cpf, ".", 7, 0);
        $cpf = substr_replace($cpf, "-", 11, 0);
        return $cpf;
    }

    public static function organizePrice($value){
        $value = str_replace(".", "", $value);
        $value = substr_replace($value, ".", (strlen($value)-2), 0);
        return floatval($value);
    }

    public static function getBrowserName(){
        $ExactBrowserNameUA=$_SERVER['HTTP_USER_AGENT'];

        if (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "opr/")) {
            // OPERA
            $ExactBrowserNameBR="Opera";
        } elseIf (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "chrome/")) {
            // CHROME
            $ExactBrowserNameBR="Chrome";
        } elseIf (strpos(strtolower($ExactBrowserNameUA), "msie")) {
            // INTERNET EXPLORER
            $ExactBrowserNameBR="Internet Explorer";
        } elseIf (strpos(strtolower($ExactBrowserNameUA), "firefox/")) {
            // FIREFOX
            $ExactBrowserNameBR="Firefox";
        } elseIf (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "opr/")==false and strpos(strtolower($ExactBrowserNameUA), "chrome/")==false) {
            // SAFARI
            $ExactBrowserNameBR="Safari";
        } else {
            // OUT OF DATA
            $ExactBrowserNameBR="OUT OF DATA";
        };

        return $ExactBrowserNameBR;
    }


} 