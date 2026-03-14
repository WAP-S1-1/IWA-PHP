<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = $auth()->user() ;
        $menuitems = [];

        if(in_array($user->role,["administratief"])){
            $menuitems[] = [
              'title'=> 'Gebruikers administratie',
                'route'=> 'usermanagement.index',
                'description'=> 'Beheert gebruikers, rollen en accounts',
            ];
        }

        if(in_array($user->role,["commercieel"])){
            $menuitems[] = [
                'title'=> 'Abonnementen beheer',
                'route'=> 'subscription.index',
                'description'=> 'Beheert abonnementen',

            $menuitems[] = [
                'title'=> 'Contracten.registratie',
                'route'=> 'contracts.index',
                'description'=> 'Beheert contracten',
                ]
            ];
        }

        if(in_array($user->role,["onderzoeker"])){
            $menuitems[] = [
                'title'=> 'Vergelijkt weerstations data',
                'route'=> 'compare.index',
                'description'=> 'Vergelijkt data van weerstations',

                $menuitems[] = [
                    'title'=> 'Download weerstation',
                    'route'=> 'download.index',
                    'description'=> 'Download weerstation sensordata',
                ]
            ];
        }

        if(in_array($user->role,["technisch_medewerker"])){
            $menuitems[] = [
                'title'=> 'Monitoring weerstations',
                'route'=> 'monitoring.index',
                'description'=> 'Bekijkt de status en data van de weerstations',
            ];
        }

        if(in_array($user->role,["technische_beheerder"])){
            $menuitems[] = [
                'title'=> 'API beheer',
                'route'=> 'api.index',
                'description'=> 'Beheert API toegang en technische verkeer',
            ];
        }
    return view('dashboard.index',compact('menuitems'));
    }

}
