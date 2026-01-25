<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
     public function send(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required',
            'phone'   => 'required',
            'address' => 'required',
            'email'   => 'nullable|email',
            'product_url' => 'required',
            'color_name'  => 'nullable',
            'color_hex'   => 'nullable',
        ]);

        Mail::raw(
            "New Order\n\n".
            "Name: {$data['name']}\n".
            "Phone: {$data['phone']}\n".
            "Email: ".($data['email'] ?? '-')."\n".
            "Address: {$data['address']}\n".
            "Product: {$data['product_url']}\n".
            "Color: ".($data['color_name'] ?? '-')." {$data['color_hex']}",
            fn ($m) => $m->to('pshamugia@gmail.com')->subject('New Order')
        );

        return response()->json(['ok' => true]);
    }
}
