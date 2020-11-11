<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 22/01/18
 * Time: 10:21
 */

class Admin_RelatorioController extends Zend_Controller_Action {

    public $session_login;
    public $flagIsMobile = false;
    private $authHard = array(1, 2);
    private $authMedium = array(1, 2, 3);
    private $authLight = array(1, 2, 3, 6);
    //private $urlPDFServer = "http://qsaudevantagens.com.br:8080";
    private $urlPDFServer = "http://localhost:8080";

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->view->coTipoLogin = $this->session_login->coTipoLogin;
        $this->_helper->layout->setLayout("layoutAdmin");
        if(!Util_Util::isAjax()){
            $modelNotificacaoContato = new Admin_Model_DbTable_NotificacaoContato();
            $this->view->dataContatoN = $modelNotificacaoContato->getNotificacaoVisualizado($this->session_login->coSeqPaciente);
            if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {
                $modelCaixa = new Admin_Model_DbTable_Caixa();
                $this->view->dataCaixaE = $modelCaixa->getCaixaAtivo();
            }else if($this->session_login->coTipoLogin==3) {
                $modelCliente = new Admin_Model_DbTable_Cliente();
                $this->view->dataCaixaE = $modelCliente->getClienteFuncionario($this->session_login->coSeqPaciente);
            }else if($this->session_login->coTipoLogin==5){
                $modelCliente = new Admin_Model_DbTable_Cliente();
                $this->view->dataCaixaE = $modelCliente->getClienteVendedor($this->session_login->coSeqPaciente);
            }else if($this->session_login->coTipoLogin==4){
                $modelCliente = new Admin_Model_DbTable_Cliente();
                $this->view->dataClienteDependentes = $modelCliente->getClienteDependentes($this->session_login->coSeqPaciente);
            }
        }
    }

    public function pagamentoAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authLight)) {
            $page = 1;
            $perPage = 10;
            $modelCliente = new Admin_Model_DbTable_Cliente();
            $dataCliente = $modelCliente->getClientesRelatorioPago("", $page, $perPage);
            $count = ($dataCliente["count"] / $perPage);
            $countInt = intval($count);
            $count = ($count == $countInt) ? $count : $count + 1;
            $this->view->dataCount = intval($count);
            $this->view->page = $page;
            $this->view->n = $dataCliente["count"];
            $this->view->dataCliente = $dataCliente["data"];
            $this->view->coSeqPaciente = $this->session_login->coSeqPaciente;
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxPrintAction(){
        $post = $this->_request->getPost();
        $modelConfiguracao = new Admin_Model_DbTable_Configuracao();
        $dataConfiguracao = $modelConfiguracao->getAll();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $dataConfiguracao[0]["nm_url_sistema"]."/default/relatorio/print");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array("pago"=>$post["pago"]));
        $htmlcontent = curl_exec($ch);
        curl_close($ch);
        $this->createPDF($htmlcontent, $dataConfiguracao);
        die(json_encode(array("msn"=>"200 ok" , "data"=>array())));
    }

    public function ajaxPagamentoAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authLight)) {
            $post = $this->_request->getPost();
            $page = $post["page"];
            $perPage = 10;
            $modelCliente = new Admin_Model_DbTable_Cliente();
            $dataCliente = $modelCliente->getClientesRelatorioPago("", $page, $perPage);
            $count = ($dataCliente["count"] / $perPage);
            $countInt = intval($count);
            $count = ($count == $countInt) ? $count : $count + 1;
            $dataCount = intval($count);
            $n = $dataCliente["count"];
            $dataCliente = $dataCliente["data"];
            die(json_encode(array("msn"=>"200 ok" , "data"=>array("count"=>$dataCount, "page"=>$page, "cliente"=>$dataCliente, "n"=>$n))));
        }
    }

    public function ajaxPagamentoNaoAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authLight)) {
            $post = $this->_request->getPost();
            $page = $post["page"];
            $perPage = 10;
            $modelCliente = new Admin_Model_DbTable_Cliente();
            $dataCliente = $modelCliente->getClientesRelatorioNaoPago("", $page, $perPage);
            $count = ($dataCliente["count"] / $perPage);
            $countInt = intval($count);
            $count = ($count == $countInt) ? $count : $count + 1;
            $dataCount = intval($count);
            $n = $dataCliente["count"];
            $dataCliente = $dataCliente["data"];
            die(json_encode(array("msn"=>"200 ok" , "data"=>array("count"=>$dataCount, "page"=>$page, "cliente"=>$dataCliente, "n"=>$n))));
        }
    }

    public function ajaxPagamentoBuscaAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authLight)) {
            $post = $this->_request->getPost();
            $nome = $post["nome"];
            $page = 1;
            $perPage = 10;
            $modelCliente = new Admin_Model_DbTable_Cliente();
            if($post["pago"]==1){
                $dataCliente = $modelCliente->getClientesRelatorioPago($nome, $page, $perPage);
            }else{
                $dataCliente = $modelCliente->getClientesRelatorioNaoPago($nome, $page, $perPage);
            }
            $count = ($dataCliente["count"] / $perPage);
            $countInt = intval($count);
            $count = ($count == $countInt) ? $count : $count + 1;
            $dataCount = intval($count);
            $n = $dataCliente["count"];
            $dataCliente = $dataCliente["data"];
            die(json_encode(array("msn"=>"200 ok" , "data"=>array("count"=>$dataCount, "page"=>$page, "cliente"=>$dataCliente, "n"=>$n))));
        }
    }

    private function createPDF($html, $dataConfiguracao){
        $filePath = $dataConfiguracao[0]["nm_url_absoluta"] . "/adm/html/relatorio/".$this->session_login->coSeqPaciente.".html";
        file_put_contents($filePath, "");
        //$data = $this->replaceHtml($html);
        $myfile = fopen($filePath, "a+") or die("Unable to open file!");
        fwrite($myfile, pack("CCC",0xef,0xbb,0xbf));
        fwrite($myfile, $html);
        fclose($myfile);
        $filePathCSS = $dataConfiguracao[0]["nm_url_absoluta"] . "/adm/css/relatorio.css";
        $filePathOut = $dataConfiguracao[0]["nm_url_absoluta"] . "/adm/pdf/relatorio/".$this->session_login->coSeqPaciente.".pdf";
        $this->createPDFByPath($filePathCSS, $filePath, $filePathOut);
    }

    private function createPDFByPath($css, $html, $out){
        $css = "-".$this->setUri($css);
        $html = "-".$this->setUri($html);
        $out = "-".$this->setUri($out);
        $ch = curl_init();

        //echo $this->urlPDFServer."/servletQSaude/rest/pdf/css/".$css."/html/".$html."/out/".$out;
        //exit;

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