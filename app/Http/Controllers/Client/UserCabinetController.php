<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserCabinetController extends Controller
{
    public function index()
    {
        return view('client.pages.user.cabinet.index');
    }
}
