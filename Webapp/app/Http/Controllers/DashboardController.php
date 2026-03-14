<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index(): View
    {
        $auth = ;
        $user = $auth()->user() ;
        $menuitems = [];

        if(in_array($user->role,["administratief"])){
            $menuitems[] = [
              'title'=> 'Gebruikers administratie',
                'route'=> 'gebruiker.index',
                'description'=> 'Beheert gebruikers, rollen en accounts',
            ];
        }

        if(in_array($user->role,["commercieel"])){
            $menuitems[] = [
                'title'=> 'Abonnementen beheer',
                'route'=> 'abonnement.index',
                'description'=> 'Beheert abonnementen',

            $menuitems[] = [
                'title'=> 'Contracten.registratie',
                'route'=> 'contracten.index',
                'description'=> 'Beheert contracten',
            ];
        }

        if(in_array($user->role,["onderzoeker"])){
            $menuitems[] = [
                'title'=> 'Vergelijkt weerstations data',
                'route'=> 'vergelijken.index',
                'description'=> 'Vergelijkt data van weerstations',
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
