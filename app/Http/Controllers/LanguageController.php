<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    // change language
    public function changeLanguage() {

        $locale = Session::get('locale');

        if($locale == 'en') {
            Session::put('locale', 'lt');
        } else {
            Session::put('locale', 'en');
        }

        return redirect()->back();

    }
    
}
