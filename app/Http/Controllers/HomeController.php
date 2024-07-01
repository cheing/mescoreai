<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreMemberRequest;
use App\Models\FAQ;
use App\Models\Information;
use App\Models\Package;
use App\Models\TournamentMatch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // 获取当前日期
        $today = Carbon::now();

        $packages = Package::where('status', 1)->orderby('sort', 'asc')->get();
        $text_welcome = Information::where('key', 'text_welcome')->first();

        return view('home', ['packages' => $packages, 'text_welcome' => $text_welcome]);
    }

    public function index2()
    {
        // 获取当前日期
        $today = Carbon::now();

        return view('home2');
    }

    public function matches(Request $request)
    {
        if (null !== $request->input('date')) {
            $date = $request->input('date');
        } else {
            $date = Carbon::now();
        }

        $matches = TournamentMatch::where('start_time', $date)->get();

        $dates = $this->getMatchDates();

        return view('matches', ['dates ' => $dates, 'matches' => $matches]);
    }

    public function getMatchDates()
    {
        $today = Carbon::today();
        $from = $today->copy()->subDays(3);
        $to = $today->copy()->addDays(3);

        $matches = TournamentMatch::select('start_time')
                        ->whereBetween('start_time', [$from->startOfDay(), $to->endOfDay()])
                        ->get()
                        ->groupBy(function ($date) {
                            return Carbon::parse($date->start_time)->format('Y-m-d'); // grouping by date
                        });

        $dates = $matches->keys();
        $formattedDates = [];

        foreach ($dates as $date) {
            $dateCarbon = Carbon::parse($date);
            $label = $dateCarbon->format('d M');
            if ($dateCarbon->isSameDay($today->copy()->subDay())) {
                $label = 'Yesterday';
            } elseif ($dateCarbon->isSameDay($today)) {
                $label = 'Today';
            } elseif ($dateCarbon->isSameDay($today->copy()->addDay())) {
                $label = 'Tomorrow';
            }
            $formattedDates[] = ['date' => $date, 'label' => $label];
        }

        return $formattedDates;
    }

    private function ValidateUsername($id, $username)
    {
        $result = \App\Lib\Queries\Home\GetPrediction::ValidateUsername($id, $username);

        return $result;
    }

    public function Register(StoreMemberRequest $request)
    {
        $data = $request->validated();
        $data['role'] = 'member';
        $data['password'] = Hash::make($data['password']);
        $data['status'] = 1;

        User::create($data);

        if (Auth::attempt(['username' => $request->input('username'), 'password' => $request->input('password'), 'status' => 1, 'role' => 'member'])) {
            return $this->JsonOk();
        } else {
            return $this->JsonError('Wrong Password');
        }
    }

    public function Login(LoginRequest $request)
    {
        if (Auth::attempt(['username' => $request->input('username'), 'password' => $request->input('password'), 'status' => 1, 'role' => 'member'])) {
            return $this->JsonOk();
        } else {
            return $this->JsonError('Wrong Password');
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        // return response()->json($user->password);

        // Check if the provided current password matches the one in the database
        if (!Hash::check($request->current_password, $user->password)) {
            return $this->JsonError('Invalid current password');
        }

        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Return a response, such as redirecting with a success message
        return response()->json(['message' => 'Password changed successfully.']);
    }

    public function FAQ()
    {
        $faqs = FAQ::orderBy('sort')->get();

        return view('faq', ['faqs' => $faqs]);
    }

    public function Subscription()
    {
        $data = Information::where('key', 'page_subscription')->first();

        return view('subscription', ['data' => $data]);
    }

    public function test()
    {
        return view('test');
    }
}
