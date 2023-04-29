<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use DateTime;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $weekly_count = 0;
    protected $daily_count = 0;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'age',
        'gender',
        'phone',
        'date_of_birth',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function otp()
    {
        return $this->hasOne(otp_verification::class, 'user_id', 'id');
    }
    public function useractivity()
    {
        return $this->hasMany(UserActivity::class);
    }

    public function useractivities($date)
    {
        return $this->hasMany(UserActivity::class)->whereDate('created_at', $date)->get();
    }

    public function userdailyscore($date)
    {
        $score = 0;
        $activities = $this->hasMany(UserDailyActivity::class)->whereDate('created_at', $date)->where('status', 1)->get();
        foreach ($activities as $activity) {
            $score += $activity->score;
        }
        return $score;
    }

    public function userdailyactivitycount($date)
    {

        $activities = $this->hasMany(UserDailyActivity::class)->whereDate('created_at', $date)->get();

        return count($activities);
    }

    public function userWeeklyScore($date)
    {
        $score = 0;
        $today_day = date('w', strtotime($date));
        $week_number = date('W', strtotime($date));

        $dates = new DateTime();
        $dates->setISODate(date('Y'), $week_number);

        $week_start = $dates->format('Y-m-d'); // Start date of the week
        $week_end = $dates->modify('+6 days')->format('Y-m-d'); // End date of the week (6 days after the start date)

        for ($i = 0; $i < 7; $i++) {
            $currentDate = date('Y-m-d', strtotime($week_start . "+" . $i . " days"));
            if ($currentDate > date('Y-m-d')) {
                break;
            }
            $score += auth()->user()->userdailyscore($currentDate);
            $this->weekly_count += auth()->user()->userdailyactivitycount($currentDate);
        }
        return $score;
    }

    public function userMonthlyScore($date)
    {
        $score = 0;
        $month = date('m', strtotime($date));
        $startDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . ", first day of this month"));
        $endDate = date("Y-m-t", strtotime(date("Y-m-d", strtotime($date)) . ", last day of this month"));
        $diff = date_diff(date_create($startDate), date_create($endDate));
        for ($i = 0; $i <= $diff->format("%a"); $i++) {
            $currentDate = date('Y-m-d', strtotime($startDate . "+" . $i . " days"));
            if ($currentDate > date('Y-m-d')) {
                break;
            }
            $score += auth()->user()->userdailyscore($currentDate);
            $this->daily_count += auth()->user()->userdailyactivitycount($currentDate);
        }
        return $score;
    }
    public function getMonthlyCount()
    {
        return $this->daily_count;
    }

    public function getWeeklyCount()
    {
        //donot call it alone call with userWeeklyScore
        return $this->weekly_count;
    }

    public function userMonthlyData($date)
    {
        $startDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . ", first day of this month"));
        $endDate = date("Y-m-t", strtotime(date("Y-m-d", strtotime($date)) . ", last day of this month"));
        $diff = date_diff(date_create($startDate), date_create($endDate));
        $data = [];

        for ($i = 0; $i <= $diff->format("%a"); $i++) {
            $currentDate = date('Y-m-d', strtotime($startDate . "+" . $i . " days"));
            if ($currentDate <= date('Y-m-d')) {
                $daily_activities = [];
                $activities = UserDailyActivity::whereDate('created_at', $currentDate)->where('user_id', auth()->user()->id)->get();
                foreach ($activities as $activity) {
                    if ($activity->userWeeklyActivity->userActivity->name) {
                        $daily_activities[$activity->userWeeklyActivity->userActivity->name] = [
                            "score" => $activity->score,
                            "start_time" => $activity->start_time,
                            "end_time" => $activity->end_time,
                            "icon" => $activity->userWeeklyActivity->userActivity->icon,
                        ];
                    } else {
                        $name = $activity->userWeeklyActivity->userActivity->adminactivities($activity->userWeeklyActivity->userActivity->activity_id);
                        $daily_activities[$name['name']] = [
                            "score" => $activity->score,
                            "start_time" => $activity->start_time,
                            "end_time" => $activity->end_time,
                            "icon" => $activity->userWeeklyActivity->userActivity->icon,
                        ];
                    }
                }
                $data[$currentDate] = [
                    'score' => auth()->user()->userdailyscore($currentDate),
                    'total' => auth()->user()->userdailyactivitycount($currentDate) * 10,
                    'tasks_of_day' => $daily_activities
                ];
            }
        }

        return $data;
    }

    public function trackscore($date)
    {
        $data['previous_daily_score'] = [];
        $data['previous_weekly_score'] = [];
        $data['previous_monthly_score'] = [];
        //score for 3days
        for ($i = 1; $i < 4; $i++) {
            $currentDate = date('Y-m-d', strtotime($date . "-" . $i . " days"));
            if ($currentDate > date('Y-m-d')) {
                break;
            }
            $data['previous_daily_score'][$currentDate] = [
                'day_score' => auth()->user()->userdailyscore($currentDate),
                'total_day_score' => auth()->user()->userdailyactivitycount($currentDate) * 10,
            ];
        }
        //score for 3weeks
        for ($i = 0; $i < 3; $i++) {
            $start=new DateTime($date);
            $start->modify('-' . $i . ' week');
            $start->modify('Monday this week');
            $end = clone $start;
            $end->modify('Sunday this week');
            $week_start = $start->format('Y-m-d');
            $week_end = $end->format('Y-m-d');
            $data['previous_weekly_score'][$week_start] = [
                'week_score' => auth()->user()->userWeeklyScore($week_start),
                'total_week_score' => auth()->user()->getWeeklyCount() * 10,
                'start_date' => $week_start,
                'end_date' => $week_end,
            ];
        }
        dd($data['previous_weekly_score']);
        for ($i = 0; $i < 3; $i++) {
            // Calculate the starting and ending dates of the month
            $start_date = date('Y-m-01', strtotime('-' . ($i + 1) . ' month', strtotime($date)));
            $end_date = date('Y-m-t', strtotime('-' . $i . ' month', strtotime($date)));

            $data['previous_monthly_score'][date('F', strtotime($start_date))] = [
                'month_score' => auth()->user()->userMonthlyScore($start_date),
                'total_month_score' => auth()->user()->getMonthlyCount() * 10,
                'start_date' => $start_date,
                'end_date' => $end_date,
            ];
        }
        return $data;
    }
}
