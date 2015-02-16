<?php

namespace Pooling\Model;

// use Zend\InputFilter\Factory as InputFactory; 
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Pooling
{
	public $id;
	public $name;
	public $emailadd;
	public $browser;
	public $reason;
	public $timevote;
    public $inputFilter;

	public function exchangeArray($data)
    {
         $this->id     = (!empty($data['id'])) ? $data['id'] : null;
         $this->name = (!empty($data['name'])) ? $data['name'] : null;
         $this->emailadd  = (!empty($data['emailadd'])) ? $data['emailadd'] : null;
         $this->browser = (!empty($data['browser'])) ? $data['browser'] : null;
         $this->reason = (!empty($data['reason'])) ? $data['reason'] : null;
         $this->timevote = (!empty($data['timevote'])) ? $data['timevote'] : null;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
         throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) 
        { 
            $inputFilter = new InputFilter(); 
            // $factory = new InputFactory(); 
            
        $inputFilter->add(array(
                 'name'     => 'id',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
        ));

        $inputFilter->add(array( 
            'name' => 'browser', 
            'filters' => array( 
                array('name' => 'StripTags'), 
                array('name' => 'StringTrim'), 
            ), 
            'validators' => array( 
            ), 
        )); 
 
        $inputFilter->add(array( 
            'name' => 'name', 
            'required' => true, 
            'filters' => array( 
                array('name' => 'StripTags'), 
                array('name' => 'StringTrim'), 
            ), 
            'validators' => array( 
                array ( 
                    'name' => 'StringLength', 
                    'options' => array( 
                        'encoding' => 'UTF-8', 
                        'min' => '1', 
                        'max' => '100', 
                    ), 
                ), 
            ), 
        )); 
 
        $inputFilter->add(array(
            'name' => 'emailadd', 
            'filters' => array( 
                array('name' => 'StripTags'), 
                array('name' => 'StringTrim'), 
            ), 
            'validators' => array( 
                array ( 
                    'name' => 'StringLength', 
                    'options' => array( 
                        'encoding' => 'UTF-8', 
                        'min' => '1', 
                        'max' => '99', 
                    ), 
                ), 
                array ( 
                    'name' => 'EmailAddress', 
                    'options' => array( 
                        'messages' => array( 
                            'emailAddressInvalidFormat' => 'Email address format is not invalid', 
                        ) 
                    ), 
                ), 
                array ( 
                    'name' => 'NotEmpty', 
                    'options' => array( 
                        'messages' => array( 
                            'isEmpty' => 'Email address is required', 
                        ) 
                    ), 
                ), 
            ), 
        )); 
 
        $inputFilter->add(array(
            'name' => 'reason', 
            'required' => true, 
            'filters' => array( 
                array('name' => 'StripTags'), 
                array('name' => 'StringTrim'), 
            ), 
            'validators' => array( 
                array ( 
                    'name' => 'StringLength', 
                    'options' => array( 
                        'encoding' => 'UTF-8', 
                        'min' => '1', 
                        'max' => '998', 
                    ), 
                ), 
            ), 
        )); 
 
            $this->inputFilter = $inputFilter; 
        } 
        
        return $this->inputFilter;
    }
}

?>