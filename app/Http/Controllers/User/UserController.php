<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\User\SettingsRequest;
use App\Repository\User\UserRepo;
class UserController extends Controller
{

    protected $userRepo;

    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * Show Settings page
     *
     * @return view
     */
    public function settings()
    {
        $result = $this->userRepo->userInfo();
        if($result['success']){
            $user = json_decode(json_encode($result['object']['user']));
            $lang_changed = $this->langChanged();
            return view('User.settings',compact('user','lang_changed'));
        }
        elseif ($result['errors'])
            return redirect()->back()->with('error',$result['errors']);
        elseif ($result['validator'])
            return redirect()->back()->with('error',$result['validator']);
        else
            abort(500);
     }
    /**
     * Save user info in DB
     *
     * @param SettingsRequest $request , $id
     *
     * @return RedirectToBack
     */
     public function saveSettings(SettingsRequest $request,$id){
        $this->userRepo->setReq($request);
        $result = $this->userRepo->updateUserInfo($id);
        if ($result['success'])
            return redirect()->back()->with('success',$result['success']);
        elseif ($result['errors'])
            return redirect()->back()->with('error',$result['errors']);
        elseif ($result['validator'])
            return redirect()->back()->with('error',$result['validator']);
        else
            abort(500);
     }
    /**
     * This is a helper function used to get previous language locale
     *
     * @return $lang_changed 0?1
     */
     private function langChanged(){
        $lang_changed = 0;
        if(session()->has('current_lang') && session()->get('current_lang') !=app()->getLocale())
            $lang_changed = 1;
        session()->put('current_lang',app()->getLocale());

        return $lang_changed;
    }
}
