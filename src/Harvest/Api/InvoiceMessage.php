<?php

namespace Harvest\Api;

use \Harvest\Api\AbstractApi;
use \Harvest\Model;

class InvoiceMessage extends AbstractApi
{
    public function all($invoice_id, $updated_since = null)
    {
        $url = "invoices/$invoice_id/messages";
        $this->appendUpdatedSinceParam($updated_since);
        return $this->performGet($url, true);
    }
    
    public function getForInvoice($message_id, $invoice_id)
    {
        $url = "invoices/$invoice_id/messages";
        return $this->performGet($url, true);
    }

    public function send(Model\InvoiceMessage $invoice_message, $invoice_id)
    {
        $url = "invoices/$invoice_id/messages";
        return $this->performPost($url, $invoice_message->toXml());
    }
    
    public function createSent(Model\InvoiceMessage $invoice_message, $invoice_id)
    {
        $url = "invoices/$invoice_id/messages/mark_as_sent";
        return $this->performPost($url, $invoice_message->toXml());
    }
    
    public function createDraft(Model\InvoiceMessage $invoice_message, $invoice_id)
    {
        $url = "invoices/$invoice_id/messages/mark_as_draft";
        return $this->performPost($url, $invoice_message->toXml());
    }
    
    public function createClosed(Model\InvoiceMessage $invoice_message, $invoice_id)
    {
        $url = "invoices/$invoice_id/messages/mark_as_closed";
        return $this->performPost($url, $invoice_message->toXml());
    }
    
    public function createReopen(Model\InvoiceMessage $invoice_message, $invoice_id)
    {
        $url = "invoices/$invoice_id/messages/re_open";
        return $this->performPost($url, $invoice_message->toXml());
    }
    
    public function delete($invoice_message_id, $invoice_id)
    {
        $url = "invoices/$invoice_id/messages/$invoice_message_id";
        return $this->performDelete($url);
    }
}