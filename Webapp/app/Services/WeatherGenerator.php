<?php

namespace App\Services;
use DateTime;

class WeatherGenerator
{
    // ─── 100 Stations across Malaysia, Indonesia, Philippines ────────────────────
    const stations = [
                            // Malaysia
                        ['id' => 'MY01', 'name' => 'Kuala Lumpur',    'lat' =>  3.1390, 'lon' => 101.6869],
                        ['id' => 'MY02', 'name' => 'George Town',      'lat' =>  5.4141, 'lon' => 100.3288],
                        ['id' => 'MY03', 'name' => 'Johor Bahru',      'lat' =>  1.4927, 'lon' => 103.7414],
                        ['id' => 'MY04', 'name' => 'Ipoh',             'lat' =>  4.5975, 'lon' => 101.0901],
                        ['id' => 'MY05', 'name' => 'Kuching',          'lat' =>  1.5535, 'lon' => 110.3593],
                        ['id' => 'MY06', 'name' => 'Kota Kinabalu',    'lat' =>  5.9788, 'lon' => 116.0753],
                        ['id' => 'MY07', 'name' => 'Shah Alam',        'lat' =>  3.0738, 'lon' => 101.5183],
                        ['id' => 'MY08', 'name' => 'Petaling Jaya',    'lat' =>  3.1073, 'lon' => 101.6067],
                        ['id' => 'MY09', 'name' => 'Subang Jaya',      'lat' =>  3.0489, 'lon' => 101.5801],
                        ['id' => 'MY10', 'name' => 'Miri',             'lat' =>  4.3995, 'lon' => 113.9914],
                        ['id' => 'MY11', 'name' => 'Alor Setar',       'lat' =>  6.1248, 'lon' => 100.3673],
                        ['id' => 'MY12', 'name' => 'Kota Bharu',       'lat' =>  6.1254, 'lon' => 102.2380],
                        ['id' => 'MY13', 'name' => 'Seremban',         'lat' =>  2.7297, 'lon' => 101.9381],
                        ['id' => 'MY14', 'name' => 'Kuala Terengganu', 'lat' =>  5.3296, 'lon' => 103.1370],
                        ['id' => 'MY15', 'name' => 'Sandakan',         'lat' =>  5.8402, 'lon' => 118.1179],
                        ['id' => 'MY16', 'name' => 'Tawau',            'lat' =>  4.2444, 'lon' => 117.8910],
                        ['id' => 'MY17', 'name' => 'Sibu',             'lat' =>  2.2985, 'lon' => 111.8264],
                        ['id' => 'MY18', 'name' => 'Bintulu',          'lat' =>  3.1667, 'lon' => 113.0333],
                        ['id' => 'MY19', 'name' => 'Kuantan',          'lat' =>  3.8077, 'lon' => 103.3260],
                        ['id' => 'MY20', 'name' => 'Melaka',           'lat' =>  2.1896, 'lon' => 102.2501],

                            // Indonesia
                        ['id' => 'ID01', 'name' => 'Jakarta',          'lat' => -6.2088, 'lon' => 106.8456],
                        ['id' => 'ID02', 'name' => 'Surabaya',         'lat' => -7.2575, 'lon' => 112.7521],
                        ['id' => 'ID03', 'name' => 'Bandung',          'lat' => -6.9175, 'lon' => 107.6191],
                        ['id' => 'ID04', 'name' => 'Medan',            'lat' =>  3.5952, 'lon' =>  98.6722],
                        ['id' => 'ID05', 'name' => 'Semarang',         'lat' => -6.9932, 'lon' => 110.4203],
                        ['id' => 'ID06', 'name' => 'Palembang',        'lat' => -2.9761, 'lon' => 104.7754],
                        ['id' => 'ID07', 'name' => 'Makassar',         'lat' => -5.1477, 'lon' => 119.4327],
                        ['id' => 'ID08', 'name' => 'Batam',            'lat' =>  1.0456, 'lon' => 104.0305],
                        ['id' => 'ID09', 'name' => 'Pekanbaru',        'lat' =>  0.5071, 'lon' => 101.4478],
                        ['id' => 'ID10', 'name' => 'Banjarmasin',      'lat' => -3.3186, 'lon' => 114.5944],
                        ['id' => 'ID11', 'name' => 'Denpasar',         'lat' => -8.6705, 'lon' => 115.2126],
                        ['id' => 'ID12', 'name' => 'Samarinda',        'lat' => -0.5022, 'lon' => 117.1536],
                        ['id' => 'ID13', 'name' => 'Yogyakarta',       'lat' => -7.7956, 'lon' => 110.3695],
                        ['id' => 'ID14', 'name' => 'Pontianak',        'lat' =>  0.0263, 'lon' => 109.3425],
                        ['id' => 'ID15', 'name' => 'Balikpapan',       'lat' => -1.2654, 'lon' => 116.8312],
                        ['id' => 'ID16', 'name' => 'Manado',           'lat' =>  1.4748, 'lon' => 124.8421],
                        ['id' => 'ID17', 'name' => 'Padang',           'lat' => -0.9471, 'lon' => 100.4172],
                        ['id' => 'ID18', 'name' => 'Malang',           'lat' => -7.9797, 'lon' => 112.6304],
                        ['id' => 'ID19', 'name' => 'Bogor',            'lat' => -6.5971, 'lon' => 106.8060],
                        ['id' => 'ID20', 'name' => 'Depok',            'lat' => -6.4025, 'lon' => 106.7942],
                        ['id' => 'ID21', 'name' => 'Tangerang',        'lat' => -6.1781, 'lon' => 106.6297],
                        ['id' => 'ID22', 'name' => 'Bekasi',           'lat' => -6.2349, 'lon' => 106.9896],
                        ['id' => 'ID23', 'name' => 'Mataram',          'lat' => -8.5833, 'lon' => 116.1167],
                        ['id' => 'ID24', 'name' => 'Ambon',            'lat' => -3.6954, 'lon' => 128.1814],
                        ['id' => 'ID25', 'name' => 'Jayapura',         'lat' => -2.5337, 'lon' => 140.7181],
                        ['id' => 'ID26', 'name' => 'Kupang',           'lat' => -10.1771,'lon' => 123.6070],
                        ['id' => 'ID27', 'name' => 'Sorong',           'lat' => -0.8762, 'lon' => 131.2559],
                        ['id' => 'ID28', 'name' => 'Palu',             'lat' => -0.9003, 'lon' => 119.8779],
                        ['id' => 'ID29', 'name' => 'Kendari',          'lat' => -3.9985, 'lon' => 122.5127],
                        ['id' => 'ID30', 'name' => 'Jambi',            'lat' => -1.6101, 'lon' => 103.6131],
                        ['id' => 'ID31', 'name' => 'Bengkulu',         'lat' => -3.8004, 'lon' => 102.2655],
                        ['id' => 'ID32', 'name' => 'Banda Aceh',       'lat' =>  5.5477, 'lon' =>  95.3238],
                        ['id' => 'ID33', 'name' => 'Ternate',          'lat' =>  0.7833, 'lon' => 127.3667],
                        ['id' => 'ID34', 'name' => 'Gorontalo',        'lat' =>  0.5435, 'lon' => 123.0568],
                        ['id' => 'ID35', 'name' => 'Mamuju',           'lat' => -2.6762, 'lon' => 118.8886],
                        ['id' => 'ID36', 'name' => 'Sofifi',           'lat' =>  0.7333, 'lon' => 127.5667],
                        ['id' => 'ID37', 'name' => 'Pangkal Pinang',   'lat' => -2.1316, 'lon' => 106.1169],
                        ['id' => 'ID38', 'name' => 'Tanjung Pinang',   'lat' =>  0.9180, 'lon' => 104.4429],
                        ['id' => 'ID39', 'name' => 'Palangka Raya',    'lat' => -2.2136, 'lon' => 113.9108],
                        ['id' => 'ID40', 'name' => 'Manokwari',        'lat' => -0.8615, 'lon' => 134.0622],

                            // Philippines
                        ['id' => 'PH01', 'name' => 'Manila',           'lat' => 14.5995, 'lon' => 120.9842],
                        ['id' => 'PH02', 'name' => 'Quezon City',      'lat' => 14.6760, 'lon' => 121.0437],
                        ['id' => 'PH03', 'name' => 'Cebu City',        'lat' => 10.3157, 'lon' => 123.8854],
                        ['id' => 'PH04', 'name' => 'Davao City',       'lat' =>  7.1907, 'lon' => 125.4553],
                        ['id' => 'PH05', 'name' => 'Zamboanga City',   'lat' =>  6.9214, 'lon' => 122.0790],
                        ['id' => 'PH06', 'name' => 'Antipolo',         'lat' => 14.5863, 'lon' => 121.1760],
                        ['id' => 'PH07', 'name' => 'Pasig',            'lat' => 14.5764, 'lon' => 121.0851],
                        ['id' => 'PH08', 'name' => 'Taguig',           'lat' => 14.5243, 'lon' => 121.0792],
                        ['id' => 'PH09', 'name' => 'Cagayan de Oro',   'lat' =>  8.4542, 'lon' => 124.6319],
                        ['id' => 'PH10', 'name' => 'Parañaque',        'lat' => 14.4793, 'lon' => 121.0198],
                        ['id' => 'PH11', 'name' => 'Makati',           'lat' => 14.5547, 'lon' => 121.0244],
                        ['id' => 'PH12', 'name' => 'Las Piñas',        'lat' => 14.4453, 'lon' => 120.9833],
                        ['id' => 'PH13', 'name' => 'Caloocan',         'lat' => 14.6488, 'lon' => 120.9669],
                        ['id' => 'PH14', 'name' => 'Bacoor',           'lat' => 14.4580, 'lon' => 120.9342],
                        ['id' => 'PH15', 'name' => 'General Santos',   'lat' =>  6.1164, 'lon' => 125.1716],
                        ['id' => 'PH16', 'name' => 'Bacolod',          'lat' => 10.6765, 'lon' => 122.9509],
                        ['id' => 'PH17', 'name' => 'Iloilo City',      'lat' => 10.7202, 'lon' => 122.5621],
                        ['id' => 'PH18', 'name' => 'Valenzuela',       'lat' => 14.7011, 'lon' => 120.9830],
                        ['id' => 'PH19', 'name' => 'Marikina',         'lat' => 14.6507, 'lon' => 121.1029],
                        ['id' => 'PH20', 'name' => 'Muntinlupa',       'lat' => 14.4081, 'lon' => 121.0415],
                        ['id' => 'PH21', 'name' => 'Pasay',            'lat' => 14.5378, 'lon' => 120.9937],
                        ['id' => 'PH22', 'name' => 'Mandaluyong',      'lat' => 14.5794, 'lon' => 121.0359],
                        ['id' => 'PH23', 'name' => 'San Jose del Monte','lat'=> 14.8137, 'lon' => 121.0453],
                        ['id' => 'PH24', 'name' => 'Lapu-Lapu',        'lat' => 10.3119, 'lon' => 123.9494],
                        ['id' => 'PH25', 'name' => 'Malabon',          'lat' => 14.6625, 'lon' => 120.9573],
                        ['id' => 'PH26', 'name' => 'Baguio',           'lat' => 16.4023, 'lon' => 120.5960],
                        ['id' => 'PH27', 'name' => 'Iligan',           'lat' =>  8.2280, 'lon' => 124.2452],
                        ['id' => 'PH28', 'name' => 'Butuan',           'lat' =>  8.9475, 'lon' => 125.5406],
                        ['id' => 'PH29', 'name' => 'Cotabato City',    'lat' =>  7.2236, 'lon' => 124.2461],
                        ['id' => 'PH30', 'name' => 'Tacloban',         'lat' => 11.2442, 'lon' => 125.0039],
                        ['id' => 'PH31', 'name' => 'Puerto Princesa',  'lat' =>  9.7392, 'lon' => 118.7353],
                        ['id' => 'PH32', 'name' => 'Legaspi',          'lat' => 13.1391, 'lon' => 123.7438],
                        ['id' => 'PH33', 'name' => 'Cabanatuan',       'lat' => 15.4866, 'lon' => 120.9734],
                        ['id' => 'PH34', 'name' => 'San Fernando',     'lat' => 15.0289, 'lon' => 120.6898],
                        ['id' => 'PH35', 'name' => 'Olongapo',         'lat' => 14.8295, 'lon' => 120.2826],
                        ['id' => 'PH36', 'name' => 'Dagupan',          'lat' => 16.0433, 'lon' => 120.3333],
                        ['id' => 'PH37', 'name' => 'Ormoc',            'lat' => 11.0064, 'lon' => 124.6078],
                        ['id' => 'PH38', 'name' => 'Tuguegarao',       'lat' => 17.6132, 'lon' => 121.7270],
                        ['id' => 'PH39', 'name' => 'Naga',             'lat' => 13.6192, 'lon' => 123.1814],
                        ['id' => 'PH40', 'name' => 'Roxas City',       'lat' => 11.5854, 'lon' => 122.7511],
                        ];

public static function generateData(DateTime $when, string $range): array{
    if ($range === 'hour') {
        $start = (clone $when)->modify('-1 hour');
        $clamp = 0.5;
        $frequency = "+10 minutes";
        $end   = $when;
    } else {
        $start = (clone $when)->modify('-1 months');
        $clamp = 2.0;
        $frequency = "+1 hour";
        $end   = $when;
    }

    // ─── Generate measurements every 10 minutes ──────────────────────────────────
    function randomFloat(float $min, float $max, int $decimals = 1): float {
        return round($min + mt_rand() / mt_getrandmax() * ($max - $min), $decimals);
    }

    function clamp(float $value, float $min, float $max): float {
        return max($min, min($max, $value));
    }

    $output = [];

    foreach (WeatherGenerator::stations as $station) {
        $measurements = [];
        $current = clone $start;

        // Starting values per station
        $temp = randomFloat(24.0, 36.0);
        $cloud = randomFloat(0.0, 100.0);

        while ($current <= $end) {
            // Drift slightly each step
            $temp  = clamp($temp  + randomFloat(-1 * $clamp, $clamp), 24.0, 36.0);
            $cloud = clamp($cloud + randomFloat(-10 * $clamp, 10 * $clamp),  0.0, 100.0);

            $measurements[] = [
                'recorded_at'        => $current->format('Y-m-d H:i:s'),
                'temperature_c'      => round($temp, 1),
                'cloud_coverage_pct' => round($cloud, 1),
            ];
            $current->modify($frequency);
        }

        $output[] = [
            'station_id'   => $station['id'],
            'station_name' => $station['name'],
            'latitude'     => $station['lat'],
            'longitude'    => $station['lon'],
            'measurements' => $measurements,
        ];
    }

    return $output;
}



}
