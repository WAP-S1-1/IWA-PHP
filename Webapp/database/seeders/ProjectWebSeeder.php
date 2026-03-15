<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Userrole;
use App\Models\User;

class ProjectWebSeeder extends Seeder
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
            // ... add the rest of the users here, same format as above
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}
