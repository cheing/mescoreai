<?php

namespace App\Http\Controllers;

use App\Http\Resources\V1\TournamentCollection;
use App\Models\TournamentMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MatchesController extends Controller
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
    public function index(Request $request)
    {
        $date = $request->input('date');

        if (!$date) {
            $today = Carbon::today();
            // 找到最近的未来赛事日期作为基准日期
            $match = TournamentMatch::where('start_time', '>=', $today->startOfDay())
                                     ->orderBy('start_time', 'asc')
                                     ->first();

            $date = optional($match)->start_time->format('Y-m-d') ?? $today->toDateString();
        }

        // 获取指定日期的所有赛事
        $matches = TournamentMatch::with('tournament')
        ->whereDate('start_time', $date)
        ->get();

        // 根据tournament表的sort值和比赛开始时间对赛事进行排序
        $matches = $matches->sortBy([
        ['tournament.sort', 'asc'],
        ['start_time', 'desc'],
        ]);

        // 根据tournament_id进行分组
        $tournaments = $matches->groupBy('tournament_id');

        // echo '<pre>';
        // print_r($tournaments);
        // echo '</pre>';
        $dates = $this->getMatchDates($date);

        return view('matches', ['dates' => $dates, 'tournaments' => new TournamentCollection($tournaments)]);
    }

    public function getMatchDates($date)
    {
        $today = Carbon::today();

        // 找到最近的未来赛事日期作为基准日期
        $nextAvailableMatch = TournamentMatch::where('start_time', '>=', $today->startOfDay())
                                   ->orderBy('start_time', 'asc')
                                   ->first();

        $baseDate = optional($nextAvailableMatch)->start_time->startOfDay() ?? $today;
        // 获取基准日期之前的三个有赛事的日期
        $datesBefore = TournamentMatch::selectRaw('DATE(start_time) as date')
                            ->where('start_time', '<', $baseDate)
                            ->groupBy('date')
                            ->orderBy('date', 'desc')
                            ->limit(2)
                            ->get()
                            ->reverse()
                            ->pluck('date')
                            ->toArray();

        // 获取基准日期之后的三个有赛事的日期
        $datesAfter = TournamentMatch::selectRaw('DATE(start_time) as date')
        ->where('start_time', '>', $baseDate->endOfDay()) // 从基准日期结束之后开始搜索
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->limit(2)
        ->get()
        ->pluck('date')
        ->toArray();

        // 合并所有日期，并包括基准日期
        // $allDates = collect($datesBefore)->concat([$baseDate->toDateString()])->concat($datesAfter)->sort();

        // 如果基准日期是今天，并且今天有赛事，确保基准日期包含在结果中
        $allDates = array_merge($datesBefore, [$baseDate->toDateString()]);
        $allDates = array_unique(array_merge($allDates, $datesAfter));
        sort($allDates); // 确保所有日期都是按顺序排序的

        // 格式化日期和标签
        $formattedDates = array_map(function ($currentDate) use ($today, $date) { // use $currentDate instead of $date
            // $formattedDates = array_map(function ($currentDate) use ($today) {
            $dateCarbon = Carbon::parse($currentDate);
            $format = __('messages.date_format');
            $label = $dateCarbon->format($format); // Use the localized format string

            // $label = $dateCarbon->format('d M');
            if ($dateCarbon->isSameDay($today->copy()->subDay())) {
                $label = __('messages.yesterday');
            } elseif ($dateCarbon->isSameDay($today)) {
                $label = __('messages.today');
            } elseif ($dateCarbon->isSameDay($today->copy()->addDay())) {
                $label = __('messages.tomorrow');
            }

            $isActive = $date === $dateCarbon->format('Y-m-d'); // Correct comparison with the input $date

            return [
                'date' => $dateCarbon->format('Y-m-d'),
                'label' => $label,
                'active' => $isActive,
            ];
        }, $allDates);

        return $formattedDates;
    }
}
