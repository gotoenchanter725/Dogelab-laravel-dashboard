<?php

namespace App\Http\Middleware;

use App\Models\Account;
use Closure;
use Illuminate\Http\Request;

class CheckAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $account = session('ACCOUNT');
        $account = Account::where('wallet', $account)->first();
        if($account){
            return $next($request);
        }else{
            return redirect()->route('home');
        }
    }
}
