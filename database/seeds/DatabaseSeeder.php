<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategorySeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            CacheSeeder::class,
            UserSeeder::class,
            CommentSeeder::class,
            CommentParentSeeder::class
        ]);
    }
}
