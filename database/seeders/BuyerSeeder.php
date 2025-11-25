<?php

declare(strict_types=1);

namespace Applets\Merchandising\Database\Seeders;

use Applets\Merchandising\Models\Buyer;
use Illuminate\Database\Seeder;

class BuyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating 5000 buyers...');

        // Create buyers in chunks of 500 for better performance
        $chunkSize = 500;
        $totalBuyers = 5000;
        $chunks = $totalBuyers / $chunkSize;

        for ($i = 0; $i < $chunks; $i++) {
            $buyers = [];
            
            for ($j = 0; $j < $chunkSize; $j++) {
                $buyers[] = [
                    'name' => fake()->company(),
                    'email' => fake()->unique()->companyEmail(),
                    'phone' => fake()->phoneNumber(),
                    'address' => fake()->address(),
                    'country' => fake()->country(),
                    'contact_person' => fake()->name(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Buyer::insert($buyers);
            $this->command->info('Created ' . (($i + 1) * $chunkSize) . ' buyers...');
        }

        $this->command->info('✓ Successfully created 5000 buyers!');
    }
}
