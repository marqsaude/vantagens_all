<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 29/11/16
 * Time: 10:43
 */

class Admin_Model_Konsist_ArqMedico extends Zend_Db_Table {

    private $db;
    private $session_login;

    public function init(){
        if(Util_Util::whichOS()) {
            $this->db = Zend_Db::Factory('Pdo_Pgsql', array(
                'host' => '192.168.1.174',
                'username' => 'postgres',
                'dbname' => 'innpia',
                'password' => 'juizladrao'
            ));
        }else{
            $this->db = Zend_Db::Factory('Pdo_Pgsql', array(
                'host' => '201.48.29.225',
                'username' => 'postgres',
                'dbname' => 'innpia',
                'password' => 'juizladrao'
            ));
        }
        $this->session_login = new Zend_Session_Namespace('Login');
    }

    public function getTipoAgenda(){
        $sql = "select count(*) OVER() as full_count, m.*
                from public.arq_medico m
                where m.ind_status = 'Ativo'
                order by m.nom_medico desc";
        return $this->db->fetchAll($sql);
    }

}