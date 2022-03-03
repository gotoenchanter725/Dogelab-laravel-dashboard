<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Deposit;
use App\Models\ReferralLog;
use App\Models\Track;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function dashboard()
    {
        $page_title         = 'Dashboard';

        $account['total']   = Account::count();
        $account['active']  = Account::where('status', 1)->count();
        $account['banned']  = Account::where('status', 0)->count();
        $account['referred']= Account::where('ref_by', '!=', null)->count();

        $account['track_balance'] = Track::where('status', 1)->sum('balance');
        $account['referral_bonus']= ReferralLog::sum('bonus_value');;

        // Monthly Deposit & Withdraw Report Graph
        $report['months'] = collect([]);
        $report['deposit_month_amount'] = collect([]);
        $report['withdraw_month_amount'] = collect([]);

        $depositsMonth = Deposit::whereYear('created_at', '>=', Carbon::now()->subYear())
            ->selectRaw("SUM( CASE WHEN status = 1 THEN amount END) as depositAmount")
            ->selectRaw("DATE_FORMAT(created_at,'%M-%Y') as months")
            ->orderBy('created_at')
            ->groupBy('months')->get();

        $depositsMonth->map(function ($depositData) use ($report) {
            $report['months']->push($depositData->months);
            $report['deposit_month_amount']->push(getAmount($depositData->depositAmount));
        });

        $withdrawalMonth = Withdrawal::whereYear('created_at', '>=', Carbon::now()->subYear())
            ->selectRaw("SUM(amount) as withdrawAmount")
            ->selectRaw("DATE_FORMAT(created_at,'%M-%Y') as months")
            ->orderBy('created_at')
            ->groupBy('months')->get();

        $withdrawalMonth->map(function ($withdrawData) use ($report){
            if (!in_array($withdrawData->months,$report['months']->toArray())) {
                $report['months']->push($withdrawData->months);
            }
            $report['withdraw_month_amount']->push(getAmount($withdrawData->withdrawAmount));
        });

        $months = $report['months'];

        for($i = 0; $i < $months->count(); ++$i) {
            $d_val      = Carbon::parse($months[$i]);
            if(isset($months[$i+1])){
                $d_val_next = Carbon::parse($months[$i+1]);
                if($d_val_next < $d_val){
                    $temp = $months[$i];
                    $months[$i]   = Carbon::parse($months[$i+1])->format('F-Y');
                    $months[$i+1] = Carbon::parse($temp)->format('F-Y');
                }else{
                    $months[$i]   = Carbon::parse($months[$i])->format('F-Y');
                }
            }
        }

        // Withdraw Graph
        $withdrawal = Withdrawal::where('created_at', '>=', \Carbon\Carbon::now()->subDays(30))
            ->select(array(DB::Raw('sum(amount)   as totalAmount'), DB::Raw('DATE(created_at) day')))
            ->groupBy('day')->get();

        $withdrawals['per_day'] = collect([]);
        $withdrawals['per_day_amount'] = collect([]);

        $withdrawal->map(function ($a) use ($withdrawals) {
            $withdrawals['per_day']->push(date('d M', strtotime($a->day)));
            $withdrawals['per_day_amount']->push($a->totalAmount + 0);
        });


        $payment['total_deposit_amount']            = Deposit::where('status',1)->sum('amount');

        $paymentWithdraw['total_withdraw_amount']   = Withdrawal::sum('amount');

        $latest_accounts                            = Account::where('status', 1)->latest()->limit(10)->get();
        $latest_deposits                            = Deposit::where('status', 1)->latest()->limit(10)->get();


        return view('admin.dashboard', compact('page_title', 'report', 'withdrawals','payment','paymentWithdraw','depositsMonth','withdrawalMonth','account', 'latest_accounts', 'latest_deposits', 'months'));
    }


    public function profile()
    {
        $page_title = 'Profile';
        $admin = Auth::guard('admin')->user();
        return view('admin.profile', compact('page_title', 'admin'));
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        $user = Auth::guard('admin')->user();

        if ($request->hasFile('image')) {
            try {
                $old = $user->image ?: null;
                $user->image = uploadImage($request->image, imagePath()['profile']['admin']['path'], imagePath()['profile']['admin']['size'], $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $notify[] = ['success', 'Your profile has been updated.'];
        return redirect()->route('admin.profile')->withNotify($notify);
    }


    public function password()
    {
        $page_title = 'Password Setting';
        $admin = Auth::guard('admin')->user();
        return view('admin.password', compact('page_title', 'admin'));
    }

    public function passwordUpdate(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);

        $user = Auth::guard('admin')->user();
        if (!Hash::check($request->old_password, $user->password)) {
            $notify[] = ['error', 'Password Do not match !!'];
            return back()->withErrors(['Invalid old password.']);
        }
        $user->password = bcrypt($request->password);
        $user->save();
        $notify[] = ['success', 'Password Changed Successfully.'];
        return redirect()->route('admin.password')->withNotify($notify);
    }


    public function requestReport()
    {
        $page_title = 'Your Listed Report & Request';
        $arr['app_name'] = systemDetails()['name'];
        $arr['app_url'] = env('APP_URL');
        $arr['purchase_code'] = env('PURCHASE_CODE');
        $url = "https://license.viserlab.com/issue/get?".http_build_query($arr);
        $response = json_decode(curlContent($url));
        if ($response->status == 'error') {
            return redirect()->route('admin.dashboard')->withErrors($response->message);
        }
        $reports = $response->message[0];
        return view('admin.reports',compact('reports','page_title'));
    }

    public function reportSubmit(Request $request)
    {
        $request->validate([
            'type'=>'required|in:bug,feature',
            'message'=>'required',
        ]);
        $url = 'https://license.viserlab.com/issue/add';

        $arr['app_name'] = systemDetails()['name'];
        $arr['app_url'] = env('APP_URL');
        $arr['purchase_code'] = env('PURCHASE_CODE');
        $arr['req_type'] = $request->type;
        $arr['message'] = $request->message;
        $response = json_decode(curlPostContent($url,$arr));
        if ($response->status == 'error') {
            return back()->withErrors($response->message);
        }
        $notify[] = ['success',$response->message];
        return back()->withNotify($notify);
    }

    public function systemInfo(){
        $laravelVersion = app()->version();
        $serverDetails = $_SERVER;
        $currentPHP = phpversion();
        $timeZone = config('app.timezone');
        $page_title = 'System Information';
        return view('admin.info',compact('page_title', 'currentPHP', 'laravelVersion', 'serverDetails','timeZone'));
    }

}
