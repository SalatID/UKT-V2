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
                "name"=>"Semua Tingkatan",
                "ts_code"=>"ALL",
                "created_user"=>1
            ],
            [
                "name"=>"Pratama Taruna",
                "ts_code"=>"PT",
                "created_user"=>1
            ],
            [
                "name"=>"Pratama Madya",
                "ts_code"=>"PM",
                "created_user"=>1
            ],
            [
                "name"=>"Pratama Utama",
                "ts_code"=>"PU",
                "created_user"=>1
            ],
            [
                "name"=>"Satria Taruna",
                "ts_code"=>"ST",
                "created_user"=>1
            ],
            [
                "name"=>"Satria Madya",
                "ts_code"=>"SM",
                "created_user"=>1
            ],
            [
                "name"=>"Satria Utama",
                "ts_code"=>"SU",
                "created_user"=>1
            ],
            [
                "name"=>"Pendekar Muda Taruna",
                "ts_code"=>"PMT",
                "created_user"=>1
            ],
            [
                "name"=>"Pendekar Muda Madya",
                "ts_code"=>"PMM",
                "created_user"=>1
            ],
            [
                "name"=>"Pendekar Muda Utama",
                "ts_code"=>"PMU",
                "created_user"=>1
            ],
            [
                "name"=>"Dewan Guru",
                "ts_code"=>"DG",
                "created_user"=>1
            ],
        ];
        foreach($data as $val){
            Ts::create([
                "name"=>$val['name'],
                "ts_code"=>$val['ts_code'],
                "created_user"=>1
            ]);
        }
    }
}
