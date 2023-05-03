<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserActivity;
use App\Models\UserDailyActivity;
use App\Models\UserWeeklyActivity;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->date;
        $day = date('w', strtotime($date));
        $today = date("Y-m-d"); //today
        if (strtotime($today) >= strtotime($date)) {

            $user = auth()->user();
            $data['today_score'] = $user->userdailyscore($date);
            $data['today_total_score'] = $user->userdailyactivitycount($date) * 10;
            $data['weekly_score'] = $user->userWeeklyScore($date);
            $data['weekly_total_score'] = $user->getWeeklyCount() * 10;

            $activity_mandatory = [];
            $activity_optional = [];
            $dailyactivities = UserDailyActivity::where('user_id', $user->id)->whereDate('created_at', $date)->get();
            foreach ($dailyactivities as $dailyactivity) {
                if ($dailyactivity->userWeeklyActivity->userActivity->category_id == 1) {
                    if ($dailyactivity->userWeeklyActivity->userActivity->name) {
                        $activity_mandatory[$dailyactivity->userWeeklyActivity->userActivity->name] = [
                            "score" => $dailyactivity->score,
                            "start_time" => $dailyactivity->start_time,
                            "end_time" => $dailyactivity->end_time,
                            "icon" => $dailyactivity->userWeeklyActivity->userActivity->icon,
                        ];
                    } else {
                        $name = $dailyactivity->userWeeklyActivity->userActivity->adminactivities($dailyactivity->userWeeklyActivity->userActivity->activity_id);

                        $activity_mandatory[$name['name']] = [
                            "score" => $dailyactivity->score,
                            "start_time" => $dailyactivity->start_time,
                            "end_time" => $dailyactivity->end_time,
                            "icon" => $dailyactivity->userWeeklyActivity->userActivity->icon,
                        ];
                    }
                } else {
                    if ($dailyactivity->userWeeklyActivity->userActivity->name) {
                        $activity_optional[$dailyactivity->userWeeklyActivity->userActivity->name] = [
                            "score" => $dailyactivity->score,
                            "start_time" => $dailyactivity->start_time,
                            "end_time" => $dailyactivity->end_time,
                            "icon" => $dailyactivity->userWeeklyActivity->userActivity->icon,
                        ];
                    } else {
                        $name = $dailyactivity->userWeeklyActivity->userActivity->adminactivities($dailyactivity->userWeeklyActivity->userActivity->activity_id);

                        $activity_optional[$name['name']] = [
                            "score" => $dailyactivity->score,
                            "start_time" => $dailyactivity->start_time,
                            "end_time" => $dailyactivity->end_time,
                            "icon" => $dailyactivity->userWeeklyActivity->userActivity->icon,
                        ];
                    }
                }
            }
            $activitydata['mandatory'] = $activity_mandatory;
            $activitydata['discretionary'] = $activity_optional;
            $data['activities'] = $activitydata;
            $data['day'] =  date('l', strtotime($date));
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ], 200);
        } else {
            $user = auth()->user();
            $data['today_score'] = $user->userdailyscore($date);
            $data['today_total_score'] = $user->userdailyactivitycount($date) * 10;
            $data['weekly_score'] = $user->userWeeklyScore($date);
            $data['weekly_total_score'] = $user->getWeeklyCount() * 10;
            $activity_mandatory = [];
            $activity_optional = [];
            $weeklyactivities = UserWeeklyActivity::where('user_id', $user->id)->whereDate('created_at', $date)->get();
            //dd($weeklyactivities);
            foreach ($weeklyactivities as $weeklyactivity) {
                if ($weeklyactivity->userActivity->category_id == 1) {
                    if ($weeklyactivity->userActivity->name) {
                        $activity_mandatory[$weeklyactivity->userActivity->name] = [
                            "start_time" => $weeklyactivity->start_time,
                            "end_time" => $weeklyactivity->end_time,
                            "icon" => $weeklyactivity->userWeeklyActivity->userActivity->icon,
                        ];
                    } else {
                        $name = $weeklyactivity->userActivity->adminactivities($weeklyactivity->userActivity->activity_id);

                        $activity_mandatory[$name['name']] = [
                            "start_time" => $weeklyactivity->start_time,
                            "end_time" => $weeklyactivity->end_time,
                            "icon" => $weeklyactivity->userActivity->icon,
                        ];
                    }
                } else {
                    if ($weeklyactivity->userActivity->name) {
                        $activity_optional[$weeklyactivity->userActivity->name] = [

                            "start_time" => $weeklyactivity->start_time,
                            "end_time" => $weeklyactivity->end_time,
                            "icon" => $weeklyactivity->userActivity->icon,
                        ];
                    } else {
                        $name = $weeklyactivity->userActivity->adminactivities($weeklyactivity->userActivity->activity_id);

                        $activity_optional[$name['name']] = [
                            "start_time" => $weeklyactivity->start_time,
                            "end_time" => $weeklyactivity->end_time,
                            "icon" => $weeklyactivity->userActivity->icon,
                        ];
                    }
                }
            }
            $activitydata['mandatory'] = $activity_mandatory;
            $activitydata['discretionary'] = $activity_optional;
            $data['activities'] = $activitydata;
            $data['day'] =  date('l', strtotime($date));
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ], 200);
        }
    }
    public function dateActivity(Request $request)
    {
        $date = $request->date;
        $day = date('w', strtotime($date));
        $today = date("Y-m-d"); //today
        if (strtotime($today) >= strtotime($date)) {
            $user = auth()->user();
            $data['today_score'] = $user->userdailyscore($date);
            $data['today_total_score'] = $user->userdailyactivitycount($date) * 10;
            $data['weekly_score'] = $user->userWeeklyScore($date);
            $data['weekly_total_score'] = $user->getWeeklyCount() * 10;

            $activity_mandatory = [];
            $activity_optional = [];
            $dailyactivities = UserDailyActivity::where('user_id', $user->id)->whereDate('created_at', $date)->get();
            foreach ($dailyactivities as $dailyactivity) {
                if ($dailyactivity->userWeeklyActivity->userActivity->category_id == 1) {
                    if ($dailyactivity->userWeeklyActivity->userActivity->name) {
                        $activity_mandatory[$dailyactivity->userWeeklyActivity->userActivity->name] = [
                            "score" => $dailyactivity->score,
                            "start_time" => $dailyactivity->start_time,
                            "end_time" => $dailyactivity->end_time,
                            "icon" => $dailyactivity->userWeeklyActivity->userActivity->icon,
                        ];
                    } else {
                        $name = $dailyactivity->userWeeklyActivity->userActivity->adminactivities($dailyactivity->userWeeklyActivity->userActivity->activity_id);

                        $activity_mandatory[$name['name']] = [
                            "score" => $dailyactivity->score,
                            "start_time" => $dailyactivity->start_time,
                            "end_time" => $dailyactivity->end_time,
                            "icon" => $dailyactivity->userWeeklyActivity->userActivity->icon,
                        ];
                    }
                } else {
                    if ($dailyactivity->userWeeklyActivity->userActivity->name) {
                        $activity_optional[$dailyactivity->userWeeklyActivity->userActivity->name] = [
                            "score" => $dailyactivity->score,
                            "start_time" => $dailyactivity->start_time,
                            "end_time" => $dailyactivity->end_time,
                            "icon" => $dailyactivity->userWeeklyActivity->userActivity->icon,
                        ];
                    } else {
                        $name = $dailyactivity->userWeeklyActivity->userActivity->adminactivities($dailyactivity->userWeeklyActivity->userActivity->activity_id);

                        $activity_optional[$name['name']] = [
                            "score" => $dailyactivity->score,
                            "start_time" => $dailyactivity->start_time,
                            "end_time" => $dailyactivity->end_time,
                            "icon" => $dailyactivity->userWeeklyActivity->userActivity->icon,
                        ];
                    }
                }
            }
            $activitydata['mandatory'] = $activity_mandatory;
            $activitydata['discretionary'] = $activity_optional;
            $data['activities'] = $activitydata;
            $data['day'] =  date('l', strtotime($date));
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ], 200);
        } else {
            $user = auth()->user();
            $data['today_score'] = $user->userdailyscore($date);
            $data['today_total_score'] = $user->userdailyactivitycount($date) * 10;
            $data['weekly_score'] = $user->userWeeklyScore($date);
            $data['weekly_total_score'] = $user->getWeeklyCount() * 10;
            $activity_mandatory = [];
            $activity_optional = [];
            $weeklyactivities = UserWeeklyActivity::where('user_id', $user->id)->whereDate('created_at', $date)->get();
            //dd($weeklyactivities);
            foreach ($weeklyactivities as $weeklyactivity) {
                if ($weeklyactivity->userActivity->category_id == 1) {
                    if ($weeklyactivity->userActivity->name) {
                        $activity_mandatory[$weeklyactivity->userActivity->name] = [
                            "start_time" => $weeklyactivity->start_time,
                            "end_time" => $weeklyactivity->end_time,
                            "icon" => $weeklyactivity->userActivity->icon,
                        ];
                    } else {
                        $name = $weeklyactivity->userActivity->adminactivities($weeklyactivity->userActivity->activity_id);

                        $activity_mandatory[$name['name']] = [
                            "start_time" => $weeklyactivity->start_time,
                            "end_time" => $weeklyactivity->end_time,
                            "icon" => $weeklyactivity->userActivity->icon,
                        ];
                    }
                } else {
                    if ($weeklyactivity->userActivity->name) {
                        $activity_optional[$weeklyactivity->userActivity->name] = [

                            "start_time" => $weeklyactivity->start_time,
                            "end_time" => $weeklyactivity->end_time,
                            "icon" => $weeklyactivity->userActivity->icon,
                        ];
                    } else {
                        $name = $weeklyactivity->userActivity->adminactivities($weeklyactivity->userActivity->activity_id);

                        $activity_optional[$name['name']] = [
                            "start_time" => $weeklyactivity->start_time,
                            "end_time" => $weeklyactivity->end_time,
                            "icon" => $weeklyactivity->userActivity->icon,
                        ];
                    }
                }

                $activitydata['mandatory'] = $activity_mandatory;
                $activitydata['discretionary'] = $activity_optional;
                $data['activities'] = $activitydata;
                $data['day'] =  date('l', strtotime($date));
                return response()->json([
                    'status' => 'success',
                    'data' => $data,
                ], 200);
            }
        }
    }

    public function calendar(Request $request){
        $user = auth()->user();
        $date=$request->date;
        $data= $user->userMonthlyData($date);
        
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], 200);
    }

    public function trackscore(Request $request){
        $user = auth()->user();
        $date = $request->date;
        $data = $user->trackscore($date);
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], 200);
    }
}
