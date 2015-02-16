<?php

namespace Pooling\Form;

use Zend\Captcha;
use Zend\Form\Form;
use Zend\Form\Element;

class PoolingForm extends Form
{
	public function __construct($name = null)
    {
    	parent::__construct('pool');

		$this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));

    	$this->add(array( 
            'name' => 'browser', 
            'type' => 'Zend\Form\Element\Radio', 
            'attributes' => array( 
                'id' => 'browser', 
                'required' => 'required', 
                'value' => 'Chrome', 
            ), 
            'options' => array( 
                'label' => 'Choose Your Favorite:', 
                'value_options' => array(
                    'Chrome' => 'Chrome', 
                    'Safari' => 'Safari', 
                    'Firefox' => 'Firefox', 
                    'IExplorer' => 'IExplorer', 
                    'Opera' => 'Opera', 
                    'Lynx' => 'Lynx', 
                ),
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'name', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'id' => 'name', 
                'placeholder' => 'Enter Name', 
                'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'Name:', 
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'emailadd', 
            'type' => 'Zend\Form\Element\Email', 
            'attributes' => array( 
                'id' => 'emailadd', 
                'placeholder' => 'Enter Email Address', 
                'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'Email:', 
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'reason', 
            'type' => 'Zend\Form\Element\Textarea', 
            'attributes' => array( 
                'id' => 'reason',
                'placeholder' => 'Enter Reason',
                'required' => 'required',
            ), 
            'options' => array( 
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'csrf', 
            'type' => 'Zend\Form\Element\Csrf', 
        ));

		$this->add(array(
			'name' => 'submit',
			'type' => 'Submit',
			'attributes' => array(
				'value' => 'Vote',
				'id' => 'submitbutton',
				'class' => 'button small',
			),
		));
    }
	
}

?>