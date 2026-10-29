<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

class InvoiceController extends Controller
{
    public function generate()
    {
        $pdf = Pdf::loadView('invoices.invoice');

        return $pdf->stream('invoice.pdf');
    }
}

Route::get('/invoice/pdf', [InvoiceController::class, 'generate'])
    ->name('invoice.pdf');
