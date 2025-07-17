<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductStatus;
use Carbon\Carbon;

class ProductStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        if (!ProductStatus::where('type','upcoming')->exists()) {
            $status = new ProductStatus();
            $status->id = 1;
            $status->title = "Upcoming";
            $status->type = 'upcoming';
            $status->colour_code = '#e6c60eff';
            $status->created_at = Carbon::now();
            $status->save();
        }
        if (!ProductStatus::where('type','live')->exists()) {
            $status = new ProductStatus();
            $status->id = 2;
            $status->title = "Live";
            $status->type = 'live';
            $status->colour_code = '#00ff40ff';
            $status->created_at = Carbon::now();
            $status->save();
        }
        if (!ProductStatus::where('type','closed')->exists()) {
            $status = new ProductStatus();
            $status->id = 3;
            $status->title = "Closed";
            $status->type = 'closed';
            $status->colour_code = '#df4706ff';
            $status->created_at = Carbon::now();
            $status->save();
        }
    }
}
