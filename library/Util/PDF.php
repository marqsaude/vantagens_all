<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 16/12/17
 * Time: 10:12
 */

class Util_PDF {

    private $urlArray = array();
    private $urlOutArray = array();
    private $urlCss = "";
    private $contentArray = array();
    private $urlPDFServer = "http://localhost:8080";
    private $urlTemp = array();
    private $isSingle = false;

    function __construct($urlArray, $urlOutArray, $urlCss, $urlTemp, $isSingle=false){
        $this->urlArray=$urlArray;
        $this->urlOutArray=$urlOutArray;
        $this->urlCss=$urlCss;
        $this->urlTemp=$urlTemp;
        $this->isSingle = $isSingle;
        if(count($this->urlArray) != count($this->urlOutArray))
            die("Tamanho dos arrays diferentes");
    }

    public function generatePDF($replace){
        $this->urlCss = "-".$this->setUri($this->urlCss);
        for($i=0; $i<count($this->urlArray); $i++) {
            $this->generateContent($i);
            foreach($replace as $key=>$value){
                $this->contentArray[$i] = str_replace($key, $value, $this->contentArray[$i]);
                //$this->contentArray[$i] = str_replace("???????", "Tony Anderson Brinck Xavier", $this->contentArray[$i]);
            }
            $this->contentArray[$i] = $this->replaceHtml($this->contentArray[$i]);
            $myfile = fopen($this->urlTemp[$i], "w") or die("Unable to open file!");
            fwrite($myfile, pack("CCC", 0xef, 0xbb, 0xbf));
            fwrite($myfile, $this->contentArray[$i]);
            fclose($myfile);
            if(!file_exists($this->urlOutArray[0])){
                $this->createPDFByPath($i);
                if($this->isSingle) {
                    chmod($this->urlTemp[$i], 0755);
                    $pdf = Zend_Pdf::load($this->urlOutArray[0]);
                    unset($pdf->pages[0]);
                    $pdf->save($this->urlOutArray[0]);
                }
            }
        }
    }

    private function createPDFByPath($i){
        $html = "-".$this->setUri($this->urlTemp[$i]);
        $out = "-".$this->setUri($this->urlOutArray[$i]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->urlPDFServer."/servletQSaude/rest/pdf/css/".$this->urlCss."/html/".$html."/out/".$out);
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

    private function str_replace_first($from, $to, $subject){
        $from = '/'.preg_quote($from, '/').'/';
        return preg_replace($from, $to, $subject, 1);
    }

    private function generateContent($i){
        $this->contentArray[$i] = file_get_contents($this->urlArray[$i]);
    }

    private function replaceHtml($htmlcontent){
        $dom = new DOMDocument('1.0', 'utf-8');
        libxml_use_internal_errors(true);
        @$dom->loadHTML(mb_convert_encoding($htmlcontent, 'HTML-ENTITIES', 'UTF-8'));
        $htmlcontent = mb_convert_encoding($htmlcontent, 'HTML-ENTITIES', "UTF-8");
        return $htmlcontent;
    }

}