<?php

namespace Pooling\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Validator; 
use Pooling\Model\Pooling;       
use Pooling\Form\PoolingForm;

class PoolingController extends AbstractActionController
{

	protected $poolingTable;

	public function indexAction()
	{
		return new ViewModel(array(
             'pools' => $this->getPoolingTable()->fetchAllfiltered(),
             'poolcounts' => $this->getPoolingTable()->fetchAll(),
         ));
	}

	public function browserAction()
	{
		$id = (string) $this->params()->fromRoute('id');
		if (!$id){
			return $this->redirect()->toRoute('pool');
		}

		try{
			return new ViewModel(array(
			 'id'	=> $id,
             'pools' => $this->getPoolingTable()->fetchBrowser($id),
             'poolcounts' => $this->getPoolingTable()->fetchBrowser($id),
         	));
		}catch (\Exception $ex){
			return $this->redirect()->toRoute('pool');
		}

		return new ViewModel(array(
			 'id'	=> $id,
             'pools' => $this->getPoolingTable()->fetchBrowser($id),
             'poolcounts' => $this->getPoolingTable()->fetchBrowser($id),
         ));
	}

	public function chooseAction()
	{
		$form = new PoolingForm();
		$request = $this->getRequest();

		if($request->isPost())
		{
			$pool = new Pooling();
			$form->setInputFilter($pool->getInputFilter());
			$form->setData($request->getPost());

			if(!$form->isValid())
			{
				$pool->exchangeArray($form->getData());
				$this->getPoolingTable()->savePooling($pool);

				return $this->redirect()->toRoute('pool');
			}
			
		}

		return array('form' => $form);
	}

	public function getPoolingTable()
	{
		if(!$this->poolingTable)
		{
			$pt = $this->getServiceLocator();
			$this->poolingTable = $pt->get('Pooling\Model\PoolingTable');
		}
		return $this->poolingTable;
	}
}

?>