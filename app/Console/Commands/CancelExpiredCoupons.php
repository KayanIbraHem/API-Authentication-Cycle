<?php

namespace App\Console\Commands;

use App\Models\Coupon;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;

class CancelExpiredCoupons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cancel-expired-coupons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Coupon::where('expiry_date', '<=', Carbon::now())->update(['is_active' => 1]);
    }
}
