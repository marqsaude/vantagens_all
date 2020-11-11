<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 08/02/16
 * Time: 10:30
 */

class Admin_Model_Konsist_ArqAgenda extends Zend_Db_Table {

    //private $urlRest = "http://192.168.1.73:8080/servletIndexador/rest/exames/konsist/";
    private $urlRest = "http://201.48.29.225:8080/servletIndexador/rest/exames/konsist/";
    private $username = "tabx";
    private $password = "123";
    private $usernamePOST = "admin";
    private $passwordPOST = "1qaz2wsx";
    private $session_login;

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
    }

    public function getObjectJson($nuAtendimento){
        //$url = "http://201.86.129.162:8080/rest/exames/atendimento/".$nuAtendimento;
        $url = $this->urlRest."atendimento/".$nuAtendimento;
        //var_dump()
        return $this->getReturn($url);
        //$data = json_encode( $vars );
    }

    public function getAgendaPaciente($nuProntuario, $page){
        $url = $this->urlRest."agenda/paciente/".$nuProntuario."/pagina/".$page;
        return $this->getReturn($url);
    }

    public function getAgendaByAtendimento($nuAtendimento){
        $url = $this->urlRest."agenda/atendimento/".$nuAtendimento;
        return $this->getReturn($url);
    }

    public function getAgendaConsulta($nuProntuario){
        $url = $this->urlRest."agenda/consulta/prontuario/".$nuProntuario;
        return $this->getReturn($url);
    }

    public function getAgendaExame($nuProntuario){
        $url = $this->urlRest."agenda/exame/prontuario/".$nuProntuario;
        return $this->getReturn($url);
    }

    public function getReturn($url){
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_USERPWD, $this->username . ":" . $this->password);
        curl_setopt($handle, CURLOPT_TIMEOUT, 30);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handle, CURLOPT_POST, false);
        curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'GET');
        //curl_setopt($handle, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($handle);
        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        return $response;
    }

    public function postReturn($url){
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_USERPWD, $this->usernamePOST . ":" . $this->passwordPOST);
        curl_setopt($handle, CURLOPT_TIMEOUT, 30);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handle, CURLOPT_POST, false);
        curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'POST');
        //curl_setopt($handle, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($handle);
        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        return $response;
    }

    public function arqsAgenda($page, $data, $datap){
        $page--;
        $sql = "select count(*) OVER() as full_count, aa.*, se.des_setor, co.nom_convenio, me.nom_medico, pa.nom_paciente
                from public.arq_agendal aa
                left join public.tab_setor se on aa.cod_setor = se.cod_setor
                left join public.tab_convenio co on aa.id_convenio = co.id_convenio
                left join public.arq_medico me on aa.id_medico = me.id_medico
                left join public.arq_paciente pa on aa.cod_paciente = pa.cod_paciente
                where pa.num_prontuario = '".$this->session_login->nmLogin."'
               order by aa.dat_marcacao desc
                limit 15 offset ".$page*15;
        return $this->db->fetchAll($sql);
    }

    public function examesRealizados($page){
        $page--;
        $sql = "select count(*) OVER() as full_count, aa.*, se.des_setor, co.nom_convenio, me.nom_medico, pa.nom_paciente, sh.nom_usuario
                from public.arq_agendal aa
                left join public.tab_setor se on aa.cod_setor = se.cod_setor
                left join public.tab_convenio co on aa.id_convenio = co.id_convenio
                left join public.arq_medico me on aa.id_medico = me.id_medico
                left join public.arq_paciente pa on aa.cod_paciente = pa.cod_paciente
                left join public.tab_senha sh on aa.id_usuario = sh.id_usuario
                where pa.num_prontuario = '".$this->session_login->nmLogin."'
               order by aa.dat_marcacao desc
                limit 15 offset ".$page*15;
        return $this->db->fetchAll($sql);
    }

    public function getAgendaConsultas($page){
        $sql = "select count(*) OVER() as full_count, aa.*, me.nom_medico, pa.nom_paciente, sh.nom_usuario
                from public.arq_agendal aa
                left join public.arq_medico me on aa.id_medico = me.id_medico
                left join public.arq_paciente pa on aa.cod_paciente = pa.cod_paciente
                left join public.tab_senha sh on aa.id_usuario = sh.id_usuario
                where pa.num_prontuario = '".$this->session_login->nmLogin."' and me.ind_tipo_medico='P'
                order by aa.dat_marcacao desc
                limit 15 offset ".$page*15;
        return $this->db->fetchAll($sql);
    }

}