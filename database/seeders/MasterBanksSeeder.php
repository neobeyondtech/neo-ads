<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class MasterBanksSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $banks = [
            ['id' => 1,  'name' => 'Allo Bank', 'code' => null, 'remarks' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2,  'name' => 'Bank Aladin Syariah', 'code' => null, 'remarks' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3,  'name' => 'Bank Artha Graha Internasional', 'code' => null, 'remarks' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4,  'name' => 'Bank BCA Syariah', 'code' => null, 'remarks' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5,  'name' => 'Bank Central Asia (BCA)', 'code' => '014', 'remarks' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 6,  'name' => 'Bank CIMB Niaga', 'code' => '022', 'remarks' => null,		'created_at'=>$now,'updated_at'=>$now],
            ['id' => 7,  'name' => 'Bank Danamon', 'code' => '011', 'remarks' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 8,  'name' => 'Bank Jago', 'code' => null, 'remarks' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 9,  'name' => 'Bank Jago Syariah', 'code' => null, 'remarks' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 10, 'name' => 'Bank Mandiri', 'code' => '008', 'remarks' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 11, 'name' => 'Bank Maybank Indonesia', 'code' => '016', 'remarks' => null,		'created_at'=>$now,'updated_at'=>$now],
            ['id' => 12, 'name' => 'Bank Mega Syariah', 'code' => null,	'remarks'=>null,'created_at'=>$now,'updated_at'=>$now],
            ['id' => 13,	'name'=>'Bank Muamalat Indonesia','code'=>'147','remarks'=>null,'created_at'=>$now,'updated_at'=>$now],
            ['id' => 14,	'name'=>'Bank Negara Indonesia (BNI)','code'=>'009','remarks'=>null,'created_at'=>$now,'updated_at'=>$now],
            ['id' => 15,	'name'=>'Bank Neo Commerce','code'=>null,'remarks'=>null,'created_at'=>$now,'updated_at'=>$now],
            ['id' => 16,	'name'=>'Bank OCBC NISP','code'=>'028','remarks'=>null,'created_at'=>$now,'updated_at'=>$now],
            ['id' => 17, 'name' => 'Bank Panin', 'code' => '019', 'remarks' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 18, 'name' => 'Bank Permata', 'code' => '013', 'remarks' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 19, 'name' => 'Bank Rakyat Indonesia (BRI)', 'code' => '002', 'remarks' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 20, 'name' => 'Bank Syariah Indonesia (BSI)', 'code' => '451', 'remarks' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 21, 'name' => 'Bank Tabungan Negara (BTN)', 'code' => '200', 'remarks' => null,		'created_at'=>$now,'updated_at'=>$now],
            ['id' => 22,	'name'=>'Blu by BCA Digital','code'=>null,'remarks'=>null,'created_at'=>$now,'updated_at'=>$now],
            ['id' => 23,	'name'=>'Jenius (Bank BTPN)','code'=>'213','remarks'=>null,'created_at'=>$now,'updated_at'=>$now],
            ['id' => 24,	'name'=>'Seabank Indonesia','code'=>null,'remarks'=>null,'created_at'=>$now,'updated_at'=>$now],
        ];

        foreach ($banks as $bank) {
            DB::table('master_banks')->upsert($bank, ['id'], ['name', 'code', 'remarks', 'updated_at']);
        }
    }
}
