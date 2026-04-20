<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Userrole;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersAndUserrolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert userroles using the model
        $roles = [
            ['id' => 1, 'role' => 'Technisch medewerker', 'description' => 'Medewerker van de afdeling monitoring en beheer'],
            ['id' => 2, 'role' => 'Technisch onderzoeker', 'description' => 'Medewerker van de afdeling analyse en datamining'],
            ['id' => 3, 'role' => 'Commercieel medewerker', 'description' => 'Medewerker van de afdeling marketing en klant beheer'],
            ['id' => 4, 'role' => 'Administratief medewerker', 'description' => 'Medewerker van de afdeling personeelszaken'],
            ['id' => 5, 'role' => 'Technisch beheerder', 'description' => 'Medewerker van de afdeling IT-support'],
            ['id' => 6, 'role' => 'Administrator', 'description' => 'Super user'],
        ];

        foreach ($roles as $roleData) {
            Userrole::create($roleData);
        }

        // Insert users using the model
        $users = [
            [
                'id' => 1,
                'name' => 'Rietdijk',
                'first_name' => 'Harald',
                'initials' => 'H.H.',
                'prefix' => null,
                'email' => 'h.h.rietdijk@iwa.nl',
                'employee_code' => 'A0001',
                'user_role' => 6,
                'password' => 'scrypt:32768:8:1$Wp86NbCNB55CDEuh$c7449811aef42b4baa9d99e0baaf3b57de09733f4e969dae4b86ab601ef6ff25b3c276340b20b5d971aecf310eb7799f48a15999a8df0a5a1706392d42e8c120',
            ],
            [
                'id' => 2,
                'name' => 'Spek',
                'first_name' => 'Nienke',
                'initials' => 'N.',
                'prefix' => 'van der',
                'email' => 'n.van.der.spek@iwa.nl',
                'employee_code' => 'A0002',
                'user_role' => 6,
                'password' => 'scrypt:32768:8:1$cfltq6vfR5fq4poI$f34ebdebf59b225d9a151c59d5f643328ba10179c00358dd905ee554fcf9113c9a9d3d8d24a7828cd6c8672e02ca9f88df7bd7d6b7ec44c1967f83ae698bbebf',
            ],
            [
                'id' => 3,
                'name' => 'Loermans',
                'first_name' => 'Arjan',
                'initials' => 'A.A.M',
                'prefix' => null,
                'email' => 'a.a.m.loermans@iwa.nl',
                'employee_code' => 'A0003',
                'user_role' => 6,
                'password' => 'scrypt:32768:8:1$WtuByIUWcKCpkyts$e255a8fd4603c7dc69d416dae629c7f757df74e76f8eb05583d1ff2b7c157702c9dd980c18077dbd27ec019c57ca4bcf74a8c8ac775e578ffab09e4de2728e51',
            ],
            [
                'id' => 4,
                'name' => 'Misja',
                'first_name' => 'Hoebe',
                'initials' => 'M.N.',
                'prefix' => null,
                'email' => 'm.n.hoebe@iwa.nl',
                'employee_code' => 'A0004',
                'user_role' => 6,
                'password' => 'scrypt:32768:8:1$d6fe7GjgVmORd9kS$32dccfea6e0a3d92b72de2f3025df7825e315b6cd1701a88c7a62e3ac04452f43f651bcfd5511d3d2dc96614507c0e15895f407ec93f4f821b55eadb2add3b16',
            ],
            [
                'id' => 5,
                'name' => 'Ilse',
                'first_name' => 'Stroeve',
                'initials' => 'I.L.',
                'prefix' => null,
                'email' => 'i.l.stroeve@iwa.nl',
                'employee_code' => 'A0005',
                'user_role' => 6,
                'password' => 'scrypt:32768:8:1$SDvOs7hGsnBLzFkg$9adef1b3a31da95b3b12f9e8e41dc4654401dfce4df7bd7dd481b1a4a82116fc6f9c13b64ebe4510e19aee3c6dd8725f1ab83a3311e4290130b4949de85d609f',
            ],
            [
                'id' => 6,
                'name' => 'Bas',
                'first_name' => 'Heijne',
                'initials' => 'B.L.',
                'prefix' => null,
                'email' => 'b.l.heijne@iwa.nl',
                'employee_code' => 'A0006',
                'user_role' => 2,
                'password' => 'pbkdf2:sha256:150000$Hbw9ERGI$0b93464e514e7d7c5ca45acd0e508c3d5db081cea527a19e07ea784294655653',
            ],
            [
                'id' => 7,
                'name' => 'Ralf',
                'first_name' => 'Broek',
                'initials' => 'R.',
                'prefix' => 'van den',
                'email' => 'r.van.den.broek@iwa.nl',
                'employee_code' => 'A0007',
                'user_role' => 1,
                'password' => 'pbkdf2:sha256:150000$YybvDDFH$effd2777eb22c5b810f995fdb452776ed56b5ae5fd1195cbebbdca9d6a71efce',
            ],
            [
                'id' => 8,
                'name' => 'Natasha',
                'first_name' => 'Wieringa',
                'initials' => 'N.M.',
                'prefix' => null,
                'email' => 'n.m.wieringa@iwa.nl',
                'employee_code' => 'A0008',
                'user_role' => 3,
                'password' => 'scrypt:32768:8:1$SDvOs7hGsnBLzFkg$9adef1b3a31da95b3b12f9e8e41dc4654401dfce4df7bd7dd481b1a4a82116fc6f9c13b64ebe4510e19aee3c6dd8725f1ab83a3311e4290130b4949de85d609f',
            ],
            [
                'id' => 9,
                'name' => 'Serge',
                'first_name' => 'Janssen',
                'initials' => 'S.',
                'prefix' => null,
                'email' => 's.janssen@iwa.nl',
                'employee_code' => 'A0009',
                'user_role' => 4,
                'password' => 'scrypt:32768:8:1$WtuByIUWcKCpkyts$e255a8fd4603c7dc69d416dae629c7f757df74e76f8eb05583d1ff2b7c157702c9dd980c18077dbd27ec019c57ca4bcf74a8c8ac775e578ffab09e4de2728e51',
            ],
            [
                'id' => 10,
                'name' => 'Rienko',
                'first_name' => 'Techneut',
                'initials' => 'R.',
                'prefix' => 'de',
                'email' => 'r.de.techneut@iwa.nl',
                'employee_code' => 'A0010',
                'user_role' => 5,
                'password' => 'pbkdf2:sha256:150000$Hbw9ERGI$0b93464e514e7d7c5ca45acd0e508c3d5db081cea527a19e07ea784294655653',
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}
