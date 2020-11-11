<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 22/08/17
 * Time: 11:43
 */

class Admin_ContatoController  extends Zend_Controller_Action {

    private $post;
    public $session_login;
    private $modelContato=null;
    public $flagIsMobile = false;
    private $authHard = array(1, 2);
    private $authMedium = array(1, 2, 3);
    private $authLight = array(1, 2, 3, 6);

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->view->coTipoLogin = $this->session_login->coTipoLogin;
        $this->_helper->layout->setLayout("layoutAdmin");
        $this->modelContato = new Admin_Model_DbTable_Contato();
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

    public function indexAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authMedium)) {
            $this->view->dataContato = $this->modelContato->getAllContato();
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function viewAction(){
        $idContato = $this->getParam("id");
        if(in_array($this->session_login->coTipoLogin, $this->authMedium)) {
            $this->view->dataContato = $this->modelContato->getContato($idContato);
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxResponderAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authMedium)) {
            $post = $this->_request->getPost();
            $modelConfiguracao = new Admin_Model_DbTable_Configuracao();
            $dataConfiguracao = $modelConfiguracao->getAll()[0];
            $para = $post["nm_email"];
            try {
                $config = array (
                    'auth' => 'login',
                    'username' => $dataConfiguracao["nm_email_login_cadastro"],
                    'password' => $dataConfiguracao["nm_email_senha_cadastro"],
                    'ssl'      => 'ssl',
                    'port'     => $dataConfiguracao["nm_email_port_cadastro"]
                );
                $mailTransport = new Zend_Mail_Transport_Smtp($dataConfiguracao["nm_email_smtp_cadastro"], $config);
                $mail = new Zend_Mail('UTF-8');
                $mail->setReplyTo('sac@marqsaude.com.br', 'MarqSaude');
                $mail->addHeader('X-Abuse', 'Please report abuse: andream@fasys.it');
                $mail->addHeader('List-Unsubscribe', 'http://www.vobisvaldarno.it/newsletter/unsubscribe/');
                $mail->addHeader('MIME-Version', '1.0');
                $mail->addHeader('Content-Transfer-Encoding', '8bit');
                $mail->addHeader('X-Mailer:', 'PHP/'.phpversion());
                $mail->addTo($para);
                $mail->setSubject($post["nm_assunto"]);
                $mail->setBodyHtml($post["tx_mensagem"]);
                $mail->setFrom($dataConfiguracao["nm_email_login_cadastro"], 'Contato Q Saúde Vantagens');
                $mail->send($mailTransport);
                $mail->clearRecipients();
                $mail->clearSubject();

                $arrayEmail = array(
                    "co_contato"=>$post["co_seq_contato"],
                    "tx_mensagem"=>$post["tx_mensagem"],
                    "nm_email"=>$para,
                    "st_email"=>1,
                    "tp_email"=>3,
                    "nm_code"=>"00000000000000000"
                );
                $this->salvar($arrayEmail);

                $data["msg"] = "Email enviado com SUCESSSO!";
                $data["flag"] = 1;
            }catch (Exception $e){
                $data["msg"] = "Algum erro aconteceu no envio do email!";
                $data["flag"] = 0;
                $data["error"] = $e->getMessage();
                die(json_encode($data));
            }
            die(json_encode(array("msn" => "200 ok", "data"=>$data)));
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    private function salvar($array){
        $modelEmail = new Default_Model_DbTable_Email();
        $modelEmail->email->insertOne($array);
    }

}