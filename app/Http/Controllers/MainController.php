<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt; 
class MainController extends Controller
{
    public function index()
    { 
        return view('welcome');
    }

    public function specific($id)
    {
        $id = Crypt::decrypt($id);
        return view('welcome',compact('id'));
    }
}
