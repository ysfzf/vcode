<?php
namespace Ycpfzf\Vcode;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $validCode;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ValidCode $validCode)
    {
        $this->validCode=$validCode;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->validCode->send();
    }
}
