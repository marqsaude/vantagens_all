<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 21/11/17
 * Time: 10:02
 */

class Admin_Model_DbTable_Blog extends Zend_Db_Table_Abstract
{

    public $blog;

    public function init()
    {
        $this->blog = new Util_ZendModelGeneric();
        $this->blog->construtor("blog");
    }

    public function getAllBlog($tpVisualizacao){
        $this->blog->query->from(array("b" => "tb_blog"), array('*'));
        $this->blog->query->where('b.st_registro = 1');
        $this->blog->query->where('b.tp_visualizacao IN (?)', $tpVisualizacao);
        $this->blog->query->order('b.dt_inclusao DESC');
        $data = $this->blog->returnQuery();
        return $data;
    }

    public function getBlogs($tpVisualizacao, $page=1, $per=10){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $page = ($page-1)*10;
        $sql  = "SELECT `b`.nm_blog, `b`.tx_blog, `b`.dt_inclusao, `b`.co_seq_blog, `b`.lk_img_blog, `u`.nm_usuario ";
        $sql .= "FROM `tb_blog` AS `b` ";
        $sql .= "INNER JOIN `tb_usuario` AS `u` ON b.co_usuario=u.co_seq_usuario ";
        $sql .= "WHERE (b.st_registro = 1) AND b.tp_visualizacao IN (";
        foreach($tpVisualizacao as $value){
            if ($value === end($tpVisualizacao)) {
                $sql .= "".$value;
            }else{
                $sql .= $value.", ";
            }
        }
        $sql .= " ) ";
        $sql .= "ORDER BY `b`.`dt_inclusao` DESC LIMIT ".intval($per)." OFFSET ".$page;
        $stmt = $db->query($sql);
        $data["data"] = $stmt->fetchAll();
        foreach($data["data"] as $value) {
            $dataProcedimento = $this->getProcedimentos($value["co_seq_blog"]);
            $data["data_procedimento"][$value["co_seq_blog"]] = $dataProcedimento;
        }
        $data["count"] = $this->getCount($tpVisualizacao);
        return $data;
    }

    public function getProcedimentos($idBlog){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql  = "SELECT `p`.co_exame, `p`.co_consulta, `p`.co_laboratorio, `e`.nm_exame, `c`.nm_consulta, `l`.nm_laboratorio , `p`.co_seq_procedimento ";
        $sql .= "FROM `tb_procedimento` AS `p` ";
        $sql .= "LEFT JOIN `rl_blog_procedimento` AS `rbp` ON rbp.co_procedimento=p.co_seq_procedimento ";
        $sql .= "LEFT JOIN `tb_exame` AS `e` ON p.co_exame=e.co_seq_exame ";
        $sql .= "LEFT JOIN `tb_consulta` AS `c` ON p.co_consulta=c.co_seq_consulta ";
        $sql .= "LEFT JOIN `tb_laboratorio` AS `l` ON p.co_laboratorio=l.co_seq_laboratorio ";
        $sql .= "WHERE (p.st_registro = 1 AND rbp.st_registro = 1) AND (rbp.co_blog = ".$idBlog.")";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }

    private function getCount($tpVisualizacao){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql = "select count(*) as contador from tb_blog as b";
        $sql .= " WHERE (b.st_registro = 1) AND b.tp_visualizacao IN (";
        foreach($tpVisualizacao as $value){
            if ($value === end($tpVisualizacao)) {
                $sql .= "".$value;
            }else{
                $sql .= $value.", ";
            }
        }
        $sql .= " ) ";
        $stmt = $db->query($sql);
        $users =  $stmt->fetchAll();
        return $users[0]["contador"];
    }

    public function clean(){
        $this->init();
    }

}