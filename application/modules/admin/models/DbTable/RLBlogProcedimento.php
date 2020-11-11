<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 22/11/17
 * Time: 10:17
 */

class Admin_Model_DbTable_RLBlogProcedimento extends Zend_Db_Table_Abstract{

    public $blogProcedimento;

    public function init()
    {
        $this->blogProcedimento = new Util_ZendModelGeneric();
        $this->blogProcedimento->construtorRL("blog_procedimento");
    }

    public function deleta($idBlog){
        $session_login = new Zend_Session_Namespace('Login');
        $data["st_registro"] = 2;
        $data["nm_alteracao"] = $session_login->nmPaciente;
        $data["dt_alteracao"] = Util_Util::getDateMysqlNow();
        $this->blogProcedimento->update($data, array("co_blog" => $idBlog));
    }

    public function clean(){
        $this->init();
    }

}