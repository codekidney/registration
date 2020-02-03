<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\ProgrammingLanguages;
use Carbon\Carbon;

class UserController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the profile dashboard.
     *
     * @return Renderable
     */
    public function show() {
        $user = Auth::user();
        return view('user/show', compact('user'));
    }

    /**
     * Show the list dashboard.
     *
     * @return Renderable
     */
    public function index(Request $request){
        $daysFilter = (int) $request->route('days');
        if(isset($daysFilter) && in_array($daysFilter, [3, 7, 30])){
            $users = User::where('is_admin',0)
                    ->whereDate('created_at', '>', Carbon::now()->subDays($daysFilter))
                    ->orderBy('created_at', 'DESC')
                    ->simplePaginate(10);
        } else {
            $users = User::where('is_admin',0)->simplePaginate(10);
        }
        return view('users/index', compact('users','daysFilter'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit() {
        $user = Auth::user();
        $languages = implode(', ', array_map(function($lang) {
                    return $lang['name'];
                }, $user->languages->toArray()));
        return view('auth/register', compact('user', 'languages'));
    }

    public function update(Request $request){
        
        $userId = Auth::id();
        $user = User::findOrFail($userId);
        
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'first_name' => ['required', 'string', 'min:3', 'max:50'],
            'last_name' => ['required', 'string', 'min:3', 'max:50'],
            'languages' => ['required', 'string', 'min:2', 'languages']
        ]);        
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $user->fill([
            'name' => $request->name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);
        $user->save();
        
        $langNames = array_map('trim', explode(',', $request->languages));
        $langIds = [];
        foreach ($langNames as $langName) {
            $lang = ProgrammingLanguages::firstOrCreate(['name' => $langName]);
            if ($lang) {
                $langIds[] = $lang->id;
            }
        }
        $user->languages()->sync($langIds);
        
        return redirect()->back();
    }
    
}
