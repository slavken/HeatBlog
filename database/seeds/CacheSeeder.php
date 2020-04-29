<?php

use App\CacheModel;
use Illuminate\Database\Seeder;

class CacheSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'category',
            'test'
        ];

        foreach ($data as $name) {
            factory(CacheModel::class)->create([
                'name' => $name
            ]);
        }
    }
}
