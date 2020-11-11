<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 16/02/16
 * Time: 10:56
 */

class Admin_Model_Indexador_ExameIndexado {

    //private $urlRest = "http://192.168.1.73:8080/servletIndexador/rest/exames/";
    private $urlRest = "http://201.48.29.225:8080/servletIndexador/rest/exames/";
    private $username = "tabx";
    private $password = "123";

    public function init(){

    }

    public function getObjectJson($nuAtendimento){
        //$url = "http://201.86.129.162:8080/rest/exames/atendimento/".$nuAtendimento;
        $url = $this->urlRest."atendimento/".$nuAtendimento;
        return $this->getReturn($url);
        //$data = json_encode( $vars );
    }

    public function getForPatiente($nuProntural){
        $url = $this->urlRest."paciente/".$nuProntural;
        //var_dump($url);exit;;
        return $this->getReturn($url);
    }

    public function getReturn($url){
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_USERPWD, $this->username . ":" . $this->password);
        curl_setopt($handle, CURLOPT_TIMEOUT, 30);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handle, CURLOPT_POST, false);
        curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'GET');
        //curl_setopt($handle, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($handle);
        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        return $response;
    }

}