<?php

use Illuminate\Database\Seeder;

class category_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = ['Website','Web Apps', 'Mobile Apps'];

        for($i=0;$i<count($name);$i++){
            $role = App\Category::create([
                'name'=> $name[$i],
                'slug'=> str_slug($name[$i]),
                'description' => 'description'
            ]);

        }
    }
}
