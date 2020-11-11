<?php

class Default_Form_Login extends Zend_Form
{

	public function init()
	{
		/* Form Elements & Other Definitions Here ... */
		 
		$this->setMethod('post');
		$this->setAction('');

		$usuario 	= $this->createElement('text', 'usuarioLogin')
		->setLabel('Login')
		->setRequired(true)
		->setAllowEmpty(true)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->setAttribs(array(	'name'=>'usuarioLogin',
    						'placeholder'=>'Login'))
		->setDecorators(array(
    						'ViewHelper',			//input
    						'Errors',
    						'Description',
		array('Label', array('tag'=>'for')),
		array(array('inner'=>'HtmlTag'),array('tag'=>'div', 'id'=>'username_field')),
		array('errors',array('tag'=>'p', 'div'=>'error'))
		));


		$senha		= $this->createElement('password', 'senhaLogin')
		->setLabel('Senha')
		->setRequired(true)
		->setAllowEmpty(true)
		->setAttribs(array(	'name'=>'senhaLogin',
    						'placeholder'=>'Senha'))
		->setDecorators(array(
    						'ViewHelper',
    						'Errors',
    						'Description',
		array('Label', array('tag'=>'for')),
		array(array('inner'=>'HtmlTag'), array('tag'=>'div', 'id'=>'password_field')),
		array('errors',array('tag'=>'p', 'div'=>'error'))
		));



		$submit 	= $this->createElement('Submit', 'Entrar')
		->setAttribs(array ('name'=>'button',
											'id'=>'loginbutton',
    										'class'=>'float_left width_4'))
		->setDecorators(array(
    						'ViewHelper',
    						'Description',
		array(array('inner'=>'HtmlTag'), array('tag'=>'div', 'id'=>'buttonline'))
		));

			
		$this->addElements(array($usuario, $senha, $submit));
		 
	}


}

