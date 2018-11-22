<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Mail;
use Session;
use Redirect;
use App\Http\Requests;
use Log;
use App\Http\Controllers\Controller;

class MailController extends Controller
{
    public function send_email(Request $request){
        Mail::send('emails.contact', $request->all(), function($msj){
            Log::debug($request);
            $msj->subject('Correo Importante: USB Media lab');
            $msj->to('sebas.villanueva.98@gmail.com');
        });
        Session::flash('message','Mensaje enviado');
        return Redirect::to('miembros');
    }
}
