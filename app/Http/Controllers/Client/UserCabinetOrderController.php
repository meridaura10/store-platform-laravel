<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserCabinetOrderController extends Controller
{
    public function index()
    {
        
        return view('client.pages.order.index');
    }
}
