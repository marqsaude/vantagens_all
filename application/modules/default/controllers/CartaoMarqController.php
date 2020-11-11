<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 20/03/17
 * Time: 15:17
 */

class Default_CartaoMarqController extends Zend_Controller_Action
{

    private $session_login;
    private $session_gog;
    private $urlPDFServer = "http://marqsaudevantagens.com:8080";
    private $post;
    private $dateEmissao;
    private $dateVencimentoTit;
    private $price;
    private $idBoleto = array();

    public function init()
    {

        $this->session_gog = new Zend_Session_Namespace('Gog');
        $this->session_login = new Zend_Session_Namespace('Login');
        if ($this->session_login->logado == NULL) {
            $this->session_login->logado = false;
        }
        $this->_helper->layout->setLayout("layout");

    }

    public function indexAction()
    {

    }

    public function addClienteAction(){

    }

    public function finalizarAction(){

    }

    public function returnAction(){
        $dataCliente = $this->session_gog->cliente;
        $dataCliente["co_seq_cliente"] = $this->session_gog->contrato["idCliente"];
        $this->view->dataCliente = $dataCliente;
    }

    public function ajaxVerifyVantagensAction(){
        $post = $this->_request->getPost();
        $modelContratoGog = new Default_Model_DbTable_ContratoGog();
        $post["setContratoGog"] = (!isset($post["setContratoGog"]))?false:$post["setContratoGog"];
        if($post["setContratoGog"] != false && $post["setContratoGog"] != "false"){
            $dataContratoGog = $modelContratoGog->getContratoGog($post["setContratoGog"]);
        }else{
            $dataContratoGog = $modelContratoGog->getAllContratoGog();
        }
        if(count($dataContratoGog)>0){
            die(json_encode(array("registro" => true, "count" => count($dataContratoGog), "data" => $dataContratoGog)));
        }else{
            die(json_encode(array("registro" => false, "count" => 0, "data" => "")));
        }
    }

    public function ajaxVerifyDddAction(){
        $post = $this->_request->getPost();
        $modelDdd = new Default_Model_DbTable_Ddd();
        $dataDddTelefone = $modelDdd->getDdd($post["dddTelefone"]);
        $modelDdd->clean();
        $dataDddCelular = $modelDdd->getDdd($post["dddCelular"]);
        $modelDdd->clean();
        $dataDddWhatsApp = $modelDdd->getDdd($post["dddWhatsapp"]);
        $data = array();
        if(count($dataDddTelefone)>0) {
            $data["telefone"] = true;
        }else{
            $data["telefone"] = false;
        }
        if(count($dataDddCelular)>0) {
            $data["celular"] = true;
        }else{
            $data["celular"] = false;
        }
        if(count($dataDddWhatsApp)>0) {
            $data["whatsapp"] = true;
        }else{
            $data["whatsapp"] = false;
        }
        die(json_encode(array("data"=>$data)));
    }

    public function ajaxClienteSessionAction(){
        $post = $this->_request->getPost();
        $this->session_gog->cliente = $post;
        die(json_encode(array("session" => true)));
    }

    public function ajaxTelefoneSessionAction(){
        $post = $this->_request->getPost();
        $this->session_gog->telefone=$post;
        die(json_encode(array("session" => true)));
    }

    public function ajaxCartaoSessionAction(){
        $post = $this->_request->getPost();
        $this->session_gog->cartao=$post;
        die(json_encode(array("session" => true)));
    }

    public function ajaxPagamentoSessionAction(){
        $post = $this->_request->getPost();
        $this->session_gog->pagamento=$post;
        die(json_encode(array("session" => true)));
    }

    public function ajaxCepSessionAction(){
        $post = $this->_request->getPost();
        $this->session_gog->cep=$post;
        die(json_encode(array("session" => true)));
    }

    public function ajaxAcordoSessionAction(){
        $post = $this->_request->getPost();
        $this->session_gog->acordo=$post;
        die(json_encode(array("session" => true)));
    }

    public function ajaxSessionRegisterAction(){
        $this->post = $this->_request->getPost();
        $this->session_gog->acordo=$this->post["acordo"];
        $this->session_gog->pagamento=$this->post["pagamento"];
        $this->session_gog->telefone=$this->post["telefone"];
        $this->session_gog->cliente = $this->post["cliente"];
        if(isset($this->post["dependentes"]) && $this->post["dependentes"]!=null) {
            $this->setDependenteSession($this->post["dependentes"]);
        }
        if(isset($this->post["vendedor"])){
            $this->session_gog->vendedor = $this->post["vendedor"];
        }
        $this->session_gog->cep=$this->post["endereco"];
        $this->register();
        die(json_encode(array("session" => true, "retorna" => 1, "data"=>array("id"=>$this->session_gog->contrato["idCliente"]))));
    }

    public function ajaxGetFormaPagamentoAction(){
        $this->post = $this->_request->getPost();
        $modelFormaPagamento = new Default_Model_DbTable_FormaPagamento();
        $dataFormaPagamento = $modelFormaPagamento->getAllFormaPagamento($this->post["ids"]);
        if(count($dataFormaPagamento)>0){
            die(json_encode(array("registro" => true, "count" => count($dataFormaPagamento), "data" => $dataFormaPagamento)));
        }else{
            die(json_encode(array("registro" => false, "count" => 0, "data" => "")));
        }
    }

    public function ajaxGetTipoDependentesAction(){
        $modelTipoDependentes = new Default_Model_DbTable_TipoDependentes();
        $dataTipoDependentes = $modelTipoDependentes->getAllTipoDependentes();
        if(count($dataTipoDependentes)>0){
            die(json_encode(array("registro" => true, "count" => count($dataTipoDependentes), "data" => $dataTipoDependentes)));
        }else{
            die(json_encode(array("registro" => false, "count" => 0, "data" => "")));
        }
    }

    public function ajaxValidCardAction(){
        $post = $this->_request->getPost();
        $validCredCard = new Util_ValidCredCard($post["co_seq_tipo_cartao"]);
        $valid = $validCredCard->creditCard($post["nu_card"]);
        die(json_encode(array("valid" => $valid)));
    }

    public function ajaxGetTipoCartaoAction(){
        $modelTipoCartao = new Default_Model_DbTable_TipoCartao();
        $dataTipoCartao=$modelTipoCartao->getAll();
        die(json_encode(array("session" => true, "data" => $dataTipoCartao)));
    }

    public function ajaxGetPriceAction(){
        $post = $this->_request->getPost();
        $dataContratoGog = $this->getPriceByContratoGOG($post["co_seq_contrato_gog"]);
        die(json_encode(array("session" => true, "price" => $dataContratoGog[0]["nu_valor"])));
    }

    public function ajaxBoletoAction(){
        $this->post = $this->_request->getPost();
        $modelConfiguracao = new Admin_Model_DbTable_Configuracao();
        $dataConfiguracao = $modelConfiguracao->getAll();
        $filePath = $dataConfiguracao[0]["nm_url_absoluta"] . "/site/html/boleto/clean2.html";
        $filePathClean = $dataConfiguracao[0]["nm_url_absoluta"] . "/site/html/boleto/clean.html";

        $modelBoleto = new Default_Model_DbTable_Boleto();
        $dataBoleto = $modelBoleto->getCountBoletoByCliente($this->session_gog->contrato["idCliente"]);

        $dataContratoGog = $this->getPriceByContratoGOG($this->post["co_seq_contrato_gog"]);
        $this->price = floatval(number_format(floatval($dataContratoGog[0]["nu_valor"])/floatval($this->post["nu_vezes"]), 2));

        for($i=0; $i<intval($this->post["nu_vezes"]); $i++) {
            $this->dateEmissao[$i] = Util_Util::getDateBoleto(null, $i);
            $this->dateVencimentoTit[$i] = Util_Util::getDateBoleto(5, $i);
        }

        $this->insertBoleto($dataBoleto, $modelBoleto);

        /*** Executa Boleto Fake ***/
        //$htmlArray = $this->execTesteCurlServer($filePath, $filePathClean);
        $dataBoleto["post"] = $this->post;
        $dataBoleto["post"]["dateEmissao"] = $this->dateEmissao[0]["boleto"];
        $dataBoleto["post"]["price"] = $this->price;
        $dataBoleto["post"]["dateVencimentoTit"] = $this->dateVencimentoTit;
        $idBoleto[0] = $this->idBoleto[0];
        //$dataBoleto = array("post"=>$this->post, "dateEmissao"=>$this->dateEmissao[0]["boleto"], "price"=>$this->price, "dateVencimentoTit"=>$this->dateVencimentoTit);
        /*** Executa Boleto***/
        $boleto = new Boleto_Boleto($dataBoleto, $idBoleto, 0);
        $geradoBoleto = $boleto->gerar();

        $dataCliente = $this->session_gog->cliente;
        $dataCliente["co_seq_cliente"] = $this->session_gog->contrato["idCliente"];
        $this->registerCardNumber($dataCliente);
        if($this->session_login->logado){
            $userRegister= new Zend_Session_Namespace('UserRegister');
            $userRegister->coSeqCliente = $dataCliente["co_seq_cliente"];
            $userRegister->nmCliente = $dataCliente["nm_cliente"];
            $userRegister->nmEmail = $dataCliente["nm_email"];
            $this->_helper->redirector("return-transaction", "pag-seguro", "admin");
        }
        if($geradoBoleto){
            $data["msg"] = "Email enviado com SUCESSSO!";
            $data["flag"] = 1;
        }else{
            $data["msg"] = "Boleto não gerado!";
            $data["flag"] = 2;
        }
        die(json_encode(array("session" => true, "data"=>$data)));
    }

    public function ajaxRegisterDinheiroAction(){
        $this->post = $this->_request->getPost();
        $dataContratoGog = $this->getPriceByContratoGOG($this->session_gog->acordo["co_contrato_gog"]);
        $dataCliente = $this->session_gog->cliente;
        $dataCliente["co_seq_cliente"] = $this->post["id"];
        $code = $this->gerarCodigo();
        $modelConfiguracao = new Admin_Model_DbTable_Configuracao();
        $dataConfiguracao = $modelConfiguracao->getAll();
        $emailSendEmail = new Email_SendEmail($dataCliente, $code, $dataContratoGog[0]);
        $emailSendEmail->send(null, $dataConfiguracao[0]);
        $this->registerCardNumber($dataCliente);
        die(json_encode(array("session" => true)));
    }

    public function ajaxRegisterCartaoPresencialAction(){
        $this->post = $this->_request->getPost();
        $dataContratoGog = $this->getPriceByContratoGOG($this->session_gog->acordo["co_contrato_gog"]);
        $dataCliente = $this->session_gog->cliente;
        $dataCliente["co_seq_cliente"] = $this->post["id"];
        $code = $this->gerarCodigo();
        $modelConfiguracao = new Admin_Model_DbTable_Configuracao();
        $dataConfiguracao = $modelConfiguracao->getAll();
        $emailSendEmail = new Email_SendEmail($dataCliente, $code, $dataContratoGog[0]);
        $emailSendEmail->send(null, $dataConfiguracao[0]);
        $this->registerCardNumber($dataCliente);
        die(json_encode(array("session" => true)));
    }

    private function setDependenteSession($data){
        $this->session_gog->dependentes = $data;
    }

    private function insertBoleto($dataBoleto, $modelBoleto){
        for($i=0; $i<intval($this->post["nu_vezes"]); $i++) {
            $q = $dataBoleto["q"]+$i+1;
            $this->post["nuBoleto"][$i] = Util_Util::getDateNowClean().$this->session_gog->contrato["idCliente"].$q;
            $modelBoleto->clean();
            if($i==0){
                $stGerado = 1;
            }else{
                $stGerado = 2;
            }
            $this->idBoleto[$i] = $modelBoleto->boleto->insertOne(array("co_cliente"=>$this->session_gog->contrato["idCliente"], "co_pagamento"=>$this->session_gog->contrato["idPagamento"], "lk_boleto"=>$this->session_gog->contrato["idCliente"]."qtd".$q.".pdf", "nu_boleto"=>$this->post["nuBoleto"][$i], "dt_vencimento"=>$this->dateVencimentoTit[$i]["banco"], "dt_emissao"=>$this->dateEmissao[$i]["banco"], "st_pago"=>2, "nu_valor"=>$this->price, "st_gerado"=>$stGerado));
            $modelExtrato = new Admin_Model_DbTable_Extrato();
            $modelExtrato->extrato->edit(array("nu_id_boleto"=>$this->idBoleto[$i]), $this->session_gog->extrato[$i]);
        }
    }

    private function gerarCodigo(){
        return Util_Util::getGenerateCode();
    }

    private function createPDF($html, $dataConfiguracao, $i){
        $filePath = $dataConfiguracao[0]["nm_url_absoluta"] . "/site/html/boleto/".$this->idBoleto[$i].".html";
        $data = $this->replaceHtml($html);
        $myfile = fopen($filePath, "w") or die("Unable to open file!");
        fwrite($myfile, pack("CCC",0xef,0xbb,0xbf));
        fwrite($myfile, $data);
        fclose($myfile);
        $filePathCSS = $dataConfiguracao[0]["nm_url_absoluta"] . "/site/css/boleto.css";
        $filePathOut = $dataConfiguracao[0]["nm_url_absoluta"] . "/site/pdf/boleto/".$this->idBoleto[$i].".pdf";
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

    private function execCurlServer(){
        $htmlArray = array();
        for($i=0; $i<intval($this->post["nu_vezes"]); $i++) {
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
        return "numCliente=420611&coopCartao=5004&chaveAcessoWeb=41123378-4592-4C04-BBA9-3147A82DF87F&numContaCorrente=1131001&codMunicipio=26242&bolRecebeBoletoEletronico=1&codTipoVencimento=1&valorAbatimento=0&bolAceite=1&percTaxaMulta=0&percTaxaMora=0&codEspDocumento=DM&valorPrimDesconto=0&valorSegDesconto=0&nomeSacado=".$post["nomeSacado"]."&cpfCGC=".$post["cpfCGC"]."&dataNascimento=".$post["dataNascimento"]."&endereco=".$post["endereco"]."&bairro=".$post["bairro"]."&cidade=".$post["cidade"]."&cep=".$post["cep"]."&uf=".$post["uf"]."&telefone=".$post["telefone"]."&ddd=".$post["ddd"]."&ramal=77&email=".$post["email"]."&dataEmissao=".$this->dateEmissao[0]["boleto"]."&seuNumero=".$post["nuBoleto"][$i]."&nomeSacador=Q%20Sa%FAde%20Vantagens&numCGCCPFSacador=29139123000190&qntMonetaria=".$this->price."&valorTitulo=".$this->price."&dataVencimentoTit=".$this->dateVencimentoTit[$i]["boleto"]."&descInstrucao1=%23%23%23logo%23%23%23&descInstrucao2=%23%23%23interesttext%23%23%23&descInstrucao3=%20&descInstrucao4=%20";
        //return "numCliente=420611&coopCartao=5004&chaveAcessoWeb=41123378-4592-4C04-BBA9-3147A82DF87F&numContaCorrente=1131001&codMunicipio=26242&bolRecebeBoletoEletronico=1&codTipoVencimento=1&valorAbatimento=0&bolAceite=1&percTaxaMulta=0&percTaxaMora=0&codEspDocumento=DM&valorPrimDesconto=0&valorSegDesconto=0&nomeSacado=".$post["nomeSacado"]."&cpfCGC=".$post["cpfCGC"]."&dataNascimento=".$post["dataNascimento"]."&endereco=".$post["endereco"]."&bairro=".$post["bairro"]."&cidade=".$post["cidade"]."&cep=".$post["cep"]."&uf=".$post["uf"]."&telefone=".$post["telefone"]."&ddd=".$post["ddd"]."&ramal=77&email=".$post["email"]."&dataEmissao=".$this->dateEmissao[0]["boleto"]."&seuNumero=".$post["nuBoleto"][$i]."&nomeSacador=Q%20Sa%FAde%20Vantagens&numCGCCPFSacador=29139123000190&qntMonetaria=1&valorTitulo=1&dataVencimentoTit=".$this->dateVencimentoTit[$i]["boleto"]."&descInstrucao1=%23%23%23logo%23%23%23&descInstrucao2=%20&descInstrucao3=%20&descInstrucao4=%20";
    }

    private function removeLastOccurenceOfChar($char, $string){
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

    private function putInterestText($html){
        $htmlReplace  = '<div style="float:left;">';
        $htmlReplace .= '   <span style="font-size: 9px;">Após o vencimento, pagar somente no banco Sicoob. </span>';
        $htmlReplace .= '   <span style="font-size: 9px;">Após o vencimento, cobrar: </span><br>';
        $htmlReplace .= '   <span style="font-size: 9px;"> - Multa de Mora: 10% ao mês.</span><br>';
        $htmlReplace .= '   <span style="font-size: 9px;"> - Juros de 2% ao mês.</span>';
        $htmlReplace .= '   <span style="font-size: 9px;">Telefone: (61) 3561 - 3649.</span>';
        $htmlReplace .= '</div>';
        return str_replace("###interesttext###", $htmlReplace, $html);
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

    private function registerCardNumber($dataCliente){
        $cardNumber = new Util_CardNumber($dataCliente["co_seq_cliente"]);
        $numberCard=$cardNumber->getNumberCard();
        $modelCartao = new Default_Model_DbTable_Cartao();
        $modelCartao->cartao->edit(array("nu_cartao"=>$numberCard, "st_cartao"=>1), array("co_cliente"=>$dataCliente["co_seq_cliente"]));
    }

    private function register(){
        //$cep = $this->session_gog->cep["nu_cep"];
        //var_dump($cep);exit;
        //$cepSend=substr($cep, 0, -6).".".substr($cep, 2, -3)."-".substr($cep, -3);
        $modelCliente = new Default_Model_DbTable_Cliente();
        $dataCliente = $this->session_gog->cliente;
        $cpf = str_replace(".", "", $dataCliente["nu_cpf"]);
        $cpf = str_replace("-", "", $cpf);
        if($modelCliente->isExistCpf($cpf) == 1) {

            $modelCep = new Default_Model_DbTable_Cep();
            $dataCep = $modelCep->getByCep($this->session_gog->cep["nu_cep"]);
            if (count($dataCep) == 0) {
                $idCep = $modelCep->cep->insertOne($this->session_gog->cep);
            } else {
                $idCep = $dataCep[0]["co_seq_cep"];
            }
            $dataUsuario["co_tipo_usuario"] = 4;
            $dataUsuario["nm_usuario"] = $this->session_gog->cliente["nm_cliente"];
            $dataUsuario["nm_login"] = $this->session_gog->cliente["nm_email"];
            $dataUsuario["nm_senha"] = "fgrb35!@fhgkjRHQw$%.";
            $modelUsuario = new Default_Model_DbTable_Usuario();
            $idUsuario = $modelUsuario->usuario->insertOne($dataUsuario);

            $dataCliente = $this->session_gog->cliente;
            $dataCliente["co_cep"] = $idCep;
            $dataCliente["co_tipo_cliente"] = 1;
            $dataCliente["co_empresa"] = 5;
            $dataCliente["co_usuario"] = $idUsuario;
            $dataCliente["co_usuario_registrou"] = ($this->session_login->logado) ? $this->session_login->coSeqPaciente : 5;
            $dataCliente["nu_rg"] = str_replace(".", "", $dataCliente["nu_rg"]);
            $dataCliente["nu_rg"] = str_replace("-", "", $dataCliente["nu_rg"]);
            $dataCliente["nu_cpf"] = str_replace(".", "", $dataCliente["nu_cpf"]);
            $dataCliente["nu_cpf"] = str_replace("-", "", $dataCliente["nu_cpf"]);
            $dataCliente["dt_nascimento"] = Util_Util::changeDateToSql($dataCliente["dt_nascimento"]);
            $dataCliente["nm_login"] = $dataCliente["nu_cpf"];
            $dataCliente["nm_senha"] = "fgrb35!@fhgkjRHQw$%.";
            $dataCliente["st_muda_senha"] = 1;
            $dataCliente["st_cliente"] = 1;

            $modelCliente->clean();
            $idCliente = $modelCliente->cliente->insertOne($dataCliente);

            $dataTelefone = array();
            $dataRLClienteTelefone = array();
            $utilTelefone = new Util_Telefone();
            $utilTelefone->registraTelefone($this->session_gog->telefone, "cliente", $idCliente);

            $modelContratoGog = new Default_Model_DbTable_ContratoGog();
            $dataContratoGog = $modelContratoGog->getContratoGog($this->session_gog->acordo["co_contrato_gog"]);

            $modelAcordo = new Default_Model_DbTable_Acordo();
            $dataAcordo = array();
            $dataAcordo["co_contrato_gog"] = $this->session_gog->acordo["co_contrato_gog"];
            $dataAcordo["co_cliente"] = $idCliente;
            $dataAcordo["co_usuario"] = 5;
            $dataAcordo["dt_acordo"] = Util_Util::getDateMysqlNow();
            $dataAcordo["dt_finaliza"] = Util_Util::addMonthToDate($dataAcordo["dt_acordo"], $dataContratoGog[0]["nu_meses"]);
            $idAcordo = $modelAcordo->acordo->insertOne($dataAcordo);

            $modelPagamento = new Default_Model_DbTable_Pagamento();
            $dataPagamento = array();
            $dataPagamento["co_status_pagamento"] = 1;
            $dataPagamento["co_acordo"] = $idAcordo;
            $dataPagamento["co_forma_pagamento"] = $this->session_gog->pagamento["co_forma_pagamento"];
            $idPagamento = $modelPagamento->pagamento->insertOne($dataPagamento);

            $modelCaixa = new Default_Model_DbTable_Caixa;
            $dataCaixa = $modelCaixa->getCaixaAtivo();

            if ($this->session_gog->pagamento["co_forma_pagamento"] == 1) {
                $nuValor = floatval($dataContratoGog[0]["nu_valor"]) / intval($this->post["nu_vezes"]);
                for ($i = 0; $i < $this->post["nu_vezes"]; $i++) {
                    $modelExtrato = new Default_Model_DbTable_Extrato();
                    $dataExtrato = array();
                    $dataExtrato["co_caixa"] = $dataCaixa[0]["co_seq_caixa"];
                    $dataExtrato["co_pagamento"] = $idPagamento;
                    $dataExtrato["nu_saldo"] = floatval($dataCaixa[0]["nu_saldo"]) + $nuValor;
                    $dataExtrato["nu_valor_transacao"] = $nuValor;
                    $dataExtrato["tp_transacao"] = 1;
                    $dataExtrato["st_pagamento"] = 2;
                    $this->session_gog->extrato[$i] = $modelExtrato->extrato->insertOne($dataExtrato);
                }
            } else {
                $modelExtrato = new Default_Model_DbTable_Extrato();
                $dataExtrato = array();
                $dataExtrato["co_caixa"] = $dataCaixa[0]["co_seq_caixa"];
                $dataExtrato["co_pagamento"] = $idPagamento;
                $dataExtrato["nu_saldo"] = floatval($dataCaixa[0]["nu_saldo"]) + floatval($dataContratoGog[0]["nu_valor"]);
                $dataExtrato["nu_valor_transacao"] = floatval($dataContratoGog[0]["nu_valor"]);
                $dataExtrato["tp_transacao"] = 1;
                $dataExtrato["st_pagamento"] = 2;
                $modelExtrato->extrato->insertOne($dataExtrato);
            }
            if (isset($this->session_gog->dependentes) && !empty($this->session_gog->dependentes) && count($this->session_gog->dependentes) != 0 && $this->session_gog->dependentes[0] != null && $this->session_gog->dependentes[0]["nm_dependente"] != null) {
                foreach ($this->session_gog->dependentes as $value) {
                    $modelDependentes = new Default_Model_DbTable_Dependentes();
                    $value["co_acordo"] = $idAcordo;
                    $value["dt_nascimento"] = Util_Util::getDataMysqlNoHour($value["dt_nascimento"]);
                    $modelDependentes->dependentes->insertOne($value);
                }
            }

            $modelCartao = new Default_Model_DbTable_Cartao();
            $modelCartao->cartao->insertOne(array("co_cliente" => $idCliente, "st_cartao" => 2));

            $this->session_gog->contrato["idPagamento"] = $idPagamento;
            $this->session_gog->contrato["nu_valor"] = $dataContratoGog[0]["nu_valor"];
            $this->session_gog->contrato["idCliente"] = $idCliente;
        }else{
            var_dump("PDF já existente!");exit;
        }
    }

}
