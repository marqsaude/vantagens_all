<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 31/10/17
 * Time: 16:23
 */

class Default_Model_DbTable_Newsletter extends Zend_Db_Table_Abstract{

    public $newsletter;

    public function init()
    {
        $this->newsletter = new Util_ZendModelGeneric();
        $this->newsletter->construtor("newsletter");
    }

    public function getAllNewsletter(){
        $this->newsletter->query->from(array("n" => "tb_newsletter"), array('*'));
        $this->newsletter->query->order('n.dt_inclusao ASC');
        $this->newsletter->query->where('n.st_registro = 1');
        $data = $this->newsletter->returnQuery();
        return $data;
    }


}