<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 03/11/17
 * Time: 17:55
 */

class Default_EsqueceuSenhaController extends Zend_Controller_Action {

    private $session_login;
    private $code;
    private $mensagem="";
    private $assunto = "Contato Marq Saúde + Vantagens";

    public function init()
    {
        $this->session_login = new Zend_Session_Namespace('LoginGog');
        $this->_helper->layout->setLayout("nova");
        $this->view->isMobile = Util_Util::isMobile();

    }

    public function ajaxIndexAction(){
        $post = $this->_request->getPost();
        $modelCliente = new Default_Model_DbTable_Cliente();
        $dataCliente=$modelCliente->getClienteByEmail($post["nm_email"]);
        $modelCliente->clean();
        if(count($dataCliente)>0){
            $this->gerarCodigo();
            $modelConfiguracao = new Default_Model_DbTable_Configuracao();
            $dataConfiguracao = $modelConfiguracao->getConfigurationAdmin();
            $para = $post["nm_email"];
            $arrayDados = array($dataCliente[0]["nm_cliente"], $dataConfiguracao["nm_url_sistema"], $this->code);
            $this->mountTextMensagem();
            $mensagem = $this->configDadosEmail($arrayDados, $this->mensagem);
            try {
                $config = array (
                    'auth' => 'login',
                    'username' => $dataConfiguracao["nm_email_login_cadastro"],
                    'password' => $dataConfiguracao["nm_email_senha_cadastro"],
                    'ssl'      => 'ssl',
                    'port'     => $dataConfiguracao["nm_email_port_cadastro"]
                );
                //var_dump($config);exit;
                $mailTransport = new Zend_Mail_Transport_Smtp($dataConfiguracao["nm_email_smtp_cadastro"], $config);
                $mail = new Zend_Mail('UTF-8');
                $mail->setReplyTo('sac@marqsaude.com.br', 'MarqSaude');
                $mail->addHeader('X-Abuse', 'Please report abuse: andream@fasys.it');
                $mail->addHeader('List-Unsubscribe', 'http://www.vobisvaldarno.it/newsletter/unsubscribe/');
                $mail->addHeader('MIME-Version', '1.0');
                $mail->addHeader('Content-Transfer-Encoding', '8bit');
                $mail->addHeader('X-Mailer:', 'PHP/'.phpversion());
                $mail->addTo($para);
                $mail->setSubject($this->assunto);
                $mail->setBodyHtml($mensagem);
                $mail->setFrom($dataConfiguracao["nm_email_login_cadastro"], 'Contato Marq Saúde + Vantagens');
                //$mail->setFrom("tabx.php@gmail.com  ", 'Contato Q Saúde');
                $mail->send($mailTransport);
                $mail->clearRecipients();
                $mail->clearSubject();


                // Cadastra Email
                $arrayEmail = array(
                    "co_cliente"=>$dataCliente[0]["co_seq_cliente"],
                    "tx_mensagem"=>$mensagem,
                    "nm_email"=>$dataCliente[0]["nm_email"],
                    "st_email"=>1,
                    "tp_email"=>2,
                    "nm_code"=>$this->code
                );
                $this->salvar($arrayEmail);
                $modelCliente->cliente->edit(array("st_muda_senha" => 1), array("nm_email" => $post["nm_email"]));

                $data["msg"] = "Email enviado com SUCESSSO!";
                $data["flag"] = 1;
            }catch (Exception $e){
                $data["msg"] = "Algum erro aconteceu no envio do email!";
                $data["flag"] = 0;
                $data["error"] = $e->getMessage();
                die(json_encode($data));
            }
        }
        die(json_encode(array("msn" => "200 ok", "achou"=>(count($dataCliente)>0)?1:2)));
    }

    private function gerarCodigo(){
        $this->code=Util_Util::getGenerateCode();
    }

    private function mountTextMensagem(){
        $this->mensagem .= '<br/><br/>';
        $this->mensagem .= '<center>';
        $this->mensagem .= '<h2>Pedido de alteração de senha</h2>';
        $this->mensagem .= '</center>';
        $this->mensagem .= '<br/><br/>';
        $this->mensagem .= '<p align="justify">';
        $this->mensagem .= '???, houve um pedido de alteração de senha da sua conta Marq Saúde + Vantagens. Se realmente foi o(a) senhor(a), clique no link que segue ->';
        $this->mensagem .= '<a href="???/cliente/senha/code/???">INSERIR SENHA</a>.';
        $this->mensagem .= '</p><p><br/><br/><br/><br/><br/><br/></p><p>';
        $this->mensagem .= '<h3>';
        $this->mensagem .= '<font color="#742021">Marq Saúde + Vantagens o cartão da sua vida!</font>';
        $this->mensagem .= '</h3></p>';
    }

    private function configDadosEmail($array, $mensagem){
        foreach($array as $value){
            $mensagem = Util_Util::strReplaceFirst('???', $value, $mensagem);
        }
        return $mensagem;
    }

    private function salvar($array){
        $modelEmail = new Default_Model_DbTable_Email();
        $modelEmail->email->insertOne($array);
    }

}