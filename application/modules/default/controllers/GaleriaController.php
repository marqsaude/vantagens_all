<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 09/11/17
 * Time: 10:23
 */

class Default_GaleriaController extends Zend_Controller_Action {

    private $session_login;

    public function init(){

        $this->session_login = new Zend_Session_Namespace('Login');
        $this->_helper->layout->setLayout("layout");
        $this->view->isMobile = Util_Util::isMobile();

    }

    public function indexAction(){
        $modelConfiguracao = new Default_Model_DbTable_Configuracao();
        $dataConfiguracao=$modelConfiguracao->getConfigurationAdmin();
        $dirname = $dataConfiguracao["nm_url_absoluta"]."/site/images/galeria/";
        //var_dump($dirname);exit;
        $this->view->images = glob($dirname."*.JPG");
        //var_dump($this->view->images);exit;
        $this->view->session_login = $this->session_login;
        //$this->createThumbs("/Applications/MAMP/htdocs".$this->view->baseUrl()."/site/images/galeria/", "/Applications/MAMP/htdocs".$this->view->baseUrl()."/site/images/galeria/thumbnails/", 237);
    }

    private function createThumbs($pathToImages, $pathToThumbs, $thumbWidth )
    {
        // open the directory
        $dir = opendir($pathToImages);

        // loop through it, looking for any/all JPG files:
        while (false !== ($fname = readdir($dir))) {
            // parse path for the extension
            $info = pathinfo($pathToImages . $fname);
            // continue only if this is a JPEG image
            if (strtolower($info['extension']) == 'jpg') {
                echo "Creating thumbnail for {$fname} <br />";

                //var_dump("{$pathToImages}{$fname}");exit;
                // load image and get image size
                $img = imagecreatefromjpeg("{$pathToImages}{$fname}");
                $width = imagesx($img);
                $height = imagesy($img);

                // calculate thumbnail size
                $new_width = $thumbWidth;
                $new_height = floor($height * ($thumbWidth / $width));

                // create a new temporary image
                $tmp_img = imagecreatetruecolor($new_width, $new_height);

                // copy and resize old image into new image
                imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

                // save thumbnail into a file
                imagejpeg($tmp_img, "{$pathToThumbs}{$fname}");
            }
        }
        // close the directory
        closedir($dir);
    }

}