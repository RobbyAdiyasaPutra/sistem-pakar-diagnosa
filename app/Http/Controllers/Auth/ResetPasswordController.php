<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller; // Make sure this is present
use Illuminate\Foundation\Auth\ResetsPasswords; // <-- ADD THIS LINE

class ResetPasswordController extends Controller
{
    use ResetsPasswords; // <-- ADD THIS LINE to use the trait

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home'; // Or whatever your home route is

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // The middleware method should be called on $this, as it's provided by the base Controller class.
        // This targets only 'guest' users, so they can access the reset form.
        $this->middleware('guest');
    }
}