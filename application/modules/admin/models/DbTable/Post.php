<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 31/01/17
 * Time: 16:12
 */

class Admin_Model_DbTable_Post extends Zend_Db_Table_Abstract{

    public $post;

    public function init()
    {
        $this->post = new Util_ZendModelGeneric();
        $this->post->construtor("post");
    }

    public function getPosts($page=0){
        $this->post->query->from(array("p" => "tb_post"), array('*', 'p.dt_inclusao AS dt_registro'));
        $this->post->query->joinLeft(array("u" => "tb_usuario"), "u.co_seq_usuario=p.co_usuario");
        $this->post->query->joinLeft(array("c" => "tb_categoria"), "c.co_seq_categoria=p.co_categoria");
        $this->post->query->where('p.st_registro = ?', 1);
        $this->post->query->where('u.st_registro = ?', 1);
        $this->post->query->where('c.st_registro = ?', 1);
        $count = count($this->post->returnQuery());
        $this->post->query->order('p.dt_inclusao DESC');
        $this->post->query->limit(5, $page*5);
        $data["data"] = $this->post->returnQuery();
        $data["count"] = $count;
        return $data;
    }

    public function getPost($id){
        $this->post->query->from(array("p" => "tb_post"), array('*', 'p.dt_inclusao AS dt_registro'));
        $this->post->query->joinLeft(array("u" => "tb_usuario"), "u.co_seq_usuario=p.co_usuario");
        $this->post->query->joinLeft(array("c" => "tb_categoria"), "c.co_seq_categoria=p.co_categoria");
        $this->post->query->where('p.st_registro = ?', 1);
        $this->post->query->where('u.st_registro = ?', 1);
        $this->post->query->where('c.st_registro = ?', 1);
        $this->post->query->where('p.co_seq_post = ?', $id);
        return $this->post->returnQuery();
    }

}