<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        Mail::raw(
            "New contact message\n\n".
            "Name: {$data['name']}\n".
            "Email: {$data['email']}\n\n".
            "Message:\n{$data['message']}",
            function ($mail) use ($data) {
                $mail->to('pshamugia@gmail.com')
                     ->replyTo($data['email'], $data['name'])
                     ->subject('Contact Form Message');
            }
        );

        return back()->with('success', 'თქვენი წერილი გაიგზავნა ✔');
    }
}
