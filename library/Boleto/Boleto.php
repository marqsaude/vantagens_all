<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 31/01/18
 * Time: 15:42
 */

class Boleto_Boleto {

    private $data;
    private $dataConfiguracao;
    private $idBoletos;
    private $urlPDFServerTest = "http://localhost:8080";
    private $urlPDFServer = "http://marqsaudevantagens.com:8080";
    private $price=0;
    private $dateVencimentoTit;
    private $dateEmissao;
    private $dateEmissaoBanco;
    private $modelBoleto;
    private $code;
    private $pdfArray;
    private $i;
    private $teste=false;
    private $first;

    public function __construct($data, $idBoletos=array(), $i=0, $first=true){
        $this->modelBoleto = new Admin_Model_DbTable_Boleto();
        $this->data = $data;
        $this->i = $i;
        $this->first = $first;
        $this->idBoletos = $idBoletos;
        $modelConfiguracao = new Admin_Model_DbTable_Configuracao();
        $this->dataConfiguracao = $modelConfiguracao->getAll();
        $this->price = $this->data["post"]["price"];
        $this->dateVencimentoTit = $this->data["post"]["dateVencimentoTit"];
        $dateEmissao = Util_Util::getDateBoleto(null, 0);
        $this->dateEmissaoBanco = $dateEmissao["banco"];
        $this->dateEmissao = $dateEmissao["boleto"];
    }

    public function gerar(){
        $htmlArray = array();
        if($this->teste){
            $htmlcontent = $this->testeBoleto();
        }else{
            $htmlcontent = $this->webService();
        }
        $this->createPDF($htmlcontent, $this->i);
        $this->updateBoleto();
        $htmlArray[$this->i] = $htmlcontent;
        $this->pdfArray[$this->i] = $this->idBoletos[$this->i].".pdf";
        if($this->sendEmail()){
            return true;
        }else{
            return false;
        }
    }

    private function webService(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://geraboleto.sicoobnet.com.br/geradorBoleto/GerarBoleto.do");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getPostBoleto(0));
        $htmlcontent = curl_exec($ch);
        curl_close($ch);
        return $htmlcontent;
    }

    private function testeBoleto(){
        return file_get_contents("/Applications/MAMP/htdocs/qsaude/html/site/html/boleto/umRealt.html");
    }

    private function sendEmail(){
        $modelCliente = new Admin_Model_DbTable_Cliente();
        $dataCliente = $modelCliente->getClienteByBoleto($this->idBoletos[$this->i]);
        $this->code = $this->gerarCodigo();
        $emailSendEmail = new Email_SendEmail($dataCliente, $this->code, null, null, $this->teste);
        if($this->first){
            return $emailSendEmail->send($this->pdfArray, $this->dataConfiguracao[0]);
        }else{
            return $emailSendEmail->sendBoleto($this->pdfArray, $this->dataConfiguracao[0]);
        }
    }

    private function getPostBoleto(){
        if($this->first) {
            return "numCliente=420611&coopCartao=5004&chaveAcessoWeb=41123378-4592-4C04-BBA9-3147A82DF87F&numContaCorrente=1131001&codMunicipio=26242&bolRecebeBoletoEletronico=1&codTipoVencimento=1&valorAbatimento=0&bolAceite=1&percTaxaMulta=0&percTaxaMora=0&codEspDocumento=DM&valorPrimDesconto=0&valorSegDesconto=0&nomeSacado=" . $this->data["post"]["nomeSacado"] . "&cpfCGC=" . $this->data["post"]["cpfCGC"] . "&dataNascimento=" . $this->data["post"]["dataNascimento"] . "&endereco=" . $this->data["post"]["endereco"] . "&bairro=" . $this->data["post"]["bairro"] . "&cidade=" . $this->data["post"]["cidade"] . "&cep=" . $this->data["post"]["cep"] . "&uf=" . $this->data["post"]["uf"] . "&telefone=" . $this->data["post"]["telefone"] . "&ddd=" . $this->data["post"]["ddd"] . "&ramal=77&email=" . $this->data["post"]["email"] . "&dataEmissao=" . $this->dateEmissao . "&seuNumero=" . $this->data["post"]["nuBoleto"][$this->i] . "&nomeSacador=Q%20Sa%FAde%20Vantagens&numCGCCPFSacador=29139123000190&qntMonetaria=" . $this->price . "&valorTitulo=" . $this->price . "&dataVencimentoTit=" . $this->dateVencimentoTit[$this->i]["boleto"] . "&descInstrucao1=%23%23%23logo%23%23%23&descInstrucao2=%23%23%23interesttext%23%23%23&descInstrucao3=%20&descInstrucao4=%20";
        }else{
            $this->data["post"]["dataNascimento"] = str_replace("-", "", $this->data["post"]["dataNascimento"]);
            $this->data["post"]["dataNascimento"] = trim($this->data["post"]["dataNascimento"]);
            $this->dateVencimentoTit = str_replace("-", "", $this->dateVencimentoTit);
            $this->dateVencimentoTit = trim($this->dateVencimentoTit);
            return "numCliente=420611&coopCartao=5004&chaveAcessoWeb=41123378-4592-4C04-BBA9-3147A82DF87F&numContaCorrente=1131001&codMunicipio=26242&bolRecebeBoletoEletronico=1&codTipoVencimento=1&valorAbatimento=0&bolAceite=1&percTaxaMulta=0&percTaxaMora=0&codEspDocumento=DM&valorPrimDesconto=0&valorSegDesconto=0&nomeSacado=" . $this->data["post"]["nomeSacado"] . "&cpfCGC=" . $this->data["post"]["cpfCGC"] . "&dataNascimento=" . $this->data["post"]["dataNascimento"] . "&endereco=" . $this->data["post"]["endereco"] . "&bairro=" . $this->data["post"]["bairro"] . "&cidade=" . $this->data["post"]["cidade"] . "&cep=" . $this->data["post"]["cep"] . "&uf=" . $this->data["post"]["uf"] . "&telefone=" . $this->data["post"]["telefone"] . "&ddd=" . $this->data["post"]["ddd"] . "&ramal=77&email=" . $this->data["post"]["email"] . "&dataEmissao=" . $this->dateEmissao . "&seuNumero=" . $this->data["post"]["seuNumero"] . "&nomeSacador=Q%20Sa%FAde%20Vantagens&numCGCCPFSacador=29139123000190&qntMonetaria=" . $this->price . "&valorTitulo=" . $this->price . "&dataVencimentoTit=" . $this->dateVencimentoTit . "&descInstrucao1=%23%23%23logo%23%23%23&descInstrucao2=%23%23%23interesttext%23%23%23&descInstrucao3=%20&descInstrucao4=%20";
        }
    }

    private function createPDF($html, $i){
        $filePath = $this->dataConfiguracao[0]["nm_url_absoluta"] . "/site/html/boleto/".$this->idBoletos[$i].".html";
        $data = $this->replaceHtml($html);
        $myfile = fopen($filePath, "w") or die("Unable to open file!");
        fwrite($myfile, pack("CCC",0xef,0xbb,0xbf));
        fwrite($myfile, $data);
        fclose($myfile);
        $filePathCSS = $this->dataConfiguracao[0]["nm_url_absoluta"] . "/site/css/boleto.css";
        $filePathOut = $this->dataConfiguracao[0]["nm_url_absoluta"] . "/site/pdf/boleto/".$this->idBoletos[$i].".pdf";
        $this->createPDFByPath($filePathCSS, $filePath, $filePathOut);
    }

    private function createPDFByPath($css, $html, $out){
        $css = "-".$this->setUri($css);
        $html = "-".$this->setUri($html);
        $out = "-".$this->setUri($out);
        $ch = curl_init();

        if($this->teste){
            curl_setopt($ch, CURLOPT_URL, $this->urlPDFServerTest."/servletQSaude/rest/pdf/css/".$css."/html/".$html."/out/".$out);
        }else{
            curl_setopt($ch, CURLOPT_URL, $this->urlPDFServer."/servletQSaude/rest/pdf/css/".$css."/html/".$html."/out/".$out);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "admin:1qaz2wsx");
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_POST, FALSE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getPostBoleto($post, $dataContratoGog));
        curl_exec($ch);
        curl_close($ch);
    }

    private function replaceHtml($htmlcontent){
        $dom = new DOMDocument('1.0', 'utf-8');
        libxml_use_internal_errors(true);
        @$dom->loadHTML(mb_convert_encoding($htmlcontent, 'HTML-ENTITIES', 'UTF-8'));
        $htmlcontent = str_replace("barra.JPG", "../../images/boleto/barra.jpg", $htmlcontent);
        $htmlcontent = str_replace("img1.JPG", "../../images/boleto/img1.JPG", $htmlcontent);
        $htmlcontent = str_replace("img2.JPG", "../../images/boleto/img2.JPG", $htmlcontent);
        $htmlcontent = str_replace("linhaPontilhada.JPG", "../../images/boleto/linhaPontilhada.JPG", $htmlcontent);
        $htmlcontent = str_replace("logo_vantagens.png", "../../images/boleto/logo_vantagens.png", $htmlcontent);
        $htmlcontent = str_replace("sicooblogo.gif", "../../images/boleto/sicooblogo.gif", $htmlcontent);
        $htmlcontent = $this->putLogo($htmlcontent);
        $htmlcontent = $this->putInterestText($htmlcontent);
        $htmlcontent = $this->replaceStringBetween($htmlcontent, '<style type="text/css">', '</style>');
        $htmlcontent = str_replace('<style type="text/css">', '<link rel="stylesheet" href="../../css/boleto.css">', $htmlcontent);
        $htmlcontent = str_replace('</style>', '', $htmlcontent);
        $htmlcontent = mb_convert_encoding($htmlcontent, 'HTML-ENTITIES', "UTF-8");
        //$htmlcontent = $this->removeLastOccurenceOfChar("&#65533;", $htmlcontent);
        //$htmlcontent = str_replace("&#65533;", "á", $htmlcontent);
        //$htmlcontent = str_replace("#65533;", "", $htmlcontent);
        //$htmlcontent = str_replace("GOIáNIA-GO", "GOIÂNIA-GO", $htmlcontent);
        return $htmlcontent;
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

    private function putLogo($html){
        $htmlReplace  = '<div style="float:right; margin-top: -22px; margin-right: 4px;">';
        $htmlReplace .= '    <span style="margin-top:-3px; float:left;"><img src="../../images/boleto/logo_vantagens.png" width="37"></span>';
        //$htmlReplace .= '    <span style="font-family:ERASB; font-size:27px; color:#0390fd; float:left; margin-right:-47px;">sa&uacute;de</span>';
        //$htmlReplace .= '    <span style="font-family:KGAlwaysAGoodTime; font-size:12px; color:#0390fd; float:left; margin-top:27px;">Vantagens</span>';
        $htmlReplace .= '</div>';
        return str_replace("###logo###", $htmlReplace, $html);
    }

    private function putInterestText($html){
        $htmlReplace  = '<div style="float:left;">';
        $htmlReplace .= '   <span style="font-size: 9px;">Após o vencimento, pagar somente no banco Sicoob. </span>';
        $htmlReplace .= '   <span style="font-size: 9px;">Após o vencimento, cobrar: </span><br>';
        $htmlReplace .= '   <span style="font-size: 9px;"> - Multa de mora: 0,333% ao dia</span><br>';
        $htmlReplace .= '   <span style="font-size: 9px;"> - JUROS DE 10% AO MÊS</span>';
        $htmlReplace .= '   <span style="font-size: 9px;">Telefone: (61) 3561 - 3649.</span>';
        $htmlReplace .= '</div>';
        return str_replace("###interesttext###", $htmlReplace, $html);
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

    private function updateBoleto(){
        $this->modelBoleto->boleto->edit(array("dt_emissao"=>$this->dateEmissaoBanco, "st_gerado"=>1), $this->idBoletos[$this->i]);
    }

    private function gerarCodigo(){
        return Util_Util::getGenerateCode();
    }

}