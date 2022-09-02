<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(10)->create();


        /** Текстовые страницы */
        //\App\Models\Wikipage::factory(10)->create();

       /** Назначаем администратора */
         DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@admin.loc',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
    }
}
