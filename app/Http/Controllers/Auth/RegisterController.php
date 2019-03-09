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
            'name.required' => 'ユーザー名は必須です',
            'name.string' => 'ユーザー名は文字入力です',
            'name.max' => 'ユーザー名は20文字以内です',
            'nickname.required' => 'ユーザーIDは必須です',
            'nickname.string' => 'ユーザーIDは文字入力です',
            'nickname.regex' => 'ユーザーIDは半角英数字です',
            'nickname.max' => 'ユーザーIDは20文字以内です',
            'nickname.unique' => 'ユーザーIDは既に登録されています',
            'image.image' => '画像(jpg、png、bmp、gif、svg)であることを確認してください',
            'content.string' => '自己紹介文は文字入力です',
            'content.max' => 'コメントは300文字以内です',
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
        if($upload_file == null){
            if(strpos($user->avatar,'picture?type=normal') !== false || strpos($user->avatar,'default_profile_normal') !== false){
                $image = null;
            }else {
                $image_contents = file_get_contents($user->avatar);
                $image_encode = base64_encode($nickname);
                $image_name = str_replace(array('+','=','/'),array('_','-','.'),$image_encode);
                $image = $image_name.'.jpg';
                //アバター画像を保存
                \Storage::put('public/images/users/'.$image, $image_contents);
            }
        }else{
            // アバター画像を保存
            $image_encode = base64_encode($nickname);
            $image_name = str_replace(array('+','=','/'),array('_','-','.'),$image_encode);
            $image = $image_name.'.jpg';
            $upload_file->storeAs('/public/images/users', $image);
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
