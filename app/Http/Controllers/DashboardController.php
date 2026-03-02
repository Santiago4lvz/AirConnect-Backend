<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Aquí puedes pasar datos a la vista si los necesitas
        return view('dashboard');
    }
}