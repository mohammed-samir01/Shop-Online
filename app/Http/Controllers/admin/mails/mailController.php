<?php

namespace App\Http\Controllers\admin\mails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\mail\contact;

class mailController extends Controller
{
    public function index()
    {
        return view('admin.en.mails.mailForm');
    }
    public function send(Request $request)
    {
        $sendData = $request->only('email','message');
        // return $request->all();
        if(!Mail::to($request->email)->send(new contact($sendData))){
            return redirect()->back()->with('Success','The Mail has successfuly sent');
        }else{
            return redirect()->back()->with('Error','SomeThins Went Wrong');
        }
    }
}
