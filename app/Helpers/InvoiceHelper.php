<?php

namespace App\Helpers;

class InvoiceHelper
{
    public static function generateInvoice($orderType)
    {
        $prefix = substr($orderType, 0, 3);
        $invoiceNumber = uniqid($prefix);

        return $invoiceNumber;
    }
}
