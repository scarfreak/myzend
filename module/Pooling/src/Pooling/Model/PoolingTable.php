<?php

namespace Pooling\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Select;  

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