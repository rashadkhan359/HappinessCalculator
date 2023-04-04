<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaticContent extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('static__contents')->insert([
            'title' => 'About Us',
            'content' => '',
        ]);
        DB::table('static__contents')->insert([
            'title' => 'Contact Us',
            'content' => '',
        ]);
        DB::table('static__contents')->insert([
            'title' => 'Terms and Conditions',
            'content' => '',
        ]);
        DB::table('static__contents')->insert([
            'title' => 'Privacy Policy',
            'content' => '',
        ]);
    }
}
