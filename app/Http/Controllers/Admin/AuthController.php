<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    // Hiển thị trang login
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }


    // Xử lý đăng nhập
    public function postLogin(Request $request)
    {
        // validate dữ liệu
        $request->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'username' => 'Tên đăng nhập',
                'password' => 'Mật khẩu',
            ]
        );


        // first(): lấy ra record đầu tiên khi truy vấn dữ liệu
        $user = User::where('username', $request->username)->first();
        // Nếu không tìm thấy người dùng trong bảng users
        if (!$user) {
            return back()
                ->with('message', 'Username không tồn tại')
                ->withInput();
        }
        // Nếu tìm thấy người dùng thì kiểm tra mật khẩu
        // do mật khẩu dùng Hash::make() để mã hóa, nên cần so sánh phải dùng với hàmHash::check()
        $check = Hash::check($request->password, $user->password); // true hoặc false
        // trường hợp mật khẩu không khớp
        if (!$check) {
            // điều hướng về trước (login) với session flash 'message'
            return back()->with('message', 'Mật khẩu không đúng')->withInput();
        }
        // Nếu biến $remember có giá trị true (nếu người dùng chọn nhớ tài khoản)
        $remember = $request->has('remember') ? true : false;
        Auth::login($user, $remember);
        // sử dụng intended để điều hướng về URL mà người dùng muốn truy cập
        // nếu không có thì điều hướng về dasboard (route name dashboard được khai báo trongweb.php)
        return redirect()->intended(route('admin.dashboard'));
    }



    // Logout
    public function logout(Request $request)
    {

        Auth::logout();


        $request->session()->invalidate();

        $request->session()->regenerateToken();


        return redirect()
            ->route('admin.login')
            ->with('success', 'Đăng xuất thành công.');
    }

    // Hiển thị trang đổi mật khẩu
    public function changePassword()
    {
        return view('admin.auth.change-password');
    }



    // Xử lý đổi mật khẩu
    public function postChangePassword(Request $request)
    {

        $request->validate(
            [
                'old_password' => 'required',
                'password' => 'required|min:6',
                'password_confirmation' => 'required|same:password',
            ],
            [
                'required' => ':attribute không được để trống',
                'same' => 'Mật khẩu xác nhận không trùng khớp',
                'min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            ],
            [
                'old_password' => 'Mật khẩu cũ',
                'password' => 'Mật khẩu mới',
                'password_confirmation' => 'Xác nhận mật khẩu',
            ]
        );



        $user = User::find(Auth::id());


        // kiểm tra mật khẩu cũ
        if (!Hash::check($request->old_password, $user->password)) {

            return back()
                ->with('error', 'Mật khẩu cũ không đúng');
        }


        // cập nhật mật khẩu mới
        $user->password = Hash::make($request->password);
        $user->save();



        return back()
            ->with('success', 'Đổi mật khẩu thành công');
    }

    // Quên mật khẩu
    public function forgotPassword()
    {
        return view('admin.auth.forgotpass');
    }


    // Xử lý quên mật khẩu
    public function postForgotpassword(Request $request)
    {
        $request->validate(
            ['email' => 'required|email'],
            [
                'email.required' => 'Email không được để trống',
                'email.email' => 'Email không đúng định dạng',
            ]
        );

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'Email không tồn tại')
                ->withInput();
        }

        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        $link = route('reset-password', ['token' => $token]);

        Mail::html(
            "<h2>Reset mật khẩu</h2><p>Vui lòng click vào link dưới đây để đổi mật khẩu.</p><a href='{$link}'>Đổi mật khẩu</a>",
            function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Reset Password');
            }
        );

        return back()
            ->with('message', 'Đã gửi link đặt lại mật khẩu. Vui lòng kiểm tra email của bạn');
    }

    public function resetForm(string $token)
    {
        $record = DB::table('password_reset_tokens')->where('token', $token)->first();

        if (!$record) {
            abort(404, 'Token không hợp lệ');
        }

        return view('admin.auth.reset-password', compact('token'));
    }

    public function postResetPassword(Request $request, string $token)
    {
        $request->validate(
            [
                'password' => 'required|min:6|confirmed',
            ],
            [
                'password.required' => 'Mật khẩu không được để trống',
                'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
                'password.confirmed' => 'Mật khẩu xác nhận không trùng khớp',
            ]
        );

        $record = DB::table('password_reset_tokens')->where('token', $token)->first();

        if (!$record) {
            return redirect()->route('admin.login')->with('error', 'Token không hợp lệ hoặc đã hết hạn');
        }

        $user = User::where('email', $record->email)->first();
        if (!$user) {
            return redirect()->route('admin.login')->with('error', 'Tài khoản không tồn tại');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_reset_tokens')->where('token', $token)->delete();

        return redirect()->route('admin.login')->with('success', 'Đặt lại mật khẩu thành công');
    }
}
