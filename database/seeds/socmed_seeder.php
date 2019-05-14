<?php

use Illuminate\Database\Seeder;

class socmed_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = ['facebook','instagram'];

        for($i=0;$i<count($name);$i++){

            App\Socmed::create([
                'name'=> $name[$i],
                'url'=> 'https://'.$name[$i].'.com'
            ]);
        }

    }
}
