<?php

namespace App\Http\Controllers;

use App\Http\Models\Enquiry;
use App\Http\Models\UserDetail;
use App\Http\Models\Project;
use App\Http\Models\ProjectsCategory;
use App\Http\Traits\PlacesTrait;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\SendEnquiryRequest;

class HomeController extends Controller {

    use PlacesTrait;

    public function index() {
        $data['title'] = 'Vijay Kumar DVK';
        $data['description'] = 'Vijay Kumar DVK: Expert Web Developer with 6+ years in Madurai, India. Specializing in PHP, MySQL, HTML, CSS, Jquery, and JavaScript for top-notch web development services.';
        $data['keywords'] = 'freelance web developer in madurai, web developer in madurai, web designer in madurai, freelance web designer in madurai, software developer in madurai, freelance software engineer in madurai, best web developer in madurai.';
        $data['details'] = UserDetail::read_user_details(1);
        $data['projects'] = Project::fetch_projects_for_home();
        $data['projects_category'] = ProjectsCategory::all();
        return view('home.index')->with($data);
    }

    public function sitemap() {
        $projects = Project::fetch_projects_for_home();
        return response()->view('home.sitemap', ['projects' => $projects])->header('Content-Type', 'text/xml');
    }

    public function google() {
        return view('home.google');
    }

    public function send_enquiry(SendEnquiryRequest $request) {

        $enquiry = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        Enquiry::create($enquiry);

        $mail['name'] = $request->name;
        $mail['phone'] = $request->phone;
        $mail['email'] = $request->email;
        $mail['subject'] = $request->subject;
        $mail['contact_message'] = $request->message; // Note: A $message variable is always passed to e-mail views, and allows the inline embedding of attachments. So, it is best to avoid passing a message variable in your view payload. Here, using as contact_message.

        $this->to = $request->name;

        Mail::send('home.contact-enquiry-submit-mail', $mail, function ($message) {
            $message->to('vijay.dvk96@gmail.com', 'Vijay Kumar')->subject('New Enquiry - '. $this->to);
        });

        if (Mail::failures()) {
            $mail_sent = "Mail not sent";
        } else {
            $mail_sent = "Success";
        }

        $data = ['status' => 'success', 'message' => 'Enquiry Submitted', 'mail_status' => $mail_sent];
        return response()->json($data);
    }

    public function view_portfolio_details($slug) {
        $data['project'] = Project::fetch_portfolio_details_by_slug($slug);
        $data['title'] = $data['project']->name.' - Vijay Kumar DVK';
        $data['description'] = $data['project']->meta_description;
        $data['keywords'] = $data['project']->meta_keywords;
        // echo '<pre>';print_r($data);die;
        return view('home.portfolio-details')->with($data);
    }

}