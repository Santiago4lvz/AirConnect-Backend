<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch($language)
    {
        if (in_array($language, ['en', 'es'])) {
            Session::put('locale', $language);
            App::setLocale($language);
        }

        return redirect()->back();
    }
}
