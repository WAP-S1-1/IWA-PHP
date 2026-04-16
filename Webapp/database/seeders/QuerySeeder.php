<?php

namespace Database\Seeders;

use App\Models\contracts\ComparisonOperatorType;
use App\Models\contracts\Criterium;
use App\Models\contracts\CriteriumGroup;
use App\Models\contracts\CriteriumType;
use App\Models\contracts\OperatorType;
use Illuminate\Database\Seeder;
use App\Models\Query;
use Illuminate\Support\Facades\DB;

class QuerySeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Criterium::truncate();
        CriteriumGroup::truncate();
        ComparisonOperatorType::truncate();
        OperatorType::truncate();
        CriteriumType::truncate();
        Query::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $queries = [
            [
                'contract_id' => 1,
                'omschrijving' => 'Alle stations in Noorwegen en Zweden boven de 200 meter en alle
                                    stations onder 75 graden noorderbreedte. ',
            ],
        ];

        foreach ($queries as $query) {
            Query::create($query);
        }

        $criteriumTypes = [
            [
                'omschrijving' => 'Een lijst van landcodes',
                'referenced_table' => 'geolocation',
                'referenced_field' => 'country_code'
            ],
            [
                'omschrijving' => 'Hoogte van het station',
                'referenced_table' => 'station',
                'referenced_field' => 'elevation'
            ],
            [
                'omschrijving' => 'Coördinaten, breedtegraad',
                'referenced_table' => 'station',
                'referenced_field' => 'latitude'
            ],
            [
                'omschrijving' => 'Coördinaten, lengtegraad',
                'referenced_table' => 'station',
                'referenced_field' => 'longitude'
            ],
            [
                'omschrijving' => 'Regiocode',
                'referenced_table' => 'nearestlocation',
                'referenced_field' => 'administrative_region1'
            ],

        ];

        foreach ($criteriumTypes as $type) {
            CriteriumType::create($type);
        }

        $operatorTypes = [
            ['omschrijving' => 'And'],
            ['omschrijving' => 'Or']
        ];

        foreach ($operatorTypes as $type) {
            OperatorType::create($type);
        }

        $comparionsOperatorTypes = [
            ['omschrijving' => 'Equal'],
            ['omschrijving' => 'Less than'],
            ['omschrijving' => 'Less than or equal'],
            ['omschrijving' => 'More than'],
            ['omschrijving' => 'More than or equal'],
            ['omschrijving' => 'Not'],
        ];

        foreach ($comparionsOperatorTypes as $type) {
            ComparisonOperatorType::create($type);
        }

        $criteriumGroups = [
            [
                'query' => 1,
                'type' => 1,
                'group_table' => 1,
                'operator' => 1
            ],
            [
                'query' => 1,
                'type' => 2,
                'group_table' => 1,
                'operator' => 1
            ],
            [
                'query' => 1,
                'type' => 3,
                'group_table' => 2,
                'operator' => 2
            ],
        ];

        foreach ($criteriumGroups as $group) {
            CriteriumGroup::create($group);
        }

        $criteria = [
            [
                'group' => 1,
                'operator' => 2,
                'int_value' => null,
                'string_value' => "NO",
                'float_value' => null,
                'value_type' => 2,
                'value_comparison' => 1
            ],
            [
                'group' => 1,
                'operator' => 2,
                'int_value' => null,
                'string_value' => "SE",
                'float_value' => null,
                'value_type' => 2,
                'value_comparison' => 1
            ],
            [
                'group' => 2,
                'operator' => 1,
                'int_value' => 200,
                'string_value' => null,
                'float_value' => null,
                'value_type' => 1,
                'value_comparison' => 5
            ],
            [
                'group' => 3,
                'operator' => 2,
                'int_value' => null,
                'string_value' => null,
                'float_value' => 75.0,
                'value_type' => 3,
                'value_comparison' => 3
            ],
        ];

        foreach ($criteria as $criterium){
            Criterium::create($criterium);
        }
    }
}
