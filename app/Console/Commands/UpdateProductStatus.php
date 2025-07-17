<?php

// App\Console\Commands\UpdateProductStatus.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\ProductStatus;
use Carbon\Carbon;

class UpdateProductStatus extends Command
{
    protected $signature = 'products:update-status';
    protected $description = 'Automatically updates product status based on start/end time';

    public function handle()
    {
        $now = Carbon::now();

        $upcoming = ProductStatus::where('type', 'upcoming')->first();
        $live     = ProductStatus::where('type', 'live')->first();
        $closed   = ProductStatus::where('type', 'closed')->first();

        // Set to LIVE if started but not ended
        Product::where('start_time', '<=', $now)
            ->where('end_time', '>', $now)
            ->where('status_id', '!=', $live->id)
            ->update(['status_id' => $live->id]);

        // Set to CLOSED if ended
        Product::where('end_time', '<', $now)
            ->where('status_id', '!=', $closed->id)
            ->update(['status_id' => $closed->id]);

        // Set to UPCOMING if start_time is in future
        Product::where('start_time', '>', $now)
            ->where('status_id', '!=', $upcoming->id)
            ->update(['status_id' => $upcoming->id]);

        $this->info(' Product statuses updated successfully.');
    }
}
