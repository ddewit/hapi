<?php

namespace Harvest\Api;

use \Harvest\Api\AbstractApi;
use \Harvest\Exception;
use \Harvest\Model;

class Expense extends AbstractApi
{
    public function get($expense_id)
    {
        $url = "expenses/$expense_id";
        return $this->performGet($url, false);
    }
    
    public function getReceipt($expense_id)
    {
        $url = "expenses/$expense_id/receipt";
        return $this->performGet($url, false);
    }

    public function create(Model\Expense $expense)
    {
        $url = "expenses";
        return $this->performPost($url, $expense->toXml());
    }

    public function update(Model\Expense $expense)
    {
        $url = "expenses/$expense->id";
        return $this->performPut($url, $expense->toXml());
    }
    
    public function attachReceipt($expense_id, $image_path)
    {
        $url = "expenses/$expense_id/receipt";
        
        if(!file_exists($image_path)) {
            throw new Exception\HarvestRuntimeException(sprintf("Path to image does not exist or is not readable. Given: %s", $image_path))
        }
        
        $data = array('expense[receipt]' => file_get_contents($image_path));
        return $this->performMultiPart($url, $data);
    }
    
    public function delete($expense_id)
    {
        $url = "expenses/$expense_id";
        return $this->performDelete($url);
    }
}