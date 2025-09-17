<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class googleRecaptcha {
    
    public function handle($request, Closure $next) {
        if(request()->ip() != '127.0.0.1' && request()->ip() != '::1') {
            if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
                $secret = '6LfLiwkdAAAAAFi4RiEFHwiqwkev4AlB-PNEVn5u';
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
                $responseData = json_decode($verifyResponse);
                if($responseData->success) {
                    return $next($request);
                } else {
                    session()->flash('error', 'Invalid Recaptcha');
                    return redirect('admin/login');
                }
            } else {
                session()->flash('error', 'Verify Recaptcha');
                return redirect('admin/login');
            }
        }

        return $next($request);
    }
}
