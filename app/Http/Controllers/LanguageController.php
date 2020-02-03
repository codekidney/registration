<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProgrammingLanguages;

class LanguageController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }
    
    /**
     * Show the list dashboard.
     *
     * @return Renderable
     */
    public function index() {
//        $languages = ProgrammingLanguages::paginate(10);
        $languages = ProgrammingLanguages::withCount('users')->orderBy('users_count', 'desc')->paginate(10);
        return view('languages/index', compact('languages'));
    }
}
