<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 18/12/17
 * Time: 16:33
 */

class Default_TesteBoletoController extends Zend_Controller_Action
{

    private $session_login;
    private $session_gog;
    private $urlPDFServer = "http://qsaudevantagens.com.br:8080";
    //private $urlPDFServer = "http://localhost:8080";
    private $post;
    private $dateEmissao;
    private $dateVencimentoTit;
    private $price;
    private $idBoleto = array();

    public function init()
    {

        $this->session_gog = new Zend_Session_Namespace('Gog');
        $this->session_login = new Zend_Session_Namespace('LoginGog');
        if ($this->session_login->logado == NULL) {
            $this->session_login->logado = false;
        }
        $this->_helper->layout->setLayout("nova");

    }

    public function geraUmRealAction(){
        $modelConfiguracao = new Admin_Model_DbTable_Configuracao();
        $dataConfiguracao = $modelConfiguracao->getAll();
        //$htmlArray = $this->execCurlServer(1);
        $nameFile = $this->getParam("id");
        $path = $dataConfiguracao[0]["nm_url_absoluta"] . "/site/html/boleto/".$nameFile.".html";
        $htmlArray[0] = file_get_contents($path);
        var_dump("Gerou Boleto!");
        $pdfArray = array();
        for($i=0; $i<count($htmlArray); $i++){
            $this->createPDF($htmlArray[$i], $dataConfiguracao, $nameFile."new");
            $pdfArray[$i] = $nameFile.".pdf";
        }
        var_dump("teste!");exit;
        $pdf = Zend_Pdf::load($dataConfiguracao[0]["nm_url_absoluta"] . "/site/pdf/boleto/".$nameFile."new.pdf");
        unset($pdf->pages[0]);
        $pdf->save($dataConfiguracao[0]["nm_url_absoluta"] . "/site/pdf/boleto/".$nameFile."new.pdf");
        die(json_encode(array("session" => true)));
    }

    private function createPDF($html, $dataConfiguracao, $name){
        $filePath = $dataConfiguracao[0]["nm_url_absoluta"] . "/site/html/boleto/".$name.".html";
        $html = $this->replaceHtml($html);
        $myfile = fopen($filePath, "w") or die("Unable to open file!");
        fwrite($myfile, pack("CCC",0xef,0xbb,0xbf));
        fwrite($myfile, $html);
        fclose($myfile);
        $filePathCSS = $dataConfiguracao[0]["nm_url_absoluta"] . "/site/css/boleto.css";
        $filePathOut = $dataConfiguracao[0]["nm_url_absoluta"] . "/site/pdf/boleto/".$name.".pdf";
        $this->createPDFByPath($filePathCSS, $filePath, $filePathOut);
    }

    private function createPDFByPath($css, $html, $out){
        $css = "-".$this->setUri($css);
        $html = "-".$this->setUri($html);
        $out = "-".$this->setUri($out);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->urlPDFServer."/servletQSaude/rest/pdf/css/".$css."/html/".$html."/out/".$out);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "admin:1qaz2wsx");
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_POST, FALSE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getPostBoleto($post, $dataContratoGog));
        curl_exec($ch);
        curl_close($ch);
    }

    public function ajaxTeesteAction(){
        $modelConfiguracao = new Admin_Model_DbTable_Configuracao();
        $dataConfiguracao = $modelConfiguracao->getAll();
        $filePath = $dataConfiguracao[0]["nm_url_absoluta"] . "/site/html/boleto/37.html";
        $content = file_get_contents($filePath);
        $this->createPDF($content, $dataConfiguracao, "37");
        die(json_encode(array("session" => true)));
    }

    private function replaceHtml($htmlcontent){
        $dom = new DOMDocument('1.0', 'utf-8');
        libxml_use_internal_errors(true);
        @$dom->loadHTML(mb_convert_encoding($htmlcontent, 'HTML-ENTITIES', 'UTF-8'));
        $htmlcontent = str_replace("barra.JPG", "../../images/boleto/barra.jpg", $htmlcontent);
        $htmlcontent = str_replace("img1.JPG", "../../images/boleto/img1.JPG", $htmlcontent);
        $htmlcontent = str_replace("img2.JPG", "../../images/boleto/img2.JPG", $htmlcontent);
        $htmlcontent = str_replace("linhaPontilhada.JPG", "../../images/boleto/linhaPontilhada.JPG", $htmlcontent);
        $htmlcontent = str_replace("q_do_qsaude.png", "../../images/boleto/q_do_qsaude.png", $htmlcontent);
        $htmlcontent = str_replace("sicooblogo.gif", "../../images/boleto/sicooblogo.gif", $htmlcontent);
        $htmlcontent = $this->putLogo($htmlcontent);
        //$htmlcontent = $this->replaceStringBetween($htmlcontent, '<style type="text/css">', '</style>');
        $htmlcontent = str_replace('<style type="text/css">', '<link rel="stylesheet" href="../../css/boleto.css">', $htmlcontent);
        $htmlcontent = str_replace('</style>', '', $htmlcontent);
        $htmlcontent = mb_convert_encoding($htmlcontent, 'HTML-ENTITIES', "UTF-8");
        //$htmlcontent = $this->removeLastOccurenceOfChar("&#65533;", $htmlcontent);
        //$htmlcontent = str_replace("&#65533;", "á", $htmlcontent);
        //$htmlcontent = str_replace("#65533;", "", $htmlcontent);
        //$htmlcontent = str_replace("GOIáNIA-GO", "GOIÂNIA-GO", $htmlcontent);
        return $htmlcontent;
    }

    private function execTesteCurlServer($filePath, $filePathClean){
        $this->urlPDFServer = "http://192.168.20.25:8080";
        $htmlArray = array();
        for($i=0; $i<2; $i++) {
            $this->dateEmissao[$i]=Util_Util::getDateBoleto(null, $i);
            $this->dateVencimentoTit[$i]=Util_Util::getDateBoleto(5, $i);
            if($i==0){
                $htmlcontent = file_get_contents($filePath);
            }else{
                $htmlcontent = file_get_contents($filePathClean);
            }
            $htmlArray[$i] = $htmlcontent;
        }
        return $htmlArray;
    }

    private function execCurlServer($nuVezes=null){
        $htmlArray = array();
        $n = ($nuVezes==null)?$this->post["nu_vezes"]:$nuVezes;
        for($i=0; $i<intval($n); $i++) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://geraboleto.sicoobnet.com.br/geradorBoleto/GerarBoleto.do");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getPostBoleto($this->post, $i));
            $htmlcontent = curl_exec($ch);
            curl_close($ch);
            $htmlArray[$i] = $htmlcontent;
        }
        return $htmlArray;
    }

    private function getPostBoleto($post, $i){
        return "numCliente=420611&coopCartao=5004&chaveAcessoWeb=41123378-4592-4C04-BBA9-3147A82DF87F&numContaCorrente=1131001&codMunicipio=26242&bolRecebeBoletoEletronico=1&codTipoVencimento=1&valorAbatimento=0&bolAceite=1&percTaxaMulta=0&percTaxaMora=0&codEspDocumento=DM&valorPrimDesconto=0&valorSegDesconto=0&nomeSacado=Tony&cpfCGC=00702786101&dataNascimento=19861124&endereco=C5&bairro=Taguatinga&cidade=Brasilia&cep=72010050&uf=DF&telefone=999081239&ddd=61&ramal=77&email=tabx.php@gmail.com&dataEmissao=20171219&seuNumero=7&nomeSacador=Q%20Sa%FAde%20Vantagens&numCGCCPFSacador=29139123000190&qntMonetaria=1&valorTitulo=1&dataVencimentoTit=20171221&descInstrucao1=%23%23%23logo%23%23%23&descInstrucao2=%20&descInstrucao3=%20&descInstrucao4=%20";
        //return "numCliente=420611&coopCartao=5004&chaveAcessoWeb=41123378-4592-4C04-BBA9-3147A82DF87F&numContaCorrente=1131001&codMunicipio=26242&bolRecebeBoletoEletronico=1&codTipoVencimento=1&valorAbatimento=0&bolAceite=1&percTaxaMulta=0&percTaxaMora=0&codEspDocumento=DM&valorPrimDesconto=0&valorSegDesconto=0&nomeSacado=".$post["nomeSacado"]."&cpfCGC=".$post["cpfCGC"]."&dataNascimento=".$post["dataNascimento"]."&endereco=".$post["endereco"]."&bairro=".$post["bairro"]."&cidade=".$post["cidade"]."&cep=".$post["cep"]."&uf=".$post["uf"]."&telefone=".$post["telefone"]."&ddd=".$post["ddd"]."&ramal=77&email=".$post["email"]."&dataEmissao=".$this->dateEmissao[0]["boleto"]."&seuNumero=".$post["nuBoleto"][$i]."&nomeSacador=Q%20Sa%FAde%20Vantagens&numCGCCPFSacador=29139123000190&qntMonetaria=1&valorTitulo=1&dataVencimentoTit=".$this->dateVencimentoTit[$i]["boleto"]."&descInstrucao1=%23%23%23logo%23%23%23&descInstrucao2=%20&descInstrucao3=%20&descInstrucao4=%20";
    }

    private function removeLastOccurenceOfChar($char, $string)
    {
        if( ($pos = strrpos($string, $char)) !== FALSE) {
            return substr_replace($string, 'ú', $pos, 1);
        }
        return $string;
    }

    private function getPriceByContratoGOG($idContratoGOG){
        $modelContratoGog = new Default_Model_DbTable_ContratoGog();
        $dataContratoGog=$modelContratoGog->getContratoGog($idContratoGOG);
        return $dataContratoGog;
    }

    private function replaceStringBetween($string, $start, $end){
        $html = $string;
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        $string = substr($string, $ini, $len);
        return str_replace($string, "", $html);
    }

    private function putLogo($html){
        $htmlReplace  = '<div style="float:right; margin-top: -22px; margin-right: 4px;">';
        $htmlReplace .= '    <span style="margin-top:-3px; float:left;"><img src="../../images/boleto/q_do_qsaude.png" width="37"></span>';
        $htmlReplace .= '    <span style="font-family:ERASB; font-size:27px; color:#0390fd; float:left; margin-right:-47px;">sa&uacute;de</span>';
        $htmlReplace .= '    <span style="font-family:KGAlwaysAGoodTime; font-size:12px; color:#0390fd; float:left; margin-top:27px;">Vantagens</span>';
        $htmlReplace .= '</div>';
        return str_replace("###logo###", $htmlReplace, $html);
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

}