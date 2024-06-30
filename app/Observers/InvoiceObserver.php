<?php

namespace App\Observers;

use App\Models\Invoice;

class InvoiceObserver
{

    /**
     * Handle the Invoice "created" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function creating(Invoice $invoice)
    {
        $this->handleAddInvoiceNumber($invoice);
        $this->handleAddSerialNumber($invoice);
    }

    /**
     * Handle the Invoice "deleted" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function deleted(Invoice $invoice)
    {
       $this->handleDeleteInvoiceNumber($invoice);
       $this->handleDeleteSerialNumber($invoice);
    }

    public function handleAddInvoiceNumber($invoice)
    {

        if(Invoice::where('auction_stage_id',$invoice->auction_stage_id)->max('invoice_number') == null)
        {
            $invoice->invoice_number = 1;
            return;
        }

        if (is_null( $invoice->invoice_number)) 
        {
            $invoice->invoice_number = Invoice::where('auction_stage_id',$invoice->auction_stage_id)->max('invoice_number') + 1;
            return;
        }

        $lowerPriorityInvoices = Invoice::where('invoice_number', '>=', $invoice->invoice_number)
                                        ->where('auction_stage_id',$invoice->auction_stage_id)
                                        ->get();

        foreach ($lowerPriorityInvoices as $lowerPriorityInvoice) 
        {
            $lowerPriorityInvoice->invoice_number++;
            $lowerPriorityInvoice->saveQuietly();
        }
    }

    public function handleAddSerialNumber($invoice)
    {

        if(Invoice::max('serial_number') == null)
        {
            $invoice->serial_number = 1;
            return;
        }

        if (is_null($invoice->serial_number)) 
        {
            $invoice->serial_number = Invoice::max('serial_number') + 1;
            return;
        }

        $lowerPriorityInvoices = Invoice::where('serial_number', '>=', $invoice->serial_number)->get();

        foreach ($lowerPriorityInvoices as $lowerPriorityInvoice) 
        {
            $lowerPriorityInvoice->serial_number++;
            $lowerPriorityInvoice->saveQuietly();
        }
    }

    public function handleDeleteInvoiceNumber($invoice)
    {
        $lowerPriorityInvoices = Invoice::where('invoice_number', '>', $invoice->invoice_number)->get();
        foreach ($lowerPriorityInvoices as $lowerPriorityInvoice) {
            $lowerPriorityInvoice->invoice_number--;
            $lowerPriorityInvoice->saveQuietly();
        }
    }

    public function handleDeleteSerialNumber($invoice)
    {
        $lowerPriorityInvoices = Invoice::where('serial_number', '>', $invoice->serial_number)->get();
        foreach ($lowerPriorityInvoices as $lowerPriorityInvoice) {
            $lowerPriorityInvoice->serial_number--;
            $lowerPriorityInvoice->saveQuietly();
        }
    }

}
