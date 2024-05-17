<?php

namespace App\Http\Controllers\Auth;

use App\Enum\Users\UserType;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'referral_code' => ['required',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $referrer = User::where('referral_code', $value)->first();

                        if (!$referrer || $referrer->user_type !== 'agent') {
                            $fail('The referral code is invalid or does not belong to an agent.');
                        }
                    }
                },
            ],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_by' => $request->referral_code ? User::where('referral_code', $request->referral_code)->first()->id : null,
        ]);
               
        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
    private function generateUniqueReferralCode() {
        do {
            // Generate a random 8-character alphanumeric string
            $referralCode = Str::random(8);
        } while (User::where('referral_code', $referralCode)->exists());
    
        return $referralCode;
    }
    public function registerUser(Request $request): RedirectResponse
    {
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required']]);
        // dd($request->all());
        $referralCode = $this->generateUniqueReferralCode();
        // dd($referralCode);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
            'created_by' => $request->user_id,
            'referral_code' => $referralCode,
        ]);
        // dd($user);
        event(new Registered($user));
        return redirect()->back();
        // return redirect()->route('admin.users.index')->with('success', 'User registered successfully');            
    }
}
