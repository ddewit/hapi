<?php

namespace Harvest\Api;

use \Harvest\Api\AbstractApi;
use \Harvest\Model;

class InvoiceItemCategory extends AbstractApi
{
    public function all($updated_since = null)
    {
        $url = "invoice_item_categories";
        $this->appendUpdatedSinceParam($updated_since);
        return $this->performGet($url, true);
    }

    public function create(Model\InvoiceItemCategory $invoice_item_category)
    {
        $url = "invoice_item_categories";
        return $this->performPost($url, $invoice_item_category->toXml());
    }

    public function update(Model\InvoiceItemCategory $invoice_item_category)
    {
        $url = "invoice_item_categories/$invoice_category->id";
        return $this->performPut($url, $invoice_item_category->toXml());
    }
    
    public function delete($invoice_item_category_id)
    {
        $url = "invoice_item_categories/$invoice_item_category_id";
        return $this->performDelete($url);
    }
}