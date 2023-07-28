<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpLoadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $image;
    private $id;
    private $imageName;

    public function __construct($image,$id,$imageName)
    {
        $this->image = $image;
        $this->id = $id;
        $this->name = $imageName;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $this->image->move('images', $this->name);
    }
}
