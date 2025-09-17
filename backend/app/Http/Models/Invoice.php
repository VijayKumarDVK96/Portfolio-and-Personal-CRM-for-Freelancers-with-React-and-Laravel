<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {

    public $timestamps = false;

    protected $fillable = ['invoice_id', 'client_id', 'project_id', 'amount', 'payment_mode', 'currency', 'status', 'invoice_date', 'due_date', 'description', 'created_at'];

    public function invoice_items() {
        return $this->hasMany('App\Http\Models\InvoiceItem');
    }

    public static function fetch_invoice($id) {
        return Invoice::with('invoice_items')->where('id', $id)->first();
    }

    public static function fetch_invoices($request) {
        $invoice = Invoice::select('invoices.*', 'clients.full_name as client_name', 'projects.name as project_name');
        $invoice->leftJoin('clients', 'invoices.client_id', '=', 'clients.id');
        $invoice->leftJoin('projects', 'invoices.project_id', '=', 'projects.id');

        if ($request->status) {
            $invoice = $invoice->where('invoices.status', $request->status);
        }

        if ($request->from && $request->to) {
            $invoice = $invoice->whereBetween('invoices.invoice_date', [$request->from, $request->to]);
        }

        return $invoice->get();
    }
}
