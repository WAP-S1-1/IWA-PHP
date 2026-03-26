<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('subscriptions')->upsert(
            [
                [
                    'id' => 1,
                    'company' => 10,
                    'type' => 17,
                    'start_date' => '2006-03-01',
                    'end_date' => null,
                    'price' => 142.95,
                    'notes' => null,
                    'identifier' => 'SCHIP10',
                    'token' => 'LKSDJFUI35NSFDG8M@KL',
                ],
                [
                    'id' => 2,
                    'company' => 11,
                    'type' => 16,
                    'start_date' => '2009-05-01',
                    'end_date' => '2018-12-31',
                    'price' => 125.82,
                    'notes' => null,
                    'identifier' => 'EELDE11',
                    'token' => 'MXCVLJBN8%KSD&LFG@DF',
                ],
                [
                    'id' => 3,
                    'company' => 11,
                    'type' => 16,
                    'start_date' => '2019-01-01',
                    'end_date' => null,
                    'price' => 113.00,
                    'notes' => null,
                    'identifier' => 'EELDE211',
                    'token' => 'MZXCBK&KJSDF%FSDM@LK',
                ],
                [
                    'id' => 4,
                    'company' => 12,
                    'type' => 17,
                    'start_date' => '2019-01-01',
                    'end_date' => null,
                    'price' => 190.60,
                    'notes' => null,
                    'identifier' => 'KNMIE',
                    'token' => 'KSDSFKJL7K234JKK$JK@JH',
                ],
                [
                    'id' => 5,
                    'company' => 13,
                    'type' => 12,
                    'start_date' => '2020-08-01',
                    'end_date' => null,
                    'price' => 24.99,
                    'notes' => null,
                    'identifier' => 'HSBHO',
                    'token' => '234KJKOIER8%JJKSD@HJSDFLK',
                ],
            ],
            ['id'],
            ['company', 'type', 'start_date', 'end_date', 'price', 'notes', 'identifier', 'token']
        );
    }

}
