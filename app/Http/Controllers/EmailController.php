<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendUserCredentials;

class EmailController extends Controller
{
    public function sendCredentials(Request $request)
    {
        $name = $request->input('name');
        $password = $request->input('password');
        $email = $request->input('email');

        Mail::to($email)->send(new SendUserCredentials($name, $password));

        return response()->json(['message' => '¡Email enviado!']);
    }
}
