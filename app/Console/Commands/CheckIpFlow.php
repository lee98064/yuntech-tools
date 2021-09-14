<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ip;
use App\Models\LineNotifyToken;
use App\Services\IpFlowService;
use App\Services\LineNotifyService;

class CheckIpFlow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'linenotify:ipflow';

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
        $ips = IP::with('linenotifytoken')->get();
        $ipflow = new IpFlowService();
        $linenotify = new LineNotifyService();
        foreach ($ips as $ip) {
            $flow = $ipflow->GetFlow($ip->ip);
            $flow = $ipflow->humanFileSize($flow);
            $message = "\nIP: {$ip->ip}\n使用流量: {$flow}";
            $message = $linenotify->text_message($message, false);
            $linenotify->send($message, $ip->linenotifytoken->token);
        }
        return 0;
    }
}
