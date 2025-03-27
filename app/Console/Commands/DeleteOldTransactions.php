<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use Illuminate\Console\Command;
use Carbon\Carbon;

class DeleteOldTransactions extends Command
{
    protected $signature = 'transactions:delete-old';
    protected $description = 'Delete transactions older than 30 days';

    public function handle()
    {
        $thirtyDaysAgo = Carbon::now()->subDays(30);
        
        $count = Transaction::where('created_at', '<', $thirtyDaysAgo)->delete();
        
        $this->info("Deleted {$count} old transactions");
    }
} 