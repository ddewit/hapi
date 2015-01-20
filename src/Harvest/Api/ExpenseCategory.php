<?php

namespace Harvest\Api;

use \Harvest\Api\AbstractApi;
use \Harvest\Model;

class ExpenseCategory extends AbstractApi
{
    public function all($updated_since = null)
    {
        $url = "/expense_categories";
        $this->appendUpdatedSinceParam($updated_since);
        return $this->performGet($url, true);
    }

    public function get($expense_category_id)
    {
        $url = "expense_categories/$expense_category_id";
        return $this->performGet($url, false);
    }

    public function create(Model\ExpenseCategory $expense_category)
    {
        $url = "expense_categories";
        return $this->performPost($url, $expense_category->toXml());
    }

    public function update(Model\ExpenseCategory $expense_category)
    {
        $url = "expense_categories/$expense_category->id";
        return $this->performPut($url, $expense_category->toXml());
    }
    
    public function toggle($expense_category_id)
    {
        $url = "expense_categories/$expense_category_id/toggle";
        return $this->performDelete($url);
    }
    
    public function delete($expense_category_id)
    {
        $url = "expense_categories/$expense_category_id";
        return $this->performDelete($url);
    }
}