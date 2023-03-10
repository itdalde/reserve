<?php

namespace App\Console\Commands;

use App\Helpers\Common\GeneralHelper;
use App\Models\Auth\User\User;
use App\Models\Order;
use App\Models\OrderSplit;
use App\Utility\NotificationUtility;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CompletedOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:completed_order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check fully paid order and pass to scheduled date';

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
        $this->info('Check paid order and serve service.');

        $orders = Order::with('items', 'splitOrder')->where('orders.created_at', '>=', Carbon::now()->addDays(7)->toDateTimeString())->get();
        foreach($orders as $order)
        {
            $balance = OrderSplit::where('order_id', $order->id)->where('status', 'pending')->sum('amount');

            $user = User::where('id', $order->user_id)->first();
            $locale = $user->app_language ?? 'en';
            $title = GeneralHelper::getTranslation($locale, 'order.completed');
            $message = GeneralHelper::getTranslation($locale, 'order.completed.message');

            foreach($order->items as $item)
            {
                if ($balance == 0 && Carbon::now()->subDay()->toDateTimeString() > $item->schedule_end_datetime) {
                    $item->status = 'completed';
                    $item->timeline = 'order-completed';
                    $item->save();

                    $order['status'] = 'completed';
                    $order['timeline'] = 'order-completed';
                    $order->save();
                }

                $response = [
                    "status" => "success",
                    "message" => $title,
                    "data" => ['order' => $order->items ]
                ];
                $fcmTokens = User::where('id', $order->user_id)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
                NotificationUtility::sendNotification($title, $message, $fcmTokens, $response);
            }
        }
        $this->info('Orders who\'s fully paid marks as completed');
    }
}
