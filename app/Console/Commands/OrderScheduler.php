<?php

namespace App\Console\Commands;

use App\Helpers\Common\GeneralHelper;
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
            $user = User::where('id', $order->user_id)->first();
            $title = GeneralHelper::getTranslation($user->app_language ?? 'en', 'order.pending');
            $message = GeneralHelper::getTranslation($user->app_language ?? 'en', 'order.pending.message');
            $response = [
                "status" => "success",
                "message" => $title,
                "data" => ['order' => $order]
            ];
            $fcmTokens = User::where('id', $order->user_id)->where('enable_notification',1)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
            NotificationUtility::sendNotification($title, $message, $fcmTokens, $response);
        }
        $this->info('Notification invoke for users');

        $orders = Order::where('status', 'pending')->with('items', 'splitOrder')->where('updated_at', '<=', Carbon::now()->subDays(1)->toDateTimeString())->get();
        foreach ($orders as $order) {
            $user = User::where('id', $order->user_id)->first();
            $locale = $user->app_language ?? 'en';
            $reason = GeneralHelper::getTranslation($locale, 'deposit.no');
            $title = GeneralHelper::getTranslation($locale, 'order.status.update');
            $orderCancelled = GeneralHelper::getTranslation($locale, 'order.status.cancelled');
            $message = str_replace('__reference_no__', $order->reference_no, $orderCancelled);
            foreach ($order->items as $item) {
                $item->status = 'cancelled';
                $item->timeline = 'order-cancelled';
                $item->reason = $reason;
                $item->save();

            }
            $order->status = 'cancelled';
            $order->timeline = 'order-cancelled';
            $order->reason = $reason;
            $order->save();
            $response = [
                "type" => "order-update",
                "title" => $title,
                "status" => "success",
                "message" => $orderCancelled,
                "data" => ['order' => $order]
            ];
            $fcmTokens = User::whereNotNull('fcm_token')->where('id', $order->user_id)->where('enable_notification',1)->pluck('fcm_token')->toArray();
            NotificationUtility::sendNotification($title, $orderCancelled, $fcmTokens, $response);

        }
    }
}
