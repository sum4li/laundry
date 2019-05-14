<?php

use Illuminate\Database\Seeder;

class setting_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $name=['Title','Deskripsi','Keywords','Alamat 1','Alamat 2','Email','Nomer Telepon','Whatsapp Number','Whatsapp Text'];
        $slug=['title','description','keywords','address_1','address_2','email','phone_number','wa_number','wa_text'];
        $type=['text','textarea','textarea','textarea','text','text','text','text','text'];
        $description=[
            'Digsa.id',
            'Deskripsi Website',
            'digsa, digsa.id, solo, surakarta, jasa, pembuatan, bikin, website, toko online, afiliasi, reseller, desain, logo, promosi, company profile, digital campaign, aplikasi, android, webapps',
            'address 1',
            'address 2',
            'email@email.com',
            'phone_number',
            '6282323369336',
            'Hallo Digsa, saya tertarik menggunakan jasa anda'
        ];
        for($i=0;$i<count($name);$i++){

            App\Setting::create([
                'id'=>$faker->uuid,
                'name'=> $name[$i],
                'slug'=> $slug[$i],
                'type'=> $type[$i],
                'description'=> $description[$i]
            ]);
        }
    }
}
