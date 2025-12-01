<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Stock;
use App\Models\Usuario;
use App\Models\Carrito;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        $stocks = Stock::factory(20)->create();
        $usuarios = Usuario::factory(5)->create();
        // se crea un usuarui con carrito yy varios productos 
        foreach ($usuarios as $usuario) {
            $carrito = Carrito::factory()->create(['usuario_id' => $usuario->id]);

            $selected = $stocks->random(rand(2, 5));
            $total = 0;
            foreach ($selected as $stock) {
                $cantidad = rand(1, 4);
                $precio = $stock->precio;
                $carrito->stocks()->attach($stock->id, [
                    'precio' => $precio,
                    'cantidad' => $cantidad,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $total += $precio * $cantidad;
            }

            $carrito->update(['total_precio' => $total]);
        }

        // Assign real images from database/seeders/imagenes to the created stocks
        $this->call(StockImageSeeder::class);
    }
}
