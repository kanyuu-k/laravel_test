<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\ContactForm;
use Illuminate\Http\Request;
use App\Models\Contact;


class ContactController extends Controller
{
    public function create()
    {
        return view('contact.create');
    }

    public function store(Request $request)
    {
        $inputs = request()->validate([
            'title' => 'required|max:255',
            'email' => 'required|max:255',
            'body' => 'required',
        ]);

        Contact::create($inputs);

        Mail::to(config('mail.admin'))->send(new ContactForm($inputs));
        Mail::to($inputs['email'])->send(new ContactForm($inputs));

        return back()->with('message', 'メールを送信しました。');
    }
}
