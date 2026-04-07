<?php

namespace App\Services;

use App\Models\User;

class MenuBuilder
{
    public function buildMenuItems(User $user): array
    {
        $menus = [];

        if ($user->hasRole('administratief')) {
            $menus[] = $this->administratiefMenu();
        }

        if ($user->hasRole('commercieel')) {
            $menus[] = $this->commercieelMenu();
        }

        if ($user->hasRole('onderzoeker')) {
            $menus[] = $this->onderzoekerMenu();
        }

        if ($user->hasRole('technisch_medewerker')) {
            $menus[] = $this->technischMedewerkerMenu();
        }

        if ($user->hasRole('technisch_beheerder')) {
            $menus[] = $this->technischBeheerderMenu();
        }

        return $menus;
    }

    private function administratiefMenu(): array
    {
        return [
            'title' => 'Gebruikers administratie',
            'route' => 'usermanagement.index',
            'description' => 'Beheert gebruikers, rollen en accounts',
        ];
    }

    private function commercieelMenu(): array
    {
        return [
            ['title' => 'Abonnementen beheer', 'route' => 'subscription.index', 'description' => 'Beheert abonnementen'],
            ['title' => 'Contracten.registratie', 'route' => 'contracts.index', 'description' => 'Beheert contracten'],
        ];
    }

    private function onderzoekerMenu(): array
    {
        return [
            ['title' => 'Vergelijkt weerstations data', 'route' => 'compare.index', 'description' => 'Vergelijkt data van weerstations'],
            ['title' => 'Download weerstation', 'route' => 'download.index', 'description' => 'Download weerstation sensordata'],
        ];
    }

    private function technischMedewerkerMenu(): array
    {
        return [
            'title' => 'Monitoring weerstations',
            'route' => 'monitoring.index',
            'description' => 'Bekijkt de status en data van de weerstations',
        ];
    }

    private function technischBeheerderMenu(): array
    {
        return [
            'title' => 'API beheer',
            'route' => 'api.index',
            'description' => 'Beheert API toegang en technische verkeer',
        ];
    }
}
