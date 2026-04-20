<html>
<style>
    .sidebar-link{
        text-decoration:none;
        color:black;
    }
    .resizable-text {
        min-width: 0;
        overflow-wrap: break-word;
        word-break: break-word;
        white-space: normal;
    }
    .sidebar-link:hover{color:#B20A0E}
</style>
<div class="card shadow-lg m-2 rounded-5"
     style="width:30vw;height:80vh; background-color:rgba(255,255,255,0.7)">
    <div class="d-flex align-items-start overflow-hidden">
        <img class="align-self-start my-3 flex-shrink-0" style="height:75px" src="{{asset('placeholderprofile')}}" alt="profile">
        <div class="media-body ms-2">
            <p class="my-3 e-4 align-self-baseline resizable-text" style="min-width:0;overflow-wrap:break-word;">#{{ auth()->user()->employee_code }}</p>
            <b class="align-self-baseline d-block resizable-text" style="font-size: large;word-break:break-word;">{{ auth()->user()->first_name }} {{ auth()->user()->name }}</b>
        </div>
    </div>
    <hr style="width:80%; margin-right:auto; margin-left: auto">
    <div class="d-flex align-items-start align-middle overflow-hidde">
        <img class="align-self-start m-3" style="height:50px" src="{{asset('company.svg')}}" alt="companies">
        <div class="media-body d-flex flex-column">
            <a href="{{asset('companies')}}" class="mt-3 sidebar-link resizable-text" style="font-size: larger;font-weight:bold"> Bedrijven </a>
        </div>
    </div>
    <div class="ms-4 d-flex flex-column overflow-hidden">
        <a href="{{asset('companies')}}" class="mb-1 sidebar-link resizable-text">Overzicht</a>
        <a class="mb-1 sidebar-link resizable-text" style="text-decoration: line-through;">Bijwerken</a>
        <a class="mb-1 sidebar-link resizable-text" style="text-decoration: line-through;">Toevoegen</a>
    </div>
    <div class="d-flex align-items-start align-middle overflow-hidden">
        <img class="align-self-start m-3" style="height:50px" src="{{asset('subscription.svg')}}" alt="subscriptions">
        <div class="media-body d-flex flex-column">
            <a href="{{asset('subscription')}}" class="mt-3 sidebar-link resizable-text" style="font-size: larger; font-weight:bold"> Abonnementen </a>
        </div>
    </div>
    <div class="ms-4 d-flex flex-column overflow-hidden">
        <a href="{{asset('subscription')}}" class="mb-1 sidebar-link resizable-text">Overzicht</a>
        <a href="{{route('subscription.index', ['mode' => 'edit']) }}" class="mb-1 sidebar-link resizable-text">Bijwerken</a>
        <a href="{{asset('subscription/create') }}" class="mb-1 sidebar-link resizable-text">Toevoegen</a>
    </div>
    <div class="d-flex align-items-start align-middle overflow-hidden">
        <img class="align-self-start m-3" style="height:50px" src="{{asset('contracts.svg')}}" alt="subscriptions">
        <div class="media-body d-flex flex-column">
            <a href="{{asset('contracts')}}" class="mt-3 sidebar-link resizable-text" style="font-size: larger; font-weight:bold"> Contracten </a>
        </div>
    </div>
    <div class="ms-4 d-flex flex-column overflow-hidden">
        <a href="{{asset('contracts')}}" class="mb-1 sidebar-link resizable-text">Overzicht</a>
        <a href="{{route('contracts.index', ['mode' => 'edit']) }}" class="mb-1 sidebar-link resizable-text">Bijwerken</a>
        <a href="{{asset('contracts/create') }}" class="mb-1 sidebar-link resizable-text">Toevoegen</a>
    </div>
</div>
</html>

