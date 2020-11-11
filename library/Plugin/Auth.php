<?php

class Plugin_Auth extends Zend_Controller_Plugin_Abstract{


	public function preDispatch(Zend_Controller_Request_Abstract $request){

		//Verifição

		//$upload = $request->getParams();
		
		$module = $request->getModuleName();
		$controller = $request->getControllerName();
		$action = $request->getActionName();


		//if(($module != 'default') && ($upload != 'upload') && ($action != 'envia')){
		//if($module != 'default'){
			$auth = Zend_Auth::getInstance();
			$session_login = new Zend_Session_Namespace('Login');
			//$session_login_gog = new Zend_Session_Namespace('LoginGog');

			//if(!$auth->hasIdentity()){
			//var_dump($controller,$action);exit;
			//var_dump($session_login->logado);exit;
		//if(!$session_login->logado){var_dump("doido...");exit;}

		if(!$session_login->logado && $module=="admin" && $controller!="login"){
			//if($controller=="index"){
			//var_dump("por que?");exit;
				$request->setModuleName('admin');
				$request->setControllerName('login');
				$request->setActionName('index');
			//}
		}else{
			if($module=="admin" && $controller=="login" && $action=="index") {
				$request->setModuleName('admin');
				$request->setControllerName('index');
				$request->setActionName('index');
			}
		}



	}

}