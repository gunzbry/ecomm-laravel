<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name'=>'Oppo mobile',
                'price' => '300',
                'description' => 'A chinese smart phone with 8GB ram and much more features.',
                'category' => 'mobile',
                'gallery' => "https://fdn2.gsmarena.com/vv/bigpic/oppo-a95-5g.jpg"
            ],
            [
                'name'=>'Panasonic TV',
                'price' => '400',
                'description' => 'Shipped directly from Japan!',
                'category' => 'tv',
                'gallery' => "https://news.panasonic.com/global/press/data/en070809-7/en070809-7-1.jpg"
            ],
            [
                'name'=>'Viera PLASMA',
                'price' => '500',
                'description' => 'crazy plasma TV with efficient power saving',
                'category' => 'tv',
                'gallery' => "https://news.panasonic.com/global/press/data/en060719-2/en060719-2-1.jpg"
            ],
            [
                'name'=>'ToddHoward Smartfridge',
                'price' => '1000',
                'description' => 'Smart fridge, able to play skyrim on it - ToddHoward',
                'category' => 'fridge',
                'gallery' => "https://hnsgsfp.imgix.net/9/images/detailed/40/GC-B22FTQPL-1.jpg"
            ],
        ]);
    }
}
