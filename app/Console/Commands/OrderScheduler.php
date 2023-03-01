<?php

namespace App\Console\Commands;

use App\Models\Auth\User\User;
use App\Models\Order;
use App\Utility\NotificationUtility;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

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
        foreach ($orders as $order) {
            $response = [
                "status" => "success",
                "message" => "Notification invoke for pending orders",
                "data" => ['order' => $order]
            ];
            $fcmTokens = User::where('id', $order->user_id)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
            NotificationUtility::sendNotification('Pending Order', 'You still have pending order in your cart.', $fcmTokens, $response);
        }
        $this->info('Notification invoke for users');

        $orders = Order::where('status', 'pending')->with('items', 'splitOrder')->where('updated_at', '<=', Carbon::now()->subDays(1)->toDateTimeString())->get();
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $item->status = 'cancelled';
                $item->timeline = 'order-cancelled';
                $item->reason = 'No Deposit Paid';
                $item->save();

            }
            $order->status = 'cancelled';
            $order->timeline = 'order-cancelled';
            $order->reason = 'No Deposit Paid';
            $order->save();
            $response = [
                "type" => "order-update",
                "title" => "Order Status Update",
                "status" => "success",
                "message" => "Your order $order->reference_no has been cancelled",
                "data" => ['order' => $order]
            ];
            $fcmTokens = User::whereNotNull('fcm_token')->where('id', $order->user_id)->pluck('fcm_token')->toArray();
            NotificationUtility::sendNotification("Order Status Update", "Your order $order->reference_no has been cancelled", $fcmTokens, $response);

        }
    }
}
