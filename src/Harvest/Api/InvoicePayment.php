<?php

namespace Harvest\Api;

use \Harvest\Api\AbstractApi;
use \Harvest\Model;

class InvoicePayment extends AbstractApi
{
    public function allForInvoice($invoice_id, $updated_since = null)
    {
        $url = "invoices/$invoice_id/payments";
        $this->appendUpdatedSinceParam($updated_since);
        return $this->performGet($url, true);
    }
    
    public function getForInvoice($invoice_payment_id, $invoice_id)
    {
        $url = "invoices/$invoice_id/payments/$invoice_payment_id";
        return $this->performGet($url, true);
    }

    public function create(Model\InvoicePayment $invoice_payment, $invoice_id)
    {
        $url = "invoices/$invoice_id/payments";
        return $this->performPost($url, $invoice_payment->toXml());
    }

    public function delete($invoice_payment_id, $invoice_id)
    {
        $url = "invoices/$invoice_id/payments/$invoice_payment_id";
        return $this->performDelete($url);
    }
}
