<?php

namespace Modules\Transaction\Jobs;

use App\Classes\POST_Caller;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Transaction\Entities\Transaction;

class DelayedSubsctiptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $inputs;
    public $subscription_data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($inputs,$subscription_data)
    {
        $this->inputs = $inputs;
        $this->subscription_data = $subscription_data;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $post = new POST_Caller(SubscriptionController::class,'subscribe',Request::class,$this->subscription_data);
        $response = $post->call();
        if($response->status() != 200) { return $response; }
        Transaction::create($this->inputs);
    }
}
