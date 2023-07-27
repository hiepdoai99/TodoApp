<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\MailNotify;

class MailController extends Controller
{
    public function index(){
        $data = [
            'subject' =>'hi hiep',
            'body'=>'hello'
        ];
        try {
            Mail::to('nguyenxuanhiepk49@gmail.com')->send(new MailNotify($data));
            return response()->json(['great']);
        }catch (\Exception $th){
            return response()->json(['error']);
        }
    }
}
