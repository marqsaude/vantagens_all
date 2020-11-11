<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 25/02/16
 * Time: 15:24
 */

class Default_IndexController extends Zend_Controller_Action {

    private $session_login;

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->_helper->layout->setLayout("layout");
        $this->view->isMobile = Util_Util::isMobile();
    }

    public function indexAction(){
        $this->view->id = $this->getRequest()->getParam('id');
        $clienteAdmin = new Admin_Model_DbTable_Cliente();
        $clienteAdmin->getClienteByNameCpf("BRAYAN LUCAS ABRANTES", "05867659135");
        //$modelMaisVoce = new Default_Model_DbTable_MaisVoce();
        //$dataMaisVoce = $modelMaisVoce->getAllMaisVoce();
        //$this->view->dataMaisVoce = ($dataMaisVoce==null)?array():$dataMaisVoce;
        //$this->view->countMaisVoce = count($this->view->dataMaisVoce);
        $modelExame = new Default_Model_DbTable_Exame();
        $this->view->dataExame = $modelExame->getAllExame();
        $modelConsulta = new Default_Model_DbTable_Consulta();
        $this->view->dataConsulta = $modelConsulta->getAllConsulta();
        $modelLaboratorio = new Default_Model_DbTable_Laboratorio();
        $this->view->dataLaboratorio = $modelLaboratorio->getAllLaboratorio();
        $modelContratoGog = new Admin_Model_DbTable_ContratoGog();
        $this->view->dataContratoGog = $modelContratoGog->getAllContratoGog();
        //$modelServicos = new Default_Model_DbTable_Servicos();
        //$this->view->dataServicos = $modelServicos->getAllServicos();
        $modelConfiguracao = new Default_Model_DbTable_Configuracao();
        $dataConfiguracao=$modelConfiguracao->getConfigurationAdmin();
        $dirname = $dataConfiguracao["nm_url_absoluta"]."/site/images/galeria-clinicas/thumbnails/";
        $this->view->images = glob($dirname."*.JPG");

        $this->view->session_login = $this->session_login;
        //var_dump("/Application/MAMP/htdocs".$this->view->baseUrl()."/site/images/galeria-clinicas");exit;
        //$this->createThumbs("/Applications/MAMP/htdocs".$this->view->baseUrl()."/site/images/galeria-clinicas/", "/Applications/MAMP/htdocs".$this->view->baseUrl()."/site/images/galeria-clinicas/thumbnails/", 137);

        try{
            //$url[0] = $dataConfiguracao["nm_url_absoluta"] . "/site/html/contratoSingle1.htm";
            //$content[0] = file_get_contents($dataConfiguracao["nm_url_absoluta"] . "/site/html/contratoSingle1.htm");
            $url[0] = $dataConfiguracao["nm_url_absoluta"] . "/site/html/contratoSingle.htm";
            $url[1] = $dataConfiguracao["nm_url_absoluta"] . "/site/html/contratoPlus.htm";
            $url[2] = $dataConfiguracao["nm_url_absoluta"] . "/site/html/contratoMaster.htm";
            $urlOut[0] = $dataConfiguracao["nm_url_absoluta"] . "/site/pdf/contrato/contratoSingle.pdf";
            $urlOut[1] = $dataConfiguracao["nm_url_absoluta"] . "/site/pdf/contrato/contratoPlus.pdf";
            $urlOut[2] = $dataConfiguracao["nm_url_absoluta"] . "/site/pdf/contrato/contratoMaster.pdf";
            $urlTemp[0] = $dataConfiguracao["nm_url_absoluta"] . "/site/html/contratoSingleTemp.htm";
            $urlTemp[1] = $dataConfiguracao["nm_url_absoluta"] . "/site/html/contratoPlusTemp.htm";
            $urlTemp[2] = $dataConfiguracao["nm_url_absoluta"] . "/site/html/contratoMasterTemp.htm";
            $urlCss = $dataConfiguracao["nm_url_absoluta"] . "/site/css/contrato.css";
            $pdf = new Util_PDF($url, $urlOut, $urlCss, $urlTemp);
            //$pdf->generatePDF();
            /*for($i=0; $i<count($content); $i++){
                $q = $i+1;
                $this->createPDF($content[$i], $url[$i], $dataConfiguracao, $q);
            }*/
            //echo "Deu certo!";exit;
        }catch (Exception $e){
            echo $e->getMessage();exit;
        }
    }

    private function createPDF($content, $url, $dataConfiguracao, $q){
        $content = $this->str_replace_first("???????", "Tony Anderson Brinck Xavier, 007.027.861-01, 2484016 e C5 Lote 10 apt 102", $content);
        $content = str_replace("???????", "Tony Anderson Brinck Xavier", $content);
        $filePath = $url;
        //$data = $this->replaceHtml($html);
        $myfile = fopen($filePath, "w") or die("Unable to open file!");
        fwrite($myfile, pack("CCC",0xef,0xbb,0xbf));
        fwrite($myfile, $content);
        fclose($myfile);

        $filePathCSS = $dataConfiguracao["nm_url_absoluta"] . "/site/css/contrato.css";
        $filePathOut = $dataConfiguracao["nm_url_absoluta"] . "/site/pdf/contrato/contratoSingleQtd".$q.".pdf";
        $this->createPDFByPath($filePathCSS, $url, $filePathOut);
    }

    private function createPDFByPath($css, $url, $out){
        $css = "-".$this->setUri($css);
        $html = "-".$this->setUri($url);
        $out = "-".$this->setUri($out);
        $urlPDFServer = "http://localhost:8080";
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $urlPDFServer."/servletQSaude/rest/pdf/css/".$css."/html/".$html."/out/".$out);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "admin:1qaz2wsx");
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_POST, FALSE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getPostBoleto($post, $dataContratoGog));
        curl_exec($ch);
        curl_close($ch);
    }

    private function setUri($string){
        $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
        $b = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';
        $string = utf8_decode($string);
        $string = strtr($string, utf8_decode($a), $b);
        $string = strip_tags(trim($string));
        $string = str_replace(" ","-",$string);
        $string = str_replace(array("-----","----","---","--"),"-",$string);
        return utf8_encode($string);
    }

    private function str_replace_first($from, $to, $subject)
    {
        $from = '/'.preg_quote($from, '/').'/';

        return preg_replace($from, $to, $subject, 1);
    }


    public function arrumaAction(){
        try{
            $modelExame = new Default_Model_DbTable_Exame();
            $dataExame = $modelExame->getAllExame();
            foreach ($dataExame as $value) {
                $modelProcedimento = new Admin_Model_DbTable_Procedimento();
                $mudar["nm_procedimento"] = $value["nm_exame"];
                $modelProcedimento->procedimento->edit($mudar, array("co_exame" => $value["co_seq_exame"]));
            }
            $modelConsulta = new Default_Model_DbTable_Consulta();
            $dataConsulta = $modelConsulta->getAllConsulta();
            foreach ($dataConsulta as $value) {
                $modelProcedimento = new Admin_Model_DbTable_Procedimento();
                $mudar["nm_procedimento"] = $value["nm_consulta"];
                $modelProcedimento->procedimento->edit($mudar, array("co_consulta" => $value["co_seq_consulta"]));
            }
            $modelLaboratorio = new Default_Model_DbTable_Laboratorio();
            $dataLaboratorio = $modelLaboratorio->getAllLaboratorio();
            foreach ($dataLaboratorio as $value) {
                $modelProcedimento = new Admin_Model_DbTable_Procedimento();
                $mudar["nm_procedimento"] = $value["nm_laboratorio"];
                $modelProcedimento->procedimento->edit($mudar, array("co_laboratorio" => $value["co_seq_laboratorio"]));
            }
            var_dump("funcionou");
            exit;
        }catch (Exception $e){
            var_dump("erro");exit;
        }
    }

    private function createThumbs($pathToImages, $pathToThumbs, $thumbWidth )
    {
        // open the directory
        $dir = opendir($pathToImages);

        // loop through it, looking for any/all JPG files:
        while (false !== ($fname = readdir($dir))) {
            // parse path for the extension
            $info = pathinfo($pathToImages . $fname);
            // continue only if this is a JPEG image
            if (strtolower($info['extension']) == 'jpg') {
                echo "Creating thumbnail for {$fname} <br />";

                //var_dump("{$pathToImages}{$fname}");exit;
                // load image and get image size
                $img = imagecreatefromjpeg("{$pathToImages}{$fname}");
                $width = imagesx($img);
                $height = imagesy($img);

                // calculate thumbnail size
                $new_width = $thumbWidth;
                $new_height = floor($height * ($thumbWidth / $width));

                // create a new temporary image
                $tmp_img = imagecreatetruecolor($new_width, $new_height);

                // copy and resize old image into new image
                imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

                // save thumbnail into a file
                imagejpeg($tmp_img, "{$pathToThumbs}{$fname}");

                imagedestroy($tmp_img);
                imagedestroy($img);
            }
        }
        // close the directory
        closedir($dir);
    }

}