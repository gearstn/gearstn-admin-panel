<?php

namespace Modules\Machine\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Machine\Entities\Machine;

class SetMachineHideDataJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public $details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $machine = Machine::find($this->details['machine_id'])->first();
        $machine->approved = 0;
        $machine->save();
    }
}
