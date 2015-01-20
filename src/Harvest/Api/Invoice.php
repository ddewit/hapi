<?php

namespace Harvest\Api;

use \Harvest\Api\AbstractApi;
use \Harvest\Model;

class Invoice extends AbstractApi
{
    
    public function all(Model\Filter\Invoice $filter = null)
    {
        $url = "invoices";
        
        if($filter !== null) {
            $this->setUrlParameters($filter->toArray());
        }
        
        return $this->performGet($url, true);
    }

    public function allInvoicesForClient($client_id)
    {
        $url = "invoices";
        $this->setUrlParameters(array('client' => $client_id));
        
        return $this->performGet($url, true);
    }

    public function get($invoice_id)
    {
        $url = "invoices/$invoice_id";
        return $this->performGet($url, false);
    }

    public function create(Model\Invoice $invoice)
    {
        $url = "invoices";
        return $this->performPost($url, $invoice->toXml());
    }

    public function update(Model\Invoice $invoice)
    {
        $url = "invoices/$invoice->id";
        return $this->performPut($url, $project->toXml());
    }

    public function delete($invoice_id)
    {
        $url = "invoices/$invoice_id";
        return $this->performDelete($url);
    }
}
