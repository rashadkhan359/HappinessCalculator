<?php

namespace App\Http\Controllers\Api;

use App\Models\UserActivity;
use App\Http\Controllers\Controller;
use App\Models\UserWeeklyActivity;
use Illuminate\Http\Request;
use App\Notifications\ActivityComplete;
use Illuminate\Support\Facades\Notification;
use App\Services\FCMService;

class ActivityController extends Controller
{
    public function addTask(Request $request)
    {
        $user = auth()->user();
        
        $useractivity = new UserActivity;
        $useractivity->user_id = $user->id;
        $useractivity->category_id = $request->task_category;
        $useractivity->activity_id = $request->activity_id;
        $useractivity->name = $request->task_name;
        $useractivity->color_code = $request->color_code;
        $useractivity->icon_id= $request->icon_id;
        $useractivity->activity_id = $request->activity_id;
        $useractivity->save();

        $useractivity->userWeeklyActivity()->create([
            'user_id' => $user->id,
            'day_id' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Task added successfully',
        ], 200);
    }

    public function taskCompleted(Request $request)
    {
        $user = auth()->user();
        $validatedData = $request->validate([
            'task_id' => 'required',
            'is_task_completed' => 'required',
            'after_task_feel' => 'required',
        ]);
        $user = auth()->user();
        $activity = $user->useractivity()->where('id', $request->task_id)->first();
        $daily = $activity->userWeeklyActivity()->where('day_id', $request->day_id)->first();
        $activitydaily = $daily->userDailyActivity()->create([
            'user_id' => $user->id,
            'status' => $request->is_task_completed,
            'score' => $request->after_task_feel,
            'hours_spent' => $request->hours_spent,
        ]);
        
        //firebase notification service for task completed
        FCMService::send(
            $user->fcm_token,
            $notification = [
                'title' => 'You have completed your task',
                'body' => 'Congrats! You have completed ' . $activitydaily->userWeeklyActivity->userActivity->name . ' task',
            ],
        );

        Notification::send($user, new ActivityComplete($user, $activitydaily));

        return response()->json([
            'status' => 'success',
            'message' => 'Task completed successfully',
        ], 200);
    }

    public function DeleteActivity(Request $request)
    {
        $user = auth()->user();
        $validatedData = $request->validate([
            'task_id' => 'required',
        ]);
        $user = auth()->user();
        $activity = $user->useractivity()->where('id', $request->task_id)->first();
        $activity->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Task deleted successfully',
        ], 200);
    }

    public function geticons(){
        $icons = \App\Models\Icon::all();
        //dd($icons);
        foreach($icons as $icon){
            $icon->path=url('/public/storage/'.$icon->path);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Icons fetched successfully',
            'data' => $icons,
        ], 200);
    }

    public function adminActivites(){
        $activities = \App\Models\Activity::all();

        //$activities['icon'] = url('public/storage/'.$activities->icon->path);
        //$activities['category'] = $activities->category;
        return response()->json([
            'status' => 'success',
            'message' => 'Admin Activities fetched successfully',
            'data' => $activities,
        ], 200);
    }

    public function EditActivity(Request $request){
        $user = auth()->user();
        $activity = $user->useractivity()->where('id', $request->task_id)->first();
        
        if($request->has('activity_id')){
            $activity->activity_id = $request->activity_id;
            $activity->save();
        }

        if($request->has('task_name')){
            $activity->name = $request->task_name;
            $activity->save();
        }
        if($request->has('task_category')){
            $activity->category_id = $request->task_category;
            $activity->save();
        }
        if($request->has('color_code')){
            $activity->color_code = $request->color_code;
            $activity->save();
        }
        if($request->has('icon_id')){
            $activity->icon_id = $request->icon_id;
            $activity->save();
        }
        
        $weekactivity = UserWeeklyActivity::where('user_id', $user->id)->where('user_activity_id', $request->task_id)->first();
        

        if($request->has('day')){
            $weekactivity->day_id = $request->day;
            $weekactivity->save();
        }
        if($request->has('start_time')){
            $weekactivity->start_time = $request->start_time;
            $weekactivity->save();
        }
        if($request->has('end_time')){
            $weekactivity->end_time = $request->end_time;
            $weekactivity->save();
        }
        

        return response()->json([
            'status' => 'success',
            'message' => 'Task updated successfully',
        ], 200);
    }
}
