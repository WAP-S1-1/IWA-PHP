<?php

namespace Database\seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            [10,'Schiphol Airport','Schiphol','Aankomstpassage',1,null,'1118AX','NL','schiphol@schiphol.nl'],
            [11,'Eelde Groningen Airport','Eelde','Machlaan',14,'A','9761TK','NL','groningenAirport@eeldeairport.nl'],
            [12,'KNMI weerstation Eelde','Eelde','Burgemeester J.G. Legroweg',35,null,'9761KT','NL','knmi@eeldeairport.nl'],
            [13,'HSB Hochschule Bremen','Bremen','Neustadtswall',30,null,'28199','DE','wetter@hsb.bremen.de'],
            [14,'Hanze','Groningen','Zernikepark',7,null,'9747AK','NL','info@hanze.nl'],
            [15,'Rijksuniversiteit Groningen','Groningen','Broerstraat',5,null,'9712CP','NL','rectormag@rug.nl'],
            [16,'SHELL Campus Den Haag','Den Haag','Carel van Bylantlaan',16,null,'2596HR','NL','weerdienst@shell.nl'],
            [17,'Oxford University','Oxford','Wellington Square',1,null,'OX1 2JD','GB','weather@oxforduni.co.uk'],
            [18,'Hapag-LLoyd','Parijs','QUAI DU DOCTEUR DERVAUX',99,null,'92600','FR','transport@hplloyd.fr']
        ];

        foreach ($companies as [$id, $name, $city, $street, $number, $number_additional, $zip_code, $country, $email]) {
            Company::create([
                'id' => $id,
                'name' => $name,
                'city' => $city,
                'street' => $street,
                'number' => $number,
                'number_additional' => $number_additional,
                'zip_code' => $zip_code,
                'country' => $country,
                'email' => $email
            ]);
        }
    }
}
