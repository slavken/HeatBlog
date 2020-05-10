<?php

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['World', 'blue'],
            ['Opinion', 'green'],
            ['Design', 'red'],
            ['LifeHacks'],
            ['Tech'],
            ['Business'],
            ['Science'],
            ['Programming'],
            ['Style'],
            ['Travel'],
            ['Test Test']
        ];

        foreach ($data as $name) {
            factory(Category::class)->create([
                'name' => $name[0],
                'alias' => Str::slug($name[0]),
                'color' => $name[1] ?? null
            ]);
        }
    }
}
