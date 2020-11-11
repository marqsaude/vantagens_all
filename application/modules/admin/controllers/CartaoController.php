<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 20/10/17
 * Time: 11:53
 */

class Admin_CartaoController extends Zend_Controller_Action {

    private $post;
    private $numberCard;
    private $modelCliente;
    public $session_login;
    private $permissions = array(1, 2, 3);
    private $permissionsCartao = array(1, 2, 3, 6);

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->view->coTipoLogin = $this->session_login->coTipoLogin;
        $this->_helper->layout->setLayout("layoutAdmin");
        $this->modelCliente = new Admin_Model_DbTable_Cliente();
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
            }else
            if($this->session_login->coTipoLogin==4){
                $modelCliente = new Admin_Model_DbTable_Cliente();
                $this->view->dataClienteDependentes = $modelCliente->getClienteDependentes($this->session_login->coSeqPaciente);
            }
        }
    }

    public function viewAction(){
        $idCliente = $this->getParam("id");
        if((isset($idCliente) || !empty($idCliente)) && in_array($this->session_login->coTipoLogin, $this->permissionsCartao)) {
        }else{
            $dataCliente = $this->modelCliente->getClienteByUsuario($this->session_login->coSeqPaciente);
            $idCliente = $dataCliente["co_seq_cliente"];
        }
        //var_dump("teste");exit;
        $modelCartao = new Admin_Model_DbTable_Cartao();
        $this->view->dataCartao = $modelCartao->getByClienteAtivo($idCliente);
        if($this->view->dataCartao==NULL || !$this->view->dataCartao){
            $this->registerCardNumberCliente(array("co_seq_cliente"=>$idCliente));
            $modelCartao->clean();
            $this->view->dataCartao = $modelCartao->getByClienteAtivo($idCliente);
        }
        $modelAcordo = new Default_Model_DbTable_Acordo();
        $dataAcordo = $modelAcordo->getAcordoBYCliente($idCliente);
        $this->view->idCliente = $idCliente;
        $this->createCartaoPDF($this->view->dataCartao["nu_cartao"], $dataAcordo);
        $this->convertPDFToJPG($this->view->dataCartao["nu_cartao"]);
    }

    public function viewDependenteAction(){
        $idDependente = $this->getParam("id");
        $modelDependentes = new Admin_Model_DbTable_Dependentes();
        if(in_array($this->session_login->coTipoLogin, $this->permissions)) {
            $dataDependentes = $modelDependentes->checkDependenteUsuario($idDependente);
            $this->viewCardDependentes($dataDependentes[0]);
        }else{
            $dataDependentes = $modelDependentes->checkDependenteUsuario($idDependente, $this->session_login->coSeqPaciente);
            if(count($dataDependentes) > 0){
                //$idCliente = $dataCliente["co_seq_cliente"];
                $this->viewCardDependentes($dataDependentes[0]);
            }else{
                $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
            }
        }
    }

    public function printAction(){
        if($this->getParam("id")!=null){
            $idCliente = $this->getParam("id");
        }else{
            $modelCliente = new Admin_Model_DbTable_Cliente();
            $dataCliente = $modelCliente->getClienteByUsuario($this->session_login->coSeqPaciente);
            $idCliente = $dataCliente["co_seq_cliente"];
        }

        $modelCartao = new Admin_Model_DbTable_Cartao();
        $dataCartao = $modelCartao->getByClienteAtivo($idCliente);
        if($dataCartao == null){
            $data["co_seq_cliente"] = $idCliente;
            $this->registerCardNumberCliente($data);
            $data["nu_cartao"] = $this->numberCard;
            $dataCartao = $data;
        }
        $modelAcordo = new Default_Model_DbTable_Acordo();
        $dataAcordo = $modelAcordo->getAcordoBYCliente($idCliente);
        $this->session_login->coTipoLogin;
        if($this->session_login->coTipoLogin == 4 || $this->session_login->coTipoLogin == "4"){
            $this->createCartaoPDF($dataCartao["nu_cartao"], $dataAcordo, false, "p");
            $this->redirect('/adm/temp/pdf/'.$dataCartao["nu_cartao"].'_p.pdf');
        }else{
            $this->createCartaoPDF($dataCartao["nu_cartao"], $dataAcordo, false, "n");
            $this->redirect('/adm/temp/pdf/'.$dataCartao["nu_cartao"].'.pdf');
        }
    }

    public function printDependenteAction(){
        $idDependente = $this->getParam("id");
        $modelCartao = new Admin_Model_DbTable_Cartao();
        $dataCartao = $modelCartao->getByDependenteAtivo($idDependente);
        if($dataCartao == null){
            $modelCartao->clean();
            $modelCartao->cartao->insertOne(array("co_dependentes" => $idDependente, "st_cartao" => 1));
            $data["co_seq_dependentes"] = $idDependente;
            $this->registerCardNumber($data);
            $modelCartao->clean();
            $dataCartao = $modelCartao->getByDependenteAtivo($idDependente);
            $dataCartao["nu_cartao"] = $this->numberCard;
        }
        //$modelAcordo = new Default_Model_DbTable_Acordo();
        //$dataAcordo = $modelAcordo->getAcordoBYCliente($dataCartao["co_seq_cliente"]);
        $dataAcordo["nm_dependente"] = $dataCartao["nm_dependente"];
        $dataAcordo["dt_finaliza"] = $dataCartao["dt_finaliza"];
        if($this->session_login->coTipoLogin == 4 || $this->session_login->coTipoLogin == "4"){
            $this->createCartaoPDF($dataCartao["nu_cartao"], $dataAcordo, true, "p");
            $this->redirect('/adm/temp/pdf/'.$dataCartao["nu_cartao"].'_p.pdf');
        }else {
            $this->createCartaoPDF($dataCartao["nu_cartao"], $dataAcordo, true, "n");
            $this->redirect('/adm/temp/pdf/' . $dataCartao["nu_cartao"] . '.pdf');
        }
    }

    private function createQRCode($nuCartao){
        $cript = new Util_Cript();
        $valueCript = $cript->encrypt($nuCartao);
        $aux  = $this->view->baseUrl().'/adm/qr_img0.50j/php/qr_img.php?';
        $aux .= 'd='.$valueCript;
        $aux .= 'e=H&';
        $aux .= 's=7&';
        $aux .= 't=P';
        $url = 'http://'.$_SERVER['HTTP_HOST'].'/'.$aux;
        $img = realpath(dirname(__FILE__)).'/../../../../html/adm/qrcode_img/'.$nuCartao.'.png';
        file_put_contents($img, file_get_contents($url));
        return $img;
    }

    private function createCartaoPDF($nuCartao, $dataAcordo, $checkDependente=false, $typeCard="n"){
        $nome = ($checkDependente==false)?$dataAcordo["nm_cliente"]:$dataAcordo["nm_dependente"];
        $nome = $this->reduzNomeCliente($nome);
        $dataAcordo["dt_finaliza"] = $this->getDataValidade($dataAcordo["dt_finaliza"]);
        $img = $this->createQRCode($nuCartao);
        if($typeCard=="n"){
            $pdf = Zend_Pdf::load(realpath(dirname(__FILE__))."/../../../../inc/cartao.pdf");
        }else if($typeCard=="p"){
            $pdf = Zend_Pdf::load(realpath(dirname(__FILE__))."/../../../../inc/cartao_p.pdf");
        }
        $OCRAEXTFont = Zend_Pdf_Font::fontWithPath(realpath(dirname(__FILE__)).'/../../../../html/adm/fonts/OCRAEXT.TTF');
        $ArialFont = Zend_Pdf_Font::fontWithPath(realpath(dirname(__FILE__)).'/../../../../html/adm/fonts/arial.ttf');
        $ErasDemiItcFont = Zend_Pdf_Font::fontWithPath(realpath(dirname(__FILE__)).'/../../../../html/adm/fonts/eras-demi-itc.ttf');
        $ocrBold = Zend_Pdf_Font::fontWithPath(realpath(dirname(__FILE__)).'/../../../../html/adm/fonts/OCR-B10BT.ttf');
        $numeroCartao = $this->organizarNumero($nuCartao);
        if($typeCard=="n"){
            $pdf->pages[0]->setFont($OCRAEXTFont, 9.7);
            $pdf->pages[0]->setFillColor(Zend_Pdf_Color_Html::color('#000000'))
                ->drawText($numeroCartao, 5, 21);
        }else if($typeCard=="p"){
            $pdf->pages[0]->setFont($OCRAEXTFont, 18);
            $pdf->pages[0]->setFillColor(Zend_Pdf_Color_Html::color('#ffffff'))
                ->drawText($numeroCartao, 19, 57);
        }
        if($typeCard=="n") {
            $pdf->pages[0]->setFont($ocrBold, 12);
            $pdf->pages[0]->setFillColor(Zend_Pdf_Color_Html::color('#ffffff'))
                ->drawText($dataAcordo["dt_finaliza"], 57, 37);
        }else if($typeCard=="p"){
            $pdf->pages[0]->setFont($ocrBold, 9);
            $pdf->pages[0]->setFillColor(Zend_Pdf_Color_Html::color('#ffffff'))
                ->drawText($dataAcordo["dt_finaliza"], 49, 31);
        }
        if($typeCard=="n") {
            setlocale(LC_ALL, "en_US.utf8");
            $nome = iconv("utf-8", "ascii//TRANSLIT", $nome);
            $pdf->pages[0]->setFont($ocrBold, 11);
            $pdf->pages[0]->setFillColor(Zend_Pdf_Color_Html::color('#ffffff'))
                ->drawText(strtoupper($nome), 5, 54);
        }else if($typeCard=="p"){
            setlocale(LC_ALL, "en_US.utf8");
            $nome = iconv("utf-8", "ascii//TRANSLIT", $nome);
            $pdf->pages[0]->setFont($ocrBold, 10);
            $pdf->pages[0]->setFillColor(Zend_Pdf_Color_Html::color('#ffffff'))
                ->drawText(strtoupper($nome), 13, 13.5);
        }
        //var_dump(count($pdf->pages));exit;
        //$image = Zend_Pdf_Image::imageWithPath($img);
        if($typeCard=="n") {
            //$page = $pdf->pages[1];
            //$pdf->pages[1]->drawImage($image, 167, 141, 237, 72);
        }else if($typeCard=="p"){
            //$page1 = $pdf->pages[1];
            //$pdf->pages[1]->drawImage($image, 407, 141, 477, 72);
        }
        if($typeCard=="n"){
            $pdf->save('adm/temp/pdf/'.$nuCartao.'.pdf');
        }else if($typeCard=="p"){
            $pdf->save('adm/temp/pdf/'.$nuCartao.'_p.pdf');
        }
    }

    private function convertPDFToJPG($nuCartao){
        //var_dump('adm/temp/pdf/'.$nuCartao.'.pdf');exit;
        $im = new Imagick('adm/temp/pdf/'.$nuCartao.'.pdf');
        $im->resetIterator();
        $ima = $im->appendImages(true);
        $ima->setImageFormat('jpg');
        $ima->writeImage('adm/temp/img/'.$nuCartao.'.jpg');
    }

    private function organizarNumero($nuCartao){
        $str1 = substr($nuCartao, 0, 4);
        $str2 = substr($nuCartao, 4, 4);
        $str3 = substr($nuCartao, 8, 4);
        $str4 = substr($nuCartao, 12, 4);
        return $str1." ".$str2." ".$str3." ".$str4;
    }

    private function getDataValidade($dtFinaliza){
        $data = explode("-", $dtFinaliza);
        return $data[1]."/".$data[0];
    }

    private function reduzNomeCliente($nmCliente){
        if((strlen($nmCliente)>20)){
            $nmCliente = trim($nmCliente);
            $nome = explode(" ", $nmCliente);
            $last = end($nome);
            $num = count($nome);
            if($num == 2) {
                return $nome;
            }
            else {
                $count = 0;
                $novo_nome = '';
                $temp_novo_nome = '';
                foreach($nome as $var) {
                    if($count == 0) {$novo_nome .= $var.'  ';}
                    $count++;
                    if(($count >= 2) && ($count < $num)) {
                        $array = array('do', 'Do', 'DO', 'da', 'Da', 'DA', 'de', 'De', 'DE', 'dos', 'Dos', 'DOS', 'das', 'Das', 'DAS');
                        if(in_array($var, $array)) {
                            $novo_nome .= $var.'  ';
                        }
                        else {
                            $novo_nome .= substr($var, 0, 1).'.  ';
                        }
                    }
                    if($count == $num) {
                        $temp_novo_nome .= $novo_nome.$var.'  ';
                        /*if(strlen($temp_novo_nome)>20){
                            $novo_nome .= substr($var, 0, 1).'.  ';
                        }else{
                            $novo_nome .= $var.'  ';
                        }*/
                        $novo_nome .= $var;
                    }
                }
                return $novo_nome;
            }
        }else{
            $nome = explode(" ", $nmCliente);
            $novo_nome = '';
            foreach($nome as $var) {
                $novo_nome .= $var.'  ';
            }
            return $novo_nome;
        }
    }

    private function viewCardDependentes($dataDependentes){
        $modelCartao = new Admin_Model_DbTable_Cartao();
        $dataCartao = $modelCartao->getByDependenteAtivo($dataDependentes["co_seq_dependentes"]);
        if(count($dataCartao) == 0){
            $modelCartao->clean();
            $modelCartao = new Default_Model_DbTable_Cartao();
            $idCartao=$modelCartao->cartao->insertOne(array("co_dependentes"=>$dataDependentes["co_seq_dependentes"], "st_cartao"=>2));
            $this->registerCardNumber($dataDependentes);
            $modelCartao->clean();
            $dataCartao = $modelCartao->getCartao($idCartao);
        }
        $modelAcordo = new Default_Model_DbTable_Acordo();
        $dataAcordo = $modelAcordo->getAcordoBYCliente($dataDependentes["co_seq_cliente"]);
        $this->view->idCliente = $dataDependentes["co_seq_cliente"];
        $this->view->dataCartao = $dataCartao;
        $dataAcordo["nm_dependente"] = $dataDependentes["nm_dependente"];
        //var_dump($dataCartao["nu_cartao"]);exit;
        $this->createCartaoPDF($dataCartao["nu_cartao"], $dataAcordo, true);
        $this->convertPDFToJPG($dataCartao["nu_cartao"]);
    }

    private function registerCardNumber($dataDependentes){
        $cardNumber = new Util_CardNumber(null, $dataDependentes["co_seq_dependentes"]);
        $this->numberCard=$cardNumber->getNumberCard();
        $modelCartao = new Default_Model_DbTable_Cartao();
        $modelCartao->cartao->edit(array("nu_cartao"=>$this->numberCard, "st_cartao"=>1), array("co_dependentes"=>$dataDependentes["co_seq_dependentes"]));
    }

    private function registerCardNumberCliente($dataCliente){
        $cardNumber = new Util_CardNumber($dataCliente["co_seq_cliente"]);
        $this->numberCard=$cardNumber->getNumberCard();
        $modelCartao = new Default_Model_DbTable_Cartao();
        $modelCartao->cartao->edit(array("nu_cartao"=>$this->numberCard, "st_cartao"=>1), array("co_cliente"=>$dataCliente["co_seq_cliente"]));
    }

}