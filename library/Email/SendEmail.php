<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 09/12/17
 * Time: 10:41
 */

class Email_SendEmail {

    private $dataCliente;
    private $id_transaction_q=null;
    private $code;
    private $pdfArray;
    private $dataContratoGog;
    private $dataEmail;
    private $teste=false;

    /*** Constantes ***/
    private $assunto = "Contato MarqSaúde + Vantagens";


    function __construct($dataCliente=null, $code=null, $dataContratoGog=null, $id_transaction_q=null, $teste=false){
        $this->dataCliente=$dataCliente;
        $this->id_transaction_q=$id_transaction_q;
        $this->code=$code;
        $this->dataContratoGog=$dataContratoGog;
        $this->teste = $teste;
    }

    public function send($pdfArray=null, $dataConfiguracao, $isBoleto=true){
        if($isBoleto==true){
            $this->pdfArray=$pdfArray;
        }
        $modelEmail = new Default_Model_DbTable_Email();
        if($modelEmail->checkEmailSend($this->dataCliente["co_seq_cliente"])){
            $modelEmail->clean();
            while($modelEmail->checkExist($this->code)==true){
                $this->gerarCodigo();
                $modelEmail->clean();
            }
            /**
            CONFIGURAÇÃO PARA ENVIO DO EMAIL
             */
            if($this->teste){
                $para = "tabx.php@gmail.com";
            }else{
                $para = $this->dataCliente["nm_email"];
            }

            //$mensagem = "<br/><br/><center><h2>Cadastro efetuado com sucesso</h2></center><br/><br/>";
            //$mensagem .= "<p align='justify'>".$this->view->dataCliente["nm_cliente"].", seu cadastro foi realizado com sucesso, para inserir sua senha, clique no link que segue -><a href='http://192.168.20.25:8888/qsaude/public_html/cliente/senha/code/".$this->code."'>INSERIR SENHA</a>.</p>";
            //$mensagem .= "<p><h3>Nome: </h3> Teste</p>";
            //$mensagem .= "<p><h3>Email: </h3> teste@teste.com</p>";
            //$mensagem .= "<p><br/><br/><br/><br/><br/><br/></p>";
            //$mensagem .= "<p><h3><font color='#742021'>QSaúde Card para você!</font></h3></p>";
            $arrayDados = array($this->dataCliente["nm_cliente"], $dataConfiguracao["nm_url_sistema"], $this->code);
            $mensagem = $this->configDadosEmail($arrayDados, $dataConfiguracao["tx_email_cadastro"]);

            try {
                //var_dump($dataConfiguracao, $this->view->dataCliente);exit;
                $config = array (
                    'auth' => 'login',
                    'username' => $dataConfiguracao["nm_email_login_cadastro"],
                    'password' => $dataConfiguracao["nm_email_senha_cadastro"],
                    'ssl'      => 'ssl',
                    'port'     => $dataConfiguracao["nm_email_port_cadastro"]
                );
                /*$config = array (
                    'auth' => 'login',
                    'username' => "qsaudevantagens@gmail.com",
                    'password' => "positivo1qaz",
                    'ssl'      => 'ssl',
                    'port'     => "465"
                );*/
                //$mailTransport = new Zend_Mail_Transport_Smtp("smtp.gmail.com", $config);
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
                $mail->setFrom($dataConfiguracao["nm_email_login_cadastro"], 'Contato MarqSaúde + Vantagens');

                if($isBoleto){
                    if (isset($this->pdfArray) && $this->pdfArray != null) {
                        $i = 1;
                        foreach ($this->pdfArray as $value) {
                            $content = file_get_contents($dataConfiguracao["nm_url_absoluta"] . "/site/pdf/boleto/" . $value);
                            $attachment = new Zend_Mime_Part($content);
                            $attachment->type = 'application/pdf';
                            $attachment->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
                            $attachment->encoding = Zend_Mime::ENCODING_BASE64;
                            $attachment->filename = 'boleto' . $i . '.pdf';
                            $mail->addAttachment($attachment);
                            $i++;
                        }
                    }
                }

                $contratoGog = new Util_GeraContratoGog($this->dataCliente["co_seq_cliente"]);
                $dataContratoGog = $contratoGog->gerar();
                $content = file_get_contents($dataConfiguracao["nm_url_absoluta"] . '/site/pdf/contrato/'.$dataContratoGog["nm_contrato_gog"].$this->dataCliente["co_seq_cliente"].'.pdf');
                $attachment = new Zend_Mime_Part($content);
                $attachment->type = 'application/pdf';
                $attachment->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
                $attachment->encoding = Zend_Mime::ENCODING_BASE64;
                $attachment->filename = $dataContratoGog["nm_contrato_gog"] . '.pdf';
                $mail->addAttachment($attachment);

                $mail->send($mailTransport);
                $mail->clearRecipients();
                $mail->clearSubject();
                // Cadastra Email
                $arrayEmail = array(
                    "co_cliente"=>$this->dataCliente["co_seq_cliente"],
                    "tx_mensagem"=>$mensagem,
                    "nm_email"=>$this->dataCliente["nm_email"],
                    "st_email"=>1,
                    "tp_email"=>1,
                    "nm_code"=>$this->code
                );
                $this->salvar($arrayEmail);

                $data["msg"] = "Email enviado com SUCESSSO!";
                $data["flag"] = 1;

                if($this->id_transaction_q != null) {
                    $modelExtrato = new Default_Model_DbTable_Extrato();
                    $modelExtrato->editByCodePagSeguro($this->id_transaction_q);
                }
                return true;
            } catch (Exception $e){
                $data["msg"] = "Algum erro aconteceu no envio do email!";
                $data["flag"] = 0;
                $data["error"] = $e->getMessage();
                return false;
            }
        }
    }

    public function sendBoleto($pdfArray=null, $dataConfiguracao){
        $this->pdfArray=$pdfArray;
        $modelEmail = new Default_Model_DbTable_Email();
        $modelEmail->clean();

        $mensagem  = '<br/><br/><center><h2>Próximo Boleto Mensal</h2></center><br/><br/>';
        $mensagem .= '<p align="justify">';
        $mensagem .=    $this->dataCliente["nm_cliente"].', segue em anexo o próximo boleto mensal.';
        $mensagem .= '</p><p><br/><br/><br/><br/><br/><br/></p>';
        $mensagem .= '<p><h3><font color=\'#742021\'>';
        $mensagem .= '  MarqSaúde + Vantagens para você!';
        $mensagem .= '</font></h3></p>';

        if($this->teste){
            $para = "tabx.php@gmail.com";
        }else{
            $para = $this->dataCliente["nm_email"];
        }
        $this->assunto = "Sistema - Envio de Boleto";

        try {
            //var_dump($dataConfiguracao, $this->view->dataCliente);exit;
            $config = array (
                'auth' => 'login',
                'username' => $dataConfiguracao["nm_email_login_cadastro"],
                'password' => $dataConfiguracao["nm_email_senha_cadastro"],
                'ssl'      => 'ssl',
                'port'     => $dataConfiguracao["nm_email_port_cadastro"]
            );
            /*$config = array (
                'auth' => 'login',
                'username' => "qsaudevantagens@gmail.com",
                'password' => "positivo1qaz",
                'ssl'      => 'ssl',
                'port'     => "465"
            );*/
            //$mailTransport = new Zend_Mail_Transport_Smtp("smtp.gmail.com", $config);
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
            $mail->setFrom($dataConfiguracao["nm_email_login_cadastro"], 'Contato MarqSaúde + Vantagens');

            $content = file_get_contents($dataConfiguracao["nm_url_absoluta"] . "/site/pdf/boleto/"  . $this->pdfArray[0]);
            $attachment = new Zend_Mime_Part($content);
            $attachment->type = 'application/pdf';
            $attachment->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
            $attachment->encoding = Zend_Mime::ENCODING_BASE64;
            $nuBoleto = str_replace(".pdf", "", $this->pdfArray[0]);
            $attachment->filename = 'boleto' . $nuBoleto . '.pdf';
            $mail->addAttachment($attachment);

            $mail->send($mailTransport);
            $mail->clearRecipients();
            $mail->clearSubject();

            // Cadastra Email
            $arrayEmail = array(
                "co_cliente"=>$this->dataCliente["co_seq_cliente"],
                "tx_mensagem"=>$mensagem,
                "nm_email"=>$this->dataCliente["nm_email"],
                "st_email"=>1,
                "tp_email"=>4,
                "nm_code"=>$this->code
            );
            $this->salvar($arrayEmail);

            if($this->id_transaction_q != null) {
                $modelExtrato = new Default_Model_DbTable_Extrato();
                $modelExtrato->editByCodePagSeguro($this->id_transaction_q);
            }
            return true;
        } catch (Exception $e){
            $data["msg"] = "Algum erro aconteceu no envio do email!";
            $data["flag"] = 0;
            $data["error"] = $e->getMessage();
            return false;
        }
    }

    public function resend($dataEmail=null, $pdfArray=null){
        $this->dataEmail=$dataEmail[0];
        $this->pdfArray=$pdfArray;
        /**
        CONFIGURAÇÃO PARA ENVIO DO EMAIL
         */
        $modelConfiguracao = new Default_Model_DbTable_Configuracao();
        $dataConfiguracao = $modelConfiguracao->getConfigurationAdmin();
        if($this->teste){
            $para = "tabx.php@gmail.com";
        }else{
            $para = $this->dataEmail["nm_email"];
        }
        $mensagem = $this->dataEmail["tx_mensagem"];
        $this->assunto = $this->dataEmail["nm_assunto"];

        try {
            //var_dump($dataConfiguracao, $this->view->dataCliente);exit;
            $config = array (
                'auth' => 'login',
                'username' => $dataConfiguracao["nm_email_login_cadastro"],
                'password' => $dataConfiguracao["nm_email_senha_cadastro"],
                'ssl'      => 'ssl',
                'port'     => $dataConfiguracao["nm_email_port_cadastro"]
            );
            /*$config = array (
                'auth' => 'login',
                'username' => "qsaudevantagens@gmail.com",
                'password' => "positivo1qaz",
                'ssl'      => 'ssl',
                'port'     => "465"
            );*/
            //$mailTransport = new Zend_Mail_Transport_Smtp("smtp.gmail.com", $config);
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
            $mail->setFrom($dataConfiguracao["nm_email_login_cadastro"], 'Contato MarqSaúde + Vantagens');

            if(isset($this->pdfArray) && $this->pdfArray!=null) {
                $i = 1;
                foreach ($this->pdfArray as $value) {
                    $content = file_get_contents($dataConfiguracao["nm_url_absoluta"] . "/site/pdf/boleto/" . $value["co_seq_boleto"] .".pdf");
                    $attachment = new Zend_Mime_Part($content);
                    $attachment->type = 'application/pdf';
                    $attachment->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
                    $attachment->encoding = Zend_Mime::ENCODING_BASE64;
                    $attachment->filename = 'boleto' . $i . '.pdf';
                    $mail->addAttachment($attachment);
                    $i++;
                }
            }

            $mail->send($mailTransport);
            $mail->clearRecipients();
            $mail->clearSubject();

            $data["msg"] = "Email enviado com SUCESSSO!";
            $data["flag"] = 1;
        } catch (Exception $e){
            $data["msg"] = "Algum erro aconteceu no envio do email!";
            $data["flag"] = 0;
            $data["error"] = $e->getMessage();
            die(json_encode($data));
        }
        if($this->id_transaction_q != null) {
            $modelExtrato = new Default_Model_DbTable_Extrato();
            $modelExtrato->editByCodePagSeguro($this->id_transaction_q);
        }
        die(json_encode(array("msn"=>"200 ok")));
    }

    public function sendTeste($pdfArray=null){
        $this->pdfArray=$pdfArray;
        $modelEmail = new Default_Model_DbTable_Email();
        if($modelEmail->checkEmailSend($this->dataCliente["co_seq_cliente"])){
            $modelEmail->clean();
            while($modelEmail->checkExist($this->code)==true){
                $this->gerarCodigo();
                $modelEmail->clean();
            }

            /**
            CONFIGURAÇÃO PARA ENVIO DO EMAIL
             */
            $modelConfiguracao = new Default_Model_DbTable_Configuracao();
            $dataConfiguracao = $modelConfiguracao->getConfigurationAdmin();
            $para = "tabx.php@gmail.com";
            //$para = $this->dataCliente["nm_email"];

            //$mensagem = "<br/><br/><center><h2>Cadastro efetuado com sucesso</h2></center><br/><br/>";
            //$mensagem .= "<p align='justify'>".$this->view->dataCliente["nm_cliente"].", seu cadastro foi realizado com sucesso, para inserir sua senha, clique no link que segue -><a href='http://192.168.20.25:8888/qsaude/public_html/cliente/senha/code/".$this->code."'>INSERIR SENHA</a>.</p>";
            //$mensagem .= "<p><h3>Nome: </h3> Teste</p>";
            //$mensagem .= "<p><h3>Email: </h3> teste@teste.com</p>";
            //$mensagem .= "<p><br/><br/><br/><br/><br/><br/></p>";
            //$mensagem .= "<p><h3><font color='#742021'>QSaúde Card para você!</font></h3></p>";
            $arrayDados = array($this->dataCliente["nm_cliente"], $dataConfiguracao["nm_url_sistema"], $this->code);
            $mensagem = $this->configDadosEmail($arrayDados, $dataConfiguracao["tx_email_cadastro"]);

            try {
                //var_dump($dataConfiguracao, $this->view->dataCliente);exit;
                $config = array (
                    'auth' => 'login',
                    'username' => $dataConfiguracao["nm_email_login_cadastro"],
                    'password' => $dataConfiguracao["nm_email_senha_cadastro"],
                    'ssl'      => 'ssl',
                    'port'     => $dataConfiguracao["nm_email_port_cadastro"]
                );
                /*$config = array (
                    'auth' => 'login',
                    'username' => "qsaudevantagens@gmail.com",
                    'password' => "positivo1qaz",
                    'ssl'      => 'ssl',
                    'port'     => "465"
                );*/
                //$mailTransport = new Zend_Mail_Transport_Smtp("smtp.gmail.com", $config);
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
                $mail->setFrom($dataConfiguracao["nm_email_login_cadastro"], 'Contato MarqSaúde + Vantagens');

                if(isset($this->pdfArray) && $this->pdfArray!=null) {
                    $i = 1;
                    foreach ($this->pdfArray as $value) {
                        $content = file_get_contents($dataConfiguracao["nm_url_absoluta"] . "/site/pdf/boleto/" . $value);
                        $attachment = new Zend_Mime_Part($content);
                        $attachment->type = 'application/pdf';
                        $attachment->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
                        $attachment->encoding = Zend_Mime::ENCODING_BASE64;
                        $attachment->filename = 'boleto' . $i . '.pdf';
                        $mail->addAttachment($attachment);
                        $i++;
                    }
                }

                $mail->send($mailTransport);
                $mail->clearRecipients();
                $mail->clearSubject();


                // Cadastra Email
                $arrayEmail = array(
                    "co_cliente"=>$this->dataCliente["co_seq_cliente"],
                    "tx_mensagem"=>$mensagem,
                    "nm_email"=>$this->dataCliente["nm_email"],
                    "st_email"=>1,
                    "tp_email"=>1,
                    "nm_code"=>$this->code
                );
                $this->salvar($arrayEmail);

                $data["msg"] = "Email enviado com SUCESSSO!";
                $data["flag"] = 1;
                var_dump($data["msg"]);
            } catch (Exception $e){
                $data["msg"] = "Algum erro aconteceu no envio do email!";
                $data["flag"] = 0;
                $data["error"] = $e->getMessage();
                die(json_encode($data));
            }
            if($this->id_transaction_q != null) {
                $modelExtrato = new Default_Model_DbTable_Extrato();
                $modelExtrato->editByCodePagSeguro($this->id_transaction_q);
            }
        }
    }

    private function salvar($array){
        $modelEmail = new Default_Model_DbTable_Email();
        $modelEmail->email->insertOne($array);
    }

    private function configDadosEmail($array, $mensagem){
        foreach($array as $value){
            $mensagem = Util_Util::strReplaceFirst('???', $value, $mensagem);
        }
        /*if($this->htmlArray != null){
            $mensagem .= "<br/><br/>";
            for($i=0; $i<count($this->htmlArray); $i++){
                $mensagem .= "Boleto ".($i+1).$this->htmlArray[$i]."<br/>";
            }
        }*/
        return $mensagem;
    }

}