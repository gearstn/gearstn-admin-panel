<?php

namespace Modules\SparePart\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\SparePart\Entities\SparePart;

class SetSparePartHideDateJob implements ShouldQueue
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
        $spare_part = SparePart::find($this->details['spare_part_id'])->first();
        $spare_part->approved = 0;
        $spare_part->save();
    }
}
