<?php

use Illuminate\Database\Seeder;

class menu_type_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = ['article','gallery','pages','portofolio','promo','service','video'];
        $route = ['article.index','gallery.index','pages.index','portofolio.index','promo.index','service.index','video.index'];

        for($i=0;$i<count($name);$i++){

            App\MenuType::create([
                'name'=> $name[$i],
                'slug'=> str_slug($name[$i]),
                'route'=> $route[$i],
            ]);
        }
    }
}
