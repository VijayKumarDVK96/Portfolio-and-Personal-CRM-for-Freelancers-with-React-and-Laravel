<?php

namespace App\Http\Controllers;

use App\Http\Traits\TitleTrait;
use App\Http\Traits\PlacesTrait;
use App\Http\Models\AccountStatements;
use App\Http\Models\Clients;
use App\Http\Models\UserDetail;
use App\Http\Models\Estimate;
use App\Http\Models\EstimateItem;
use App\Http\Models\Invoice;
use App\Http\Models\InvoiceItem;
use App\Http\Models\Project;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\EstimateRequest;
use App\Http\Requests\InvoiceRequest;
use App\Http\Requests\PaymentRequest;
use Illuminate\Http\Request;

class AccountsController extends Controller {

    use PlacesTrait, TitleTrait;

    public $title;

    public function __construct() {
        $this->title = $this->fetch_title();
        $this->currency_array = ['USD', 'INR', 'EUR', 'CAD'];
    }

    /********************/
    /*****ESTIMATES******/
    /********************/

    public function read_estimates() {
        $data['title'] = $this->title;
        return view('accounts.estimates')->with($data);
    }

    public function read_estimates_ajax(Request $request) {
        $data['estimates'] = Estimate::fetch_estimates($request);
        $view = view('accounts.estimates-ajax')->with($data)->render();

        return response()->json(['status' => 'success', 'view' => $view, 'count' => count($data['estimates'])]);
    }

    public function add_estimate() {
        $data['title'] = $this->title;
        $data['state_id'] = 35;
        $data['states'] = $this->states();
        $data['currency'] = $this->currency_array;
        // $data['projects'] = Project::read_projects();
        return view('accounts.add-estimate')->with($data);
    }

    public function create_estimate(EstimateRequest $request) {
        // echo '<pre>';print_r($request->validated());
        $data1 = [
            'estimate_number' => 'DVK'.rand(0, 9999).time(),
            'client_name' => $request->client_name,
            'company_name' => $request->company_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'state' => $request->state,
            'city' => $request->city,
            'country' => 'India',
            'estimate_date' => $request->estimate_date,
            'expiry_date' => $request->expiry_date,
            'description' => $request->other_information,
            'amount' => 0,
            'currency' => $request->currency,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $estimate = Estimate::create($data1);

        if ($estimate->id) {

            for ($i = 0; $i < count($request->item); $i++) {
                $total[] = $request->amount[$i];
                $data2 = [
                    'name' => $request->item[$i],
                    'description' => $request->description[$i],
                    'quantity' => $request->quantity[$i],
                    'unit_price' => $request->unit_cost[$i],
                    'total_price' => $request->amount[$i],
                ];

                $estimate->estimate_items()->create($data2);
            }

            $estimate->amount = array_sum($total);
            $estimate->save();
            
            $data = ['status' => 'success', 'message' => 'New Estimate Created'];
        } else {
            $data = ['status' => 'error', 'message' => 'Something Went Wrong'];
        }

        echo json_encode($data);
    }

    public function view_estimate($id) {
        $data['details'] = UserDetail::find(auth()->id());
        $data['estimate'] = Estimate::fetch_estimate($id);
        $grand_total = 0;

        foreach ($data['estimate']->estimate_items as $item) {
            $grand_total += $item->total_price;
        }
        $data['grand_total'] = $grand_total;
        $data['show_buttons'] = 1;
        // echo '<pre>';print_r($data['estimate']);exit;
        return view('accounts.view-estimate')->with($data);
    }

    public function edit_estimate($id) {
        $data['title'] = $this->title;
        $data['id'] = $id;
        $data['states'] = $this->states();
        $data['estimate'] = Estimate::fetch_estimate($id);
        $data['currency'] = $this->currency_array;
        $data['status'] = ['Open', 'Sent', 'Invoiced', 'Declined'];
        $grand_total = 0;

        foreach ($data['estimate']->estimate_items as $item) {
            $grand_total += $item->total_price;
        }
        $data['grand_total'] = $grand_total;

        return view('accounts.edit-estimate')->with($data);
    }

    public function update_estimate($id, EstimateRequest $request) {
        // echo '<pre>';print_r($request->validated());exit;

        $data1 = [
            'client_name' => $request->client_name,
            'company_name' => $request->company_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'state' => $request->state,
            'city' => $request->city,
            'currency' => $request->currency,
            'estimate_date' => $request->estimate_date,
            'expiry_date' => $request->expiry_date,
            'description' => $request->other_information,
            'status' => $request->status,
        ];

        Estimate::findOrFail($id)->update($data1);
        $estimate = Estimate::findOrFail($id);

        if ($estimate->id) {

            for ($i = 0; $i < count($request->item); $i++) {
                $total[] = $request->amount[$i];
                $data2 = [
                    'name' => $request->item[$i],
                    'description' => $request->description[$i],
                    'quantity' => $request->quantity[$i],
                    'unit_price' => $request->unit_cost[$i],
                    'total_price' => $request->amount[$i],
                ];

                EstimateItem::findOrFail($request->item_id[$i])->update($data2);
            }

            $estimate->amount = array_sum($total);
            $estimate->save();
            
            $data = ['status' => 'success', 'message' => 'Estimate Updated'];
        } else {
            $data = ['status' => 'error', 'message' => 'Something Went Wrong'];
        }

        echo json_encode($data);
    }

    public function send_estimate($id) {
        $data['details'] = UserDetail::find(1);
        $data['estimate'] = Estimate::fetch_estimate($id);
        $grand_total = 0;

        foreach ($data['estimate']->estimate_items as $item) {
            $grand_total += $item->total_price;
        }
        $data['grand_total'] = $grand_total;

        $this->email_id = $data['estimate']->email;
        $this->to = $data['estimate']->client_name;

        Mail::send('accounts.view-estimate', $data, function ($message) {
            $message->to($this->email_id, $this->to)
                ->subject('Project Quotation Estimate');
        });

        if(Mail::failures()) {
            $message = "Mail not sent";
        } else {
            $message = "Success";
            $estimate = Estimate::findOrFail($id);

            if($estimate->status == 'Open')
            $estimate->update(['status' => 'Sent']);
        }

        return redirect()->back()->with('message', $message);
    }

    public function delete_estimate(Request $request) {
        Estimate::findOrFail($request->id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Estimate Deleted']);
    }

    /********************/
    /******INVOICES******/
    /********************/

    public function read_invoices() {
        $data['title'] = $this->title;
        // $data['projects'] = Project::read_projects();
        return view('accounts.invoices')->with($data);
    }

    public function read_invoices_ajax(Request $request) {
        $data['invoices'] = Invoice::fetch_invoices($request);
        $view = view('accounts.invoices-ajax')->with($data)->render();

        return response()->json(['status' => 'success', 'view' => $view, 'count' => count($data['invoices'])]);
    }

    public function add_invoice() {
        $data['title'] = $this->title;
        $data['clients'] = Clients::orderBy('full_name')->get();
        $data['projects'] = Project::all();
        $data['payment'] = ['Cash', 'Online Payment', 'Cheque'];
        $data['currency'] = $this->currency_array;
        return view('accounts.add-invoice')->with($data);
    }

    public function create_invoice(InvoiceRequest $request) {
        // echo '<pre>';print_r($request->validated());
        $data1 = [
            'invoice_id' => 'DVK'.rand(0, 9999).time(),
            'client_id' => $request->client_name,
            'project_id' => $request->project_name,
            'payment_mode' => $request->payment_mode,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'description' => $request->other_information,
            'amount' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $invoice = Invoice::create($data1);

        if ($invoice->id) {

            for ($i = 0; $i < count($request->item); $i++) {
                $total[] = $request->amount[$i];
                $data2 = [
                    'name' => $request->item[$i],
                    'description' => $request->description[$i],
                    'quantity' => $request->quantity[$i],
                    'unit_price' => $request->unit_cost[$i],
                    'total_price' => $request->amount[$i],
                ];

                $invoice->invoice_items()->create($data2);
            }

            $invoice->amount = array_sum($total);
            $invoice->save();
            
            $data = ['status' => 'success', 'message' => 'New Invoice Created'];
        } else {
            $data = ['status' => 'error', 'message' => 'Something Went Wrong'];
        }

        echo json_encode($data);
    }

    public function view_invoice($id) {
        $data['details'] = UserDetail::find(auth()->id());
        $data['invoice'] = Invoice::fetch_invoice($id);
        $data['client'] = Clients::read_client($data['invoice']->client_id);
        $grand_total = 0;

        foreach ($data['invoice']->invoice_items as $item) {
            $grand_total += $item->total_price;
        }
        $data['grand_total'] = $grand_total;
        $data['show_buttons'] = 1;
        // echo '<pre>';print_r($data['estimate']);exit;
        return view('accounts.view-invoice')->with($data);
    }

    public function edit_invoice($id) {
        $data['title'] = $this->title;
        $data['clients'] = Clients::orderBy('full_name')->get();
        $data['projects'] = Project::all();
        $data['payment'] = ['Cash', 'Online Payment', 'Cheque'];
        $data['id'] = $id;
        $data['invoice'] = Invoice::fetch_invoice($id);
        $data['status'] = ['Open', 'Paid', 'Partially Paid', 'Cancelled', 'Refunded'];
        $data['currency'] = $this->currency_array;
        $grand_total = 0;

        foreach ($data['invoice']->invoice_items as $item) {
            $grand_total += $item->total_price;
        }
        $data['grand_total'] = $grand_total;

        // echo '<pre>';print_r($data['invoice']);exit;

        return view('accounts.edit-invoice')->with($data);
    }

    public function update_invoice($id, InvoiceRequest $request) {
        // echo '<pre>';print_r($request->validated());exit;

        $data1 = [
            'client_id' => $request->client_name,
            'project_id' => $request->project_name,
            'payment_mode' => $request->payment_mode,
            'currency' => $request->currency,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'description' => $request->other_information,
            'status' => $request->status,
        ];

        Invoice::findOrFail($id)->update($data1);
        $invoice = Invoice::findOrFail($id);

        if ($invoice->id) {

            for ($i = 0; $i < count($request->item); $i++) {
                $total[] = $request->amount[$i];
                $data2 = [
                    'name' => $request->item[$i],
                    'description' => $request->description[$i],
                    'quantity' => $request->quantity[$i],
                    'unit_price' => $request->unit_cost[$i],
                    'total_price' => $request->amount[$i],
                ];

                InvoiceItem::findOrFail($request->item_id[$i])->update($data2);
            }

            $invoice->amount = array_sum($total);
            $invoice->save();
            
            $data = ['status' => 'success', 'message' => 'Invoice Updated'];
        } else {
            $data = ['status' => 'error', 'message' => 'Something Went Wrong'];
        }

        echo json_encode($data);
    }

    public function send_invoice($id) {
        $data['details'] = UserDetail::find(1);
        $data['invoice'] = Invoice::fetch_invoice($id);
        $data['client'] = Clients::read_client($data['invoice']->client_id);
        $grand_total = 0;

        foreach ($data['invoice']->invoice_items as $item) {
            $grand_total += $item->total_price;
        }
        $data['grand_total'] = $grand_total;

        $this->email_id = $data['client']->email;
        $this->to = $data['client']->full_name;

        Mail::send('accounts.view-invoice', $data, function ($message) {
            $message->to($this->email_id, $this->to)
                ->subject('Project Invoice');
        });

        if(Mail::failures()) {
            $message = "Mail not sent";
        } else {
            $message = "Success";
            $invoice = Invoice::findOrFail($id);

            if($invoice->status == 'Open')
            $invoice->update(['status' => 'Invoiced']);
        }

        return redirect()->back()->with('message', $message);
    }

    public function delete_invoice(Request $request) {
        Invoice::findOrFail($request->id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Invoice Deleted']);
    }
    /********************/
    /******PAYMENTS******/
    /********************/

    public function read_payments() {
        $data['title'] = $this->title;
        return view('accounts.payments')->with($data);
    }

    public function read_payments_ajax(Request $request) {
        $data['payments'] = AccountStatements::fetch_payments($request);
        $credit_total = 0;
        $debit_total = 0;

        foreach($data['payments'] as $value) {
            $credit_total += ($value->statement_type == 1) ? $value->paid_amount : 0;
            $debit_total += ($value->statement_type == 0) ? $value->paid_amount : 0;
        }

        // $data['credit_total'] = $credit_total;
        // $data['debit_total'] = $debit_total;
        $view = view('accounts.payments-ajax')->with($data)->render();

        $tfoot = '<tr>
        <td colspan="4"></td>
        <td>Total Rs:<br>'.$credit_total.'</td>
        <td>Total Rs:<br>'.$debit_total.'</td>
        </tr>';

        return response()->json(['status' => 'success', 'view' => $view, 'count' => count($data['payments']), 'tfoot' => $tfoot]);
    }

    public function add_payment() {
        $data['title'] = $this->title;
        $data['clients'] = Clients::orderBy('full_name')->get();
        $data['projects'] = Project::all();
        $data['payment'] = ['Cash', 'Online Payment', 'Cheque'];
        return view('accounts.add-payment')->with($data);
    }

    public function create_payment(PaymentRequest $request) {
        $data = $request->validated();
        $data['created_at'] = date('Y-m-d H:i:s');

        $payment = AccountStatements::create($data);

        if ($payment->id) {
            $data = ['status' => 'success', 'message' => 'New Payment Created'];
        } else {
            $data = ['status' => 'error', 'message' => 'Something Went Wrong'];
        }

        echo json_encode($data);
    }

    public function edit_payment($id) {
        $data['id'] = $id;
        $data['title'] = $this->title;
        $data['clients'] = Clients::orderBy('full_name')->get();
        $data['projects'] = Project::all();
        $data['payment'] = ['Cash', 'Online Payment', 'Cheque'];
        $data['payment_data'] = AccountStatements::fetch_payment($id);
        // echo '<pre>';print_r($data['payment_data']);die;
        return view('accounts.edit-payment')->with($data);
    }

    public function update_payment(PaymentRequest $request, $id) {

        $payment = AccountStatements::find($id)->update($request->validated());
        // echo '<pre>';print_r($payment);die;

        if ($payment) {
            $data = ['status' => 'success', 'message' => 'Payment Details Updated'];
        } else {
            $data = ['status' => 'error', 'message' => 'Something Went Wrong'];
        }

        echo json_encode($data);
    }

    public function delete_payment(Request $request) {
        AccountStatements::findOrFail($request->id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Payment Deleted']);
    }

}