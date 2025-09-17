<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class AccountStatements extends Model {

    public $timestamps = false;

    protected $fillable = ['client_id', 'project_id', 'paid_amount', 'paid_at', 'payment_type', 'statement_type', 'purpose', 'description', 'created_at'];

    public static function fetch_payments($request) {
        $invoice = AccountStatements::select('account_statements.*', 'clients.full_name as client_name', 'projects.name as project_name');
        $invoice->leftJoin('clients', 'account_statements.client_id', '=', 'clients.id');
        $invoice->leftJoin('projects', 'account_statements.project_id', '=', 'projects.id');

        if ($request->statement_type || $request->statement_type == '0') {
            $invoice = $invoice->where('account_statements.statement_type', $request->statement_type);
        }

        if ($request->from && $request->to) {
            $invoice = $invoice->whereBetween('account_statements.paid_at', [$request->from, $request->to]);
        }

        return $invoice->get();
    }

    public static function fetch_payment($id) {
        return AccountStatements::findOrFail($id);
    }

}
