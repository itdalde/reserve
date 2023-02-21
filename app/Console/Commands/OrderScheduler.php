<?php

namespace App\Console\Commands;

use App\Models\Auth\User\User;
use App\Models\Order;
use App\Utility\NotificationUtility;
use Carbon\Carbon;
use Illuminate\Console\Command;

class OrderScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:order_status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check order if past 24 hrs';

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
        $this->info('Check orders daily');
        $orders = Order::where('status', 'pending')->where('updated_at', '>=', Carbon::now()->addDay()->toDateTimeString())->get();
        foreach($orders as $order) {
            $response = [
                "status" => "success",
                "message" => "Notification invoke for pending orders",
                "data" => ['order' => $order ]
            ];
            $fcmTokens = User::where('id', $order->user_id)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
            NotificationUtility::sendNotification('Pending Order', 'You still have pending order in your cart.', $fcmTokens, $response);
        }   
        $this->info('Notification invoke for users');
    }
}
