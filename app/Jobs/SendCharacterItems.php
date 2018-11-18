<?php

namespace App\Jobs;

use App\Emulator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendCharacterItems implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The purchase we're applying
     *
     * @var \App\Purchase
     */
    public $purchase;

    /**
     * GUID of the character that's receiving the content of the purchase.
     *
     * @var integer
     */
    public $characterId;

    /**
     * Name of the target emulator
     *
     * @var \App\Contracts\EmulatorContract
     */
    public $emulator;

    /**
     * Create a new job instance.
     *     
     * @param \App\Purchase $purchase    
     * @param integer       $characterId 
     * @param string        $emulator    
     */
    public function __construct($purchase, $characterId, $emulator)
    {
        $this->purchase = $purchase;
        $this->characterId = $characterId;
        $this->emulator = Emulator::driver($emulator);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $itemIds = $this
            ->purchase
            ->products()
            ->gear()
            ->pluck('reference');

        $this->emulator->mail()->sendItems(
            $this->characterId,
            $itemIds
        );
    }
}
