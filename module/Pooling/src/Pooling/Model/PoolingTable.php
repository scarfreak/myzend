<?php

namespace Pooling\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Select;  
use Zend\Db\ResultSet\ResultSet;

class PoolingTable
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	public function fetchAllfiltered()
	{
		$resultSet = $this->tableGateway->select(function(Select $select){
			$select->group('browser');
			$select->order('timevote ASC');
		});
		return $resultSet;
	}

	public function fetchBrowser($browser)
	{
		$browser = (string) $browser;
		$where = new Where();
		$where->like('browser', $browser);
		$resultSet = $this->tableGateway->select($where);
        return $resultSet;
	}

	public function getRecordCountAll()
	{
		$qryChrome = $this->tableGateway->select(function (Select $select){
			$select->columns(array(
					'Chrome' => new \Zend\Db\Sql\Expression('FORMAT(((COUNT(browser) / 100) * 100),0)')
				));
			$select->where('browser','Chrome');
		});

		$qrySafari = $this->tableGateway->select(function (Select $select){
			$select->columns(array(
					'Safari' => new \Zend\Db\Sql\Expression('FORMAT(((COUNT(browser) / 100) * 100),0)')
				));
			$select->where('browser','Safari');
		});

		$qryFirefox = $this->tableGateway->select(function (Select $select){
			$select->columns(array(
					'Firefox' => new \Zend\Db\Sql\Expression('FORMAT(((COUNT(browser) / 100) * 100),0)')
				));
			$select->where('browser','Firefox');
		});

		$qryIExplorer = $this->tableGateway->select(function (Select $select){
			$select->columns(array(
					'IExplorer' => new \Zend\Db\Sql\Expression('FORMAT(((COUNT(browser) / 100) * 100),0)')
				));
			$select->where('browser','IExplorer');
		});

		$qryOpera = $this->tableGateway->select(function (Select $select){
			$select->columns(array(
					'Opera' => new \Zend\Db\Sql\Expression('FORMAT(((COUNT(browser) / 100) * 100),0)')
				));
			$select->where('browser','Opera');
		});

		$qryLynx = $this->tableGateway->select(function (Select $select){
			$select->columns(array(
					'Lynx' => new \Zend\Db\Sql\Expression('FORMAT(((COUNT(browser) / 100) * 100),0)')
				));
			$select->where('browser','Lynx');
		});

		$mainselect = $this->tableGateway->select(function(Select $select){
			$select->columns(array(
					'Chrome' => array('?',array($qryChrome)),
					'Safari' => array('?',array($qrySafari)),
					'Firefox' => array('?',array($qryFirefox)),
					'IExplorer' => array('?',array($qryIExplorer)),
					'Opera' => array('?',array($qryOpera)),
					'Lynx' => array('?',array($qryLynx)),
				));
			$select->group('browser');
			$select->limit(0,1);
		});

		$statement = $this->tableGateway->prepareStatementForSqlObject($mainselect);
		$comments = $statement->execute();
		$resultSet = new resultSet();
		$resultSet->initialize($comments);

		return $resultSet->toArray();

	}

	public function getPooling($emailadd)
	{
		 $emailadd  = (string) $emailadd;
         $rowset = $this->tableGateway->select(array('emailadd' => $emailadd));
         $row = $rowset->current();
         if (!$row) {
         	return $row;
             //throw new \Exception("Could not find row $emailadd");
         }
         return $row;
	}

	// public function getPoolDate()
	// {
 //         $rowset = $this->tableGateway->select('Now()');
 //         // $row = $rowset->current();
 //         return $rowset;
	// }

	public function savePooling(Pooling $pool)
	{
		// $date = $this->getPoolDate();
		$data = array(
			'name' => $pool->name,
			'emailadd' => $pool->emailadd,
			'browser' => $pool->browser,
			'reason' => $pool->reason,
			// 'timevote' => $date,
		);

		$emailadd = (string) $pool->emailadd;
		if(!$this->getPooling($emailadd))
		{
			$this->tableGateway->insert($data);
		}
		else
		{
			if($this->getPooling($emailadd)){
				$this->tableGateway->update($data, array('emailadd' => $emailadd));
			}else{
				throw new \Exception('Pool emailadd does not exist');
			}
		}
	}
}

?>