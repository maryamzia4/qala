<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Interaction;
use Illuminate\Database\Seeder;

class InteractionSeeder extends Seeder
{
    public function run()
    {
        $userIds = User::pluck('id')->toArray();
        $productIds = Product::pluck('id')->toArray();

        if (empty($userIds) || empty($productIds)) {
            $this->command->warn('No users or products found. Seed users and products first.');
            return;
        }

        foreach (range(1, 50) as $i) {
            Interaction::create([
                'user_id' => $userIds[array_rand($userIds)],
                'product_id' => $productIds[array_rand($productIds)],
                'interaction' => rand(1, 5),
            ]);
        }
    }
}
