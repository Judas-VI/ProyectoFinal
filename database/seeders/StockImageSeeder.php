<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\Models\Stock;

class StockImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = glob(database_path('seeders/imagenes/*.{jpg,jpeg,png,gif}'), GLOB_BRACE);

        if (empty($images)) {
            $this->command->info('No images found in database/seeders/imagenes. Skipping image assignment.');
            return;
        }

        $stocks = Stock::all();
        if ($stocks->isEmpty()) {
            $this->command->info('No stocks found to assign images to.');
            return;
        }

        foreach ($stocks as $stock) {
            // pick a random image from provided examples
            $source = $images[array_rand($images)];

            // store it on the public disk under productos/
            $storedPath = Storage::disk('public')->putFile('productos', new File($source));

            // save the relative path in the 'img' field (matches factory naming)
            $stock->img = $storedPath;
            $stock->save();
        }

        $this->command->info('Assigned images to ' . $stocks->count() . ' stock records.');
    }
}
