<html>
<style>
    .sidebar-link{
        text-decoration:none;
        color:black;
    }
    .sidebar-link:hover{color:#B20A0E}
</style>
<div class="card shadow-lg m-2 rounded-5"
     style="width:30vw;height:80vh; background-color:rgba(255,255,255,0.7)">
    <div class="d-flex align-items-start">
        <img class="align-self-start my-3" style="height:75px" src="{{asset('placeholderprofile')}}" alt="profile">
        <div class="media-body">
            <p class="my-3 e-4 align-self-baseline">#123435</p>
            <b class="y-3 align-self-baseline" style="font-size: larger"> User Name </b>
        </div>
    </div>
    <hr style="width:80%; margin-right:auto; margin-left: auto">
    <div class="d-flex align-items-start  align-middle">
        <img class="align-self-start m-3" style="height:50px" src="{{asset('company.svg')}}" alt="companies">
        <div class="media-body d-flex flex-column">
            <a href="{{asset('companies')}}" class="mt-3 sidebar-link" style="font-size: larger;font-weight:bold"> Bedrijven </a>
        </div>
    </div>
    <div class="ms-4 d-flex flex-column">
        <a href="{{asset('companies')}}" class="mb-1 sidebar-link">Overzicht</a>
        <a class="mb-1 sidebar-link">Bijwerken</a>
        <a class="mb-1 sidebar-link">Toevoegen</a>
    </div>
    <div class="d-flex align-items-start align-middle">
        <img class="align-self-start m-3" style="height:50px" src="{{asset('subscription.svg')}}" alt="companies">
        <div class="media-body d-flex flex-column">
            <a href="{{asset('subscription')}}" class="mt-3 sidebar-link" style="font-size: larger; font-weight:bold"> Abonnementen </a>
        </div>
    </div>
    <div class="ms-4 d-flex flex-column">
        <a href="{{asset('subscription')}}" class="mb-1 sidebar-link">Overzicht</a>
        <a href="/" class="mb-1 sidebar-link">Bijwerken</a>
        <a href="/" class="mb-1 sidebar-link">Toevoegen</a>
    </div>
</div>
</html>

