<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Main extends Controller
{
    
    public function principal(Request $request){
		return redirect('/svte');
    }
}
