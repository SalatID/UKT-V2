<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
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
                "name"=>"SMP Negeri 225 Jakarta",
                "tingkat"=>"SMP"
            ],
            [
                "name"=>"SMA Cengkareng 1",
                "tingkat"=>"SMP"
            ],
            [
                "name"=>"SD Negeri 09 Jakarta",
                "tingkat"=>"SMP"
            ],
            [
                "name"=>"Universitar Muhammadyah Jakarta",
                "tingkat"=>"Universitas"
            ],
        ];
        foreach($data as $val){
            Unit::create([
                "name"=>$val['name'],
                "tingkat"=>$val['tingkat'],
                "komwil_id"=>1,
                "created_user"=>1
            ]);
        }
    }
}
