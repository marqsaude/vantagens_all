<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 18/03/17
 * Time: 11:00
 */

class Gog_AssinaturaController extends Zend_Controller_Action
{

    public $session_login;
    public $posts;
    private $session_gog;
    private $file;
    private $folderAssinatura;
    private $folderContrato;
    private $folderContratoAssinado;
    private $extensionPDF = ".pdf";
    private $extensionPNG = ".png";
    private $isMobile=false;
    private $modelContratoGog;

    public function init()
    {

        $this->session_gog = new Zend_Session_Namespace('Gog');
        $this->session_login = new Zend_Session_Namespace('LoginGog');
        if ($this->session_login->logado == NULL) {
            $this->session_login->logado = false;
        }
        $this->modelContratoGog = new Gog_Model_DbTable_ContratoGog();
        $this->isMobile = Util_Util::isMobile();
        $this->view->session_login = $this->session_login;
        $this->_helper->layout->setLayout("layout-blank");
        $this->folderAssinatura = APPLICATION_PATH . '/../gogs/assinaturas/';
        $this->folderContrato = APPLICATION_PATH . '/../gogs/contrato/';
        $this->folderContratoAssinado = APPLICATION_PATH . '/../gogs/contrato-assinado/';
        $this->file = Util_Util::justNumbers($this->session_gog->cliente["nu_cpf"]).Util_Util::justNumbers($this->session_gog->cliente["nu_rg"]).Util_Util::justNumbers(date("Y-m-d"));

    }

    public function indexAction()
    {
        //$this->session_gog = new Zend_Session_Namespace('Gog');

    }

    public function ajaxAssinaAction(){
        $post = $this->_request->getPost();
        $namePath = $this->folderAssinatura . $this->file . $this->extensionPNG;
        $dataContratoGog = $this->getContratoGog($this->session_gog->acordo["co_contrato_gog"]);
        //error_log($namePath);
        //error_log($post["file"]);exit;
        try {
            if (!copy($post["file"], $namePath)) {
                echo "falha ao copiar" . $post["file"] . "...\n";
            } else {
                if ($this->isMobile) {
                    $this->createThumb($namePath);
                }
                $this->assinaContrato($dataContratoGog);
            }
            $this->session_gog->acordo = array("co_usuario"=>$this->session_login->coSeqCliente, "co_contrato_gog"=>$this->session_gog->acordo["co_contrato_gog"], "lk_contrato_assinatura"=>$this->file.$this->extensionPDF, "dt_finaliza"=>$this->getDateContrato($dataContratoGog), "dt_acordo"=>date("Y-m-d"));
            var_dump($this->session_gog->telefone, $this->session_gog->cliente, $this->session_gog->dependentes, $this->session_gog->cartao, $this->session_gog->pagamento, $this->session_gog->cep, $this->session_gog->acordo);exit;
        } catch(Exception $e){
            error_log($namePath, 3, "/Users/tony/logmeu.log");
            //error_log($e->getMessage(), 3, "/Users/tony/logmeu.log");
            //error_log($namePath);
            $e->getMessage();
            exit;
        }

        die(json_encode(array("session" => true)));
    }

    private function assinaContrato($dataContratoGog){
        //"/Applications/MAMP/htdocs/sitemarquesaude/gogs/assinaturas/gog.png"
        $pdf = null;
        try {
            $pdf = Zend_Pdf::load($this->folderContrato.$dataContratoGog[0]["lk_contrato_gog"]);
        } catch (Zend_Pdf_Exception $e) {
                throw $e;
        }

        $pdf->pages = array_reverse($pdf->pages);

// Create new Style
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0.9));
        $style->setLineColor(new Zend_Pdf_Color_GrayScale(0.2));
        $style->setLineWidth(1);
        $style->setLineDashingPattern(array(3, 2, 3, 4), 1);
        $fontH = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
        $style->setFont($fontH, 32);

        try {
            // Create new image object
            if($this->isMobile){
                $imageFile = $this->folderAssinatura . $this->file . "_thumbMobile" . $this->extensionPNG;
            }else {
                $imageFile = $this->folderAssinatura . $this->file . $this->extensionPNG;
            }
            $stampImage = Zend_Pdf_Image::imageWithPath($imageFile);
        } catch (Zend_Pdf_Exception $e) {
            // Example of operating with image loading exceptions.
            if ($e->getMessage() != 'Image extension is not installed.' &&
                $e->getMessage() != 'JPG support is not configured properly.') {
                throw $e;
            }
            $stampImage = null;
        }

        foreach ($pdf->pages as $page){
            $page->saveGS()
                ->setAlpha(1)
                ->setStyle($style);
                //->rotate(0, 0, M_PI_2/3);

            $page->saveGS();
            $page->clipCircle(290, 90, 157);
            if ($stampImage != null) {
                $page->drawImage($stampImage, 140, 0, 443, 170);
            }
            $page->restoreGS();

            $page->drawText('', 150, 0)
                ->restoreGS();
        }
        $pdf->save($this->folderContratoAssinado.$this->file.$this->extensionPDF);


    }

    private function createThumb($img) {
        $size=getimagesize($img);
        $widthImage = $size[0]*0.3;
        $heightImage = $size[1]*0.3;

        $this->createThumbb($img, $this->folderAssinatura.$this->file."_thumbMobile".$this->extensionPNG, "png", $widthImage, $heightImage);
    }

    private function createThumbb($img_name,$filename,$image_type,$new_w,$new_h){
        // Image extension
        $ext = str_replace('image/','',$image_type);
        // Creates the new image using the appropriate function from gd library
        if(!strcmp("jpg",$ext) || !strcmp("jpeg",$ext)){
            $src_img = imagecreatefromjpeg($img_name);
        }
        if(!strcmp("png",$ext)){
            $src_img = imagecreatefrompng($img_name);
        }
        if(!strcmp("gif",$ext)){
            $src_img = imagecreatefromgif($img_name);
        }
        // Gets the dimmensions of the image
        $old_x = imagesx($src_img);
        $old_y = imagesy($src_img);

        $ratio1 = $old_x/$new_w;
        $ratio2 = $old_y/$new_h;
        if($ratio1 > $ratio2) {
            $thumb_w = $new_w;
            $thumb_h = $old_y/$ratio1;
        }
        else {
            $thumb_h = $new_h;
            $thumb_w = $old_x/$ratio2;
        }

        $dst_img = imagecreatetruecolor($thumb_w, $thumb_h);
        if(!strcmp("png",$ext)) {
            imagealphablending($dst_img, false);
            imagesavealpha($dst_img, true);
            $transparent = imagecolorallocatealpha($dst_img, 255, 255, 255, 127);
            imagefilledrectangle($dst_img, 0, 0, $thumb_w, $thumb_h, $transparent);
        }

        // resize the big image to the new created one
        imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);

        // Output the created image to the file. Now we will have the thumbnail into the file named by $filename
        if(!strcmp("jpg",$ext) || !strcmp("jpeg",$ext)){
            imagejpeg($dst_img,$filename);
        }
        if(!strcmp("png",$ext)){
            imagepng($dst_img,$filename);
        }
        if(!strcmp("gif",$ext)){
            imagegif($dst_img,$filename);
        }

        // Destroys source and destination images
        imagedestroy($dst_img);
        imagedestroy($src_img);
    }

    private function getContratoGog($id){
        return $this->modelContratoGog->getContratoGog($id);
    }

    private function getDateContrato($dataContratoGog){
        $mes = $dataContratoGog[0]["nu_meses"];
        return date('Y-m-d', strtotime('+'.$mes.' month'));
    }

}