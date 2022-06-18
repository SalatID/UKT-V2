<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Komwil;

class KomwilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =[
            [
                "name"=>"Jakarta Barat",
            ],
            [
                "name"=>"Jakarta Utara",
            ],
            [
                "name"=>"Jakarta Selatan",
            ],
            [
                "name"=>"Jakarta Timur",
            ],
            [
                "name"=>"Jakarta Lampung",
            ],
            [
                "name"=>"Bekasi",
            ],
            [
                "name"=>"Bogor",
            ],
        ];
        foreach($data as $val){
            Komwil::create([
                "name"=>$val['name'],
                "created_user"=>1
            ]);
        }
    }
}
