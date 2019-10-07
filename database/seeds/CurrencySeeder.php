<?php

use Illuminate\Database\Seeder;
use \App\Models\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            "brl",
            "usd",
            "eur",
            "gbp",
        ];
        
        foreach ($currencies as $currency) {
            Currency::create([
                "iso" => $currency
            ]);
        }
    }
}
