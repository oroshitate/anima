<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // ルールを設定
        $rules = [
            'name' => 'required|string|max:20',
            'nickname' => 'required|string|regex:/^[a-zA-Z0-9]+$/|max:20|unique:users',
            'image' => 'nullable|image',
            'content' => 'nullable|string|max:300',
        ];

        // エラーメッセージを設定
        $messages = [
            'name.required' => \Lang::get('validation.required', ["attribute" => \Lang::get('app.label.auth_user.user_name')]),
            'name.string' => \Lang::get('validation.string', ["attribute" => \Lang::get('app.label.auth_user.user_name')]),
            'name.max' => \Lang::get('validation.max.string', ["attribute" => \Lang::get('app.label.auth_user.user_name')]),
            'nickname.required' => \Lang::get('validation.required', ["attribute" => \Lang::get('app.label.auth_user.nickname')]),
            'nickname.string' => \Lang::get('validation.string', ["attribute" => \Lang::get('app.label.auth_user.nickname')]),
            'nickname.regex' => \Lang::get('validation.regex', ["attribute" => \Lang::get('app.label.auth_user.nickname')]),
            'nickname.max' => \Lang::get('validation.max.string', ["attribute" => \Lang::get('app.label.auth_user.nickname')]),
            'nickname.unique' => \Lang::get('validation.unique', ["attribute" => \Lang::get('app.label.auth_user.nickname')]),
            'image.image' => \Lang::get('validation.image', ["attribute" => \Lang::get('app.label.auth_user.profile')]),
            'content.string' => \Lang::get('validation.content', ["attribute" => \Lang::get('app.label.auth_user.content')]),
            'content.max' => \Lang::get('validation.max.string', ["attribute" => \Lang::get('app.label.auth_user.content')]),
        ];

        $validation = Validator::make($data, $rules, $messages);

        return $validation;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(Request $request)
    {
        \Log::info("Auth/RegisterController : create() : Start");
        $name = $request->input('name');
        $nickname = $request->input('nickname');
        $upload_file = $request->image;
        $content = $request->input('content');

        $user = $request->session()->get('user');
        $email = $user->email;
        $provider_id = $user->id;
        $provider = $request->session()->get('provider');
        $token = null;
        $token_secret = null;
        if($provider == 'twitter'){
            $token = encrypt($user->token);
            $token_secret = encrypt($user->tokenSecret);
        }

        $image = null;
        $image_contents = file_get_contents($user->avatar);
        $image_encode = base64_encode($nickname);
        $image_name = str_replace(array('+','=','/'),array('_','-','.'),$image_encode);
        if($upload_file == null){
            if(strpos($user->avatar,'picture?type=normal') !== false || strpos($user->avatar,'default_profile_normal') !== false){
                $image = null;
            }else {
                $image = $image_name.'.jpg';
                if(\App::environment('production')){
                    $disk = \Storage::disk('s3');
                    $disk->put('images/users/'.$image, $image_contents, 'public');
                }else {
                    \Storage::put('public/images/users/'.$image, $image_contents);
                }

            }
        }else{
            $image = $image_name.'.jpg';
            if(\App::environment('production')){
                $disk = \Storage::disk('s3');
                $disk->put('images/users/'.$image, $image_contents, 'public');
            }else {
                $upload_file->storeAs('/public/images/users', $image);
            }
        }

        DB::beginTransaction();
        try {
            if ($email) {
                $user = User::whereEmail($email)->first();
                if (! $user) {
                    $user = User::create([
                        'email' => $email,
                        'name'  => $name,
                        'nickname' => $nickname,
                        'image' => $image,
                        'content' => $content,
                    ]);
                }
                $user->accounts()->create([
                    'provider_id'   => $provider_id,
                    'provider_name' => $provider,
                    'token' => $token,
                    'token_secret' => $token_secret,
                ]);
            } else {
                $user = User::create([
                    'email' => $email,
                    'name'  => $name,
                    'nickname' => $nickname,
                    'image' => $image,
                    'content' => $content,
                ]);
                $user->accounts()->create([
                    'provider_id'   => $provider_id,
                    'provider_name' => $provider,
                    'token' => $token,
                    'token_secret' => $token_secret,
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->forget('user');
            \Log::emergency("Auth/RegisterController : create() : Failed Create Account!");
            \Log::emergency("Message : ".$e->getMessage());
            \Log::emergency("Code : ".$e->getCode());
            return redirect('/login');
        }

        $request->session()->forget('user');

        return $user;
    }
}
