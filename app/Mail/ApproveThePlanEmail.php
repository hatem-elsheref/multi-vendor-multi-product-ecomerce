<?php

namespace App\Mail;

use App\Plan;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApproveThePlanEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $user;
    private $plan;
    public function __construct(User $user,Plan $plan)
    {
        $this->user=$user;
        $this->plan=$plan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $dashboardUrl=route('dashboard');
        $userName=$this->user->name;
        $planName=$this->plan->name;
        $period=$this->plan->period;
        $startingDate=Carbon::parse($this->user->plan_starting_date)->format('Y-m-d');
        $expiredDate=Carbon::parse($startingDate)->addMonths($this->plan->period)->format('Y-m-d');
        return $this->markdown('mail.approvePlan')->with([
            'dashboardUrl'  =>$dashboardUrl,
            'userName'      =>$userName,
            'planName'      =>$planName,
            'period'        =>$period,
            'startingDate'  =>$startingDate,
            'expiredDate'   =>$expiredDate,
        ]);
    }
}
