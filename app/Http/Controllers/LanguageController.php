<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    //
    public function swap($locale){
        // available language in template array
        $availLocale=['en'=>'en', 'fr'=>'fr','de'=>'de','pt'=>'pt'];
        // check for existing language
        if(array_key_exists($locale,$availLocale)){
            session()->put('locale',$locale);
        }
        return redirect()->back();
    }

    public function index()
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['name' => "Language"]
        ];
        return view('content.language', ['breadcrumbs' => $breadcrumbs]);
    }

    public function addLanguage()
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['link' => "admin/languages", 'name' => "Language"], ['name' => "Add Language"]
        ];
        $language = [];
        return view('content.add-language', ['language' => $language, 'breadcrumbs' => $breadcrumbs]);
    }

    public function editLanguage($id)
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['link' => "admin/languages", 'name' => "Language"], ['name' => "Edit Language"]
        ];
        $language = Language::where('id', $id)->select('id',
            'name')->first();

        return view('content.add-language', ['language' => $language, 'breadcrumbs' => $breadcrumbs]);
    }

}
