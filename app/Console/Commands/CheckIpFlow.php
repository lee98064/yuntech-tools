<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ip;
use App\Models\LineNotifyToken;
use App\Services\IpFlowService;
use App\Services\LineNotifyService;
use App\Services\WebNotifyService;
use Notification;

class CheckIpFlow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:ipflow';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check All Ip Flow';

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
        $ips = IP::with('user.linenotifytoken')->get();
        $ipflow = new IpFlowService();
        $linenotify = new LineNotifyService();
        foreach ($ips as $ip) {
            $flow = $ipflow->GetFlow($ip->ip);
            $flowhuman = $ipflow->humanFileSize($flow);

            if (floatval($flow) > 10 && $ip->flow < 10) {
                $message = "\n目前流量已超過10GB，您已被鎖卡!\nIP: {$ip->ip}\n今日使用流量: {$flowhuman}";
            } elseif (floatval($flow) > 9 && $ip->flow < 9) {
                $message = "\n目前流量已達9GB，請注意使用!\nIP: {$ip->ip}\n今日使用流量: {$flowhuman}";
            } elseif (floatval($flow) > 8 && $ip->flow < 8) {
                $message = "\n目前流量已達8GB，請注意使用!\nIP: {$ip->ip}\n今日使用流量: {$flowhuman}";
            } elseif (floatval($flow) > 5 && $ip->flow < 5) {
                $message = "\n目前流量已達5GB，請注意使用!\nIP: {$ip->ip}\n今日使用流量: {$flowhuman}";
            }

            $ip->flow = floatval($flow);
            $ip->save();
            if (isset($message)) {

                if ($ip->linenotify) {
                    $linemessage = $linenotify->text_message($message, false);
                    $linenotify->send($linemessage, $ip->user->linenotifytoken->token);
                }

                if ($ip->webnotify)
                    Notification::send($ip->user, new WebNotifyService("流量提醒", $message, ['開啟工具包網站', 'openHomepage']));
            }
        }
        return 0;
    }
}
