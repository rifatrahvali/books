<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    // 6 - kayıt sayfasını görüntüleyecek fonksiyon GET
    public function register(){
        return view("account.register");
    }
    // 8 - bu fonksiyon kullanıcıyı kayıt edecektir. POST
    public function processRegister(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required|min:3',
            'email'=>'required|email',
            'password'=>'required|confirmed|min:5',
            'password_confirmation'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.register')->withInput()->withErrors($validator);
        }

        // Kullanıcı kayıt
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('account.login')->with('success','Kayıt başarılı.');
    }

    public function login(){
        return view("account.login");
    }

    public function authenticate(Request $request){
        $validator = Validator::make($request->all(), [
            "email"=> "required|email",
            "password"=> "required",
        ]);

        if ($validator->fails()) {
            return redirect()->route("account.login")->withInput()->withErrors($validator);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // VT ile eşleşiyo mu
            return redirect()->route('account.profile');
        }else{
            return redirect()->route("account.login")->with("error","Kullanıcı veya parola hatalı.");
        }
    }

    public function profile(){
        return view("account.profile");
    }

    //  14  -   logout
    public function logout(){
        Auth::logout();
        return redirect()->route("account.login");
    }

}

