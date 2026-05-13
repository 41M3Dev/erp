<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            EmployeSeeder::class,
            UserSeeder::class,
            FournisseurSeeder::class,
            StockSeeder::class,
            FinanceSeeder::class,
            SalaireSeeder::class,
            CongeSeeder::class,
            CommandeSeeder::class,
        ]);
    }
}
