<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserActivity;
use App\Models\UserDailyActivity;
use App\Models\UserWeeklyActivity;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use DateTime;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Get date from request
        $date = $request->date;
    
        // Get day of the week for given date
        $day = date('w', strtotime($date));
    
        // Get today's date
        $today = date('Y-m-d');
    
        // Get the authenticated user
        $user = auth()->user();
    
        // Get the daily score for the given date
        $today_score = $user->userdailyscore($date);
    
        // Get the total score possible for the given date
        $today_total_score = $user->userdailyactivitycount($date) * 10;
    
        // Get the weekly score for the given date
        $weekly_score = $user->userWeeklyScore($date);
        
        // Get the total weekly score possible
        $weekly_total_score = $user->getWeeklyCount($date) * 10;
        
        // Initialize empty activities array and separate mandatory and optional activities
        $activities = [];
        $activity_mandatory = [];
        $activity_optional = [];

        // If the given date is today or in the past, get daily activities
        if (strtotime($today) > strtotime($date)) {
            $dailyactivities = UserDailyActivity::where('user_id', $user->id)
                ->whereDate('created_at', $date)
                ->get();
            
            // Loop through daily activities and create an activity array for each
            foreach ($dailyactivities as $dailyactivity) {
                $userActivity = $dailyactivity->userWeeklyActivity->userActivity;
                $name = $userActivity->name ? $userActivity->name : $userActivity->adminactivities($userActivity->activity_id)['name'];
                $icon = $userActivity->icon_id ? $userActivity->icon_id : $userActivity->adminactivities($userActivity->activity_id)['icon_id'];
                
                $activity = [
                    'name' => $name,
                    'score' => $dailyactivity->score,
                    'hours_spent' => $dailyactivity->hours_spent,
                    'icon_id' => $icon,
                ];
                
                // Add the activity to the mandatory or optional array depending on category
                if ($userActivity->category_id == 1) {
                    $activity_mandatory[] = $activity;
                } else {
                    $activity_optional[] = $activity;
                }
            }
        } else { // If the given date is in the future, get weekly activities
            $weeklyactivities = UserWeeklyActivity::where('user_id', $user->id)
                ->where('day_id', $day)
                ->get();
            foreach ($weeklyactivities as $weeklyactivity) {
                $userActivity = $weeklyactivity->userActivity;
                $name = $userActivity->name ? $userActivity->name : $userActivity->adminactivities($userActivity->activity_id)['name'];
                $category = $userActivity->category_id ? $userActivity->category_id : $userActivity->adminactivities($userActivity->activity_id)['category_id'];
                $icon = $userActivity->icon_id ? $userActivity->icon_id : $userActivity->adminactivities($userActivity->activity_id)['icon_id'];
                $activity = [
                    'name' => $name,
                    'start_time' => $weeklyactivity->start_time,
                    'end_time' => $weeklyactivity->end_time,
                    'icon_id' => $icon,
                ];

                if ($category == 1) {
                    $activity_mandatory[] = $activity;
                } else {
                    $activity_optional[] = $activity;
                }
            }
        }

        $activities = [
            'mandatory' => $activity_mandatory,
            'discretionary' => $activity_optional,
        ];


        $data = [
            'today_score' => $today_score,
            'today_total_score' => $today_total_score,
            'weekly_score' => $weekly_score,
            'weekly_total_score' => $weekly_total_score,
            'day' => date('l', strtotime($date)),
            'activities' => $activities,
        ];
        
        return response()->json(
            [
                'status' => 'success',
                'data' => $data,
            ],
            200);
    }

    public function dateActivity(Request $request)
    {
        // Get date from request
        $date = $request->date;

        // Get day of the week for given date
        $day = date('w', strtotime($date));

        // Get today's date
        $today = date('Y-m-d');

        // Get the authenticated user
        $user = auth()->user();

        // Get the daily score for the given date
        $today_score = $user->userdailyscore($date);

        // Get the total score possible for the given date
        $today_total_score = $user->userdailyactivitycount($date) * 10;

        // Get the weekly score for the given date
        $weekly_score = $user->userWeeklyScore($date);

        // Get the total weekly score possible
        $weekly_total_score = $user->getWeeklyCount($date) * 10;

        // Initialize empty activities array and separate mandatory and optional activities
        $activities = [];
        $activity_mandatory = [];
        $activity_optional = [];

        // If the given date is today or in the past, get daily activities
        if (strtotime($today) > strtotime($date)) {
            $dailyactivities = UserDailyActivity::where('user_id', $user->id)
            ->whereDate('created_at', $date)
            ->get();

            // Loop through daily activities and create an activity array for each
            foreach ($dailyactivities as $dailyactivity) {
                $userActivity = $dailyactivity->userWeeklyActivity->userActivity;
                $name = $userActivity->name ? $userActivity->name : $userActivity->adminactivities($userActivity->activity_id)['name'];
                $category = $userActivity->category_id ? $userActivity->category_id : $userActivity->adminactivities($userActivity->activity_id)['category_id'];
                $icon = $userActivity->icon_id ? $userActivity->icon_id : $userActivity->adminactivities($userActivity->activity_id)['icon_id'];
                
                
                $activity = [
                    'task_id' => $userActivity->id,
                    'name' => $name,
                    'score' => $dailyactivity->score,
                    'hours_spent' => $dailyactivity->hours_spent,
                    'icon_id' => $icon,
                ];

                // Add the activity to the mandatory or optional array depending on category
                if ($category == 1) {
                    $activity_mandatory[] = $activity;
                } else {
                    $activity_optional[] = $activity;
                }
            }
        } else { // If the given date is in the future, get weekly activities
            $weeklyactivities = UserWeeklyActivity::where('user_id', $user->id)
            ->where('day_id', $day)
            ->get();

            foreach ($weeklyactivities as $weeklyactivity) {
                $userActivity = $weeklyactivity->userActivity;
                $name = $userActivity->name ? $userActivity->name : $userActivity->adminactivities($userActivity->activity_id)['name'];
                
                $category = $userActivity->category_id ? $userActivity->category_id : $userActivity->adminactivities($userActivity->activity_id)['category_id'];
                $icon = $userActivity->icon_id ? $userActivity->icon_id : $userActivity->adminactivities($userActivity->activity_id)['icon_id'];
                
                $activity = [
                    'task_id' => $userActivity->id,
                    'name' => $name,
                    'start_time' => $weeklyactivity->start_time,
                    'end_time' => $weeklyactivity->end_time,
                    'icon_id' => $icon,
                ];

                if ($category == 1) {
                    $activity_mandatory[] = $activity;
                } else {
                    $activity_optional[] = $activity;
                }
            }
        }

        $activities = [
            'mandatory' => $activity_mandatory,
            'discretionary' => $activity_optional,
        ];


        $data = [
            'today_score' => $today_score,
            'today_total_score' => $today_total_score,
            'weekly_score' => $weekly_score,
            'weekly_total_score' => $weekly_total_score,
            'day' => date('l', strtotime($date)),
            'activities' => $activities,
        ];
        return response()->json(
            [
                'status' => 'success',
                'data' => $data,
            ],
            200
        );

        return response()->json(
            [
                'status' => 'success',
                'data' => $data,
            ],
            200
        );
    }

    public function calendar(Request $request)
    {
        $user = auth()->user();
        $date = $request->date;
        $data = $user->userMonthlyData($date);

        return response()->json(
            [
                'status' => 'success',
                'data' => $data,
            ],
            200,
        );
    }

    public function trackscore(Request $request){
        $date = $request->date;
        $type = $request->type;
        $day = date('w', strtotime($date));
        $today = date('Y-m-d'); //today
        $user = auth()->user();
        $data=[];
        $previous_weekly_score=[];
        $previous_monthly_score=[];
        if ($type == 'daily') {
            $data['happiness_score']=$user->userdailyscore($date);
            $data['total_happiness_score']=$user->userdailyactivitycount($date) * 10;
            if($user->userdailyactivitycount($date)!=0){
                $data['avg_score']=$user->userdailyscore($date)/$user->userdailyactivitycount($date);
            }
            else{
                $data['avg_score']=0;
            }
            for ($i = 1; $i < 4; $i++) {
                $currentDate = date('Y-m-d', strtotime($date . "-" . $i . " days"));
                if ($currentDate > date('Y-m-d')) {
                    break;
                }
                $data['previous_score'][]=[
                    'date' => $currentDate,
                    'score' => auth()->user()->userdailyscore($currentDate),
                    'total_score' => auth()->user()->userdailyactivitycount($currentDate) * 10,
                ];

            }
        }
        elseif($type == 'weekly'){
            for ($i = 0; $i < 3; $i++) {
                $start = new DateTime($date);
                $start->modify('-' . $i . ' week');
                $start->modify('Monday this week');
                $end = clone $start;
                $end->modify('Sunday this week');
                $week_start = $start->format('Y-m-d');
                $week_end = $end->format('Y-m-d');
                $week_number = date('W', strtotime($week_start));
                $previous_weekly_score[] = [
                    'week_number' => $week_number,
                    'score' => auth()->user()->userWeeklyScore($week_start),
                    'total_score' => auth()->user()->getWeeklyCount($week_start) * 10,
                    //'start_date' => $week_start,
                    //'end_date' => $week_end,
                ];
            }
            $avg_score=0;
            if ($user->getWeeklyCount($date) != 0) {
                $avg_score = $user->userWeeklyScore($date) / $user->getWeeklyCount($date);
            }
            $data=[
                'happiness_score' => $user->userWeeklyScore($date),
                'total_happiness_score' => $user->getWeeklyCount($date) * 10,
                'avg_score' => $avg_score,
                'previous_score' => $previous_weekly_score,
            ];
        }
        elseif($type == 'monthly'){
            for ($i = 0; $i < 3; $i++) {
                // Calculate the starting and ending dates of the month
                $start_date = date('Y-m-01', strtotime('-' . ($i + 1) . ' month', strtotime($date)));
                $end_date = date('Y-m-t', strtotime('-' . $i . ' month', strtotime($date)));
                
                $previous_monthly_score[] = [
                    'month'=> date('F', strtotime($start_date)),
                    'score' => auth()->user()->userMonthlyScore($start_date),
                    'total_score' => auth()->user()->getMonthlyCount($start_date) * 10,
                    //'start_date' => $start_date,
                    //'end_date' => $end_date,
                ];
            }
            $avg_score = 0;
            if ($user->getMonthlyCount($date) != 0) {
                $avg_score = $user->userMonthlyScore($date) / $user->getMonthlyCount($date);
            }
            $data = [
                'happiness_score' => $user->userMonthlyScore($date),
                'total_happiness_score' => $user->getMonthlyCount($date) * 10,
                'avg_score' => $avg_score,
                'previous_score' => $previous_monthly_score,
            ];
        }
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], 200);
    }
}
