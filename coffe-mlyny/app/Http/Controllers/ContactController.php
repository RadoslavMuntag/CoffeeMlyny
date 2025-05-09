<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function send(){
        return back()->with("success","Message sent successfuly");
    }
}
