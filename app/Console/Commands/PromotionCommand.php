<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Promotions;
use Carbon\Carbon;
class PromotionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:promotions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check promotion expires';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Check daily promotion expiry');
        $promotions = Promotions::where('end_date', '<=', Carbon::now()->addDay()->toDateTimeString())->get();
        foreach ($promotions as $promotion) {
            $promotion->status = 1;
            $promotion->save();
        }
    }
}
