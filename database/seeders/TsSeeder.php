<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ts;

class TsSeeder extends Seeder
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
                "id"=>1,
                "name"=>"Semua Tingkatan",
                "ts_code"=>"ALL",
                "ts_next"=>0,
                "ts_before"=>0,
                "created_user"=>1
            ],
            [
                "id"=>2,
                "name"=>"Pratama Taruna",
                "ts_code"=>"PT",
                "ts_next"=>3,
                "ts_before"=>0,
                "created_user"=>1
            ],
            [
                "id"=>3,
                "name"=>"Pratama Madya",
                "ts_code"=>"PM",
                "ts_next"=>4,
                "ts_before"=>2,
                "created_user"=>1
            ],
            [
                "id"=>4,
                "name"=>"Pratama Utama",
                "ts_code"=>"PU",
                "ts_next"=>5,
                "ts_before"=>3,
                "created_user"=>1
            ],
            [
                "id"=>5,
                "name"=>"Satria Taruna",
                "ts_code"=>"ST",
                "ts_next"=>6,
                "ts_before"=>4,
                "created_user"=>1
            ],
            [
                "id"=>6,
                "name"=>"Satria Madya",
                "ts_code"=>"SM",
                "ts_next"=>7,
                "ts_before"=>5,
                "created_user"=>1
            ],
            [
                "id"=>7,
                "name"=>"Satria Utama",
                "ts_code"=>"SU",
                "ts_next"=>8,
                "ts_before"=>6,
                "created_user"=>1
            ],
            [
                "id"=>8,
                "name"=>"Pendekar Muda Taruna",
                "ts_code"=>"PMT",
                "ts_next"=>9,
                "ts_before"=>7,
                "created_user"=>1
            ],
            [
                "id"=>9,
                "name"=>"Pendekar Muda Madya",
                "ts_code"=>"PMM",
                "ts_next"=>10,
                "ts_before"=>8,
                "created_user"=>1
            ],
            [
                "id"=>10,
                "name"=>"Pendekar Muda Utama",
                "ts_code"=>"PMU",
                "ts_next"=>11,
                "ts_before"=>9,
                "created_user"=>1
            ],
            [
                "id"=>11,
                "name"=>"Dewan Guru",
                "ts_code"=>"DG",
                "ts_next"=>0,
                "ts_before"=>10,
                "created_user"=>1
            ],
        ];
        foreach($data as $val){
            Ts::create([
                "name"=>$val['name'],
                "ts_code"=>$val['ts_code'],
                "ts_next"=>$val['ts_next'],
                "ts_before"=>$val['ts_before'],
                "created_user"=>1
            ]);
        }
    }
}
