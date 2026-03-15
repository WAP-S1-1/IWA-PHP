@extends('layouts.app')

@section('title', 'Monitoring weerstations')
@section('header', 'All weatherstations')

@section('content')
    <style>
        main {
            background-image: linear-gradient(to bottom, midnightblue, darkblue) !important;
            padding: 0 !important;
        }

        .card {
            background-color: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .header {
            height: fit-content;
            background-color: cornflowerblue;
            margin-left: 5%;
            margin-right: 5%;
            border: solid white 5px;
            border-bottom: 0px;
            margin-bottom: 0;
        }

        .header h1 {
            text-align: center;
            padding-top: 20px;
            padding-bottom: 20px;
            color: white;
            margin-block-end: 0px;
            margin-block-start: 0px;
        }

        .content {
            display: grid;
            grid-template-columns: auto auto auto auto;
            column-gap: 5px;
            row-gap: 5px;
            background-color: white;
            margin-left: 5%;
            margin-right: 5%;
            margin-bottom: 5%;
            padding: 5px;
            height: fit-content;
        }

        .content div {
            height: auto;
            width: auto;
            min-width: 200px;
            background-color: aliceblue;
            border: solid black 3px;
            padding: 5px;
            border-radius: 10px;
            transition: 500ms;
        }

        .content div:hover {
            box-shadow: 0px 0px 5px 3px cornflowerblue;
            border: solid cornflowerblue 3px;
        }

        .name {
            margin-block-end: 0px;
            margin-block-start: 0px;
            padding: 10px;
            font-weight: bold;
            font-size: 20px;
            text-align: center;
            text-decoration-line: underline;
            width: auto;
        }

        .content p {
            margin-block-end: 0px;
            margin-block-start: 0px;
            width: auto;
            padding: 5px;
            border: solid black 1px;
            margin-top: 5px;
            border-radius: 5px;
        }

        .data {
            float: right;
        }
    </style>

    <div class="header">
        <h1>All weatherstations</h1>
    </div>
    <div class="content">
        <div>
            <h2 class="name">Station name</h2>
            <p>Country <span class="data">Nederland</span></p>
            <p>City <span class="data">Groningen</span></p>
            <p>Longitude <span class="data">6.5665</span></p>
            <p>Latitude <span class="data">53.2194</span></p>
            <p>Elevation <span class="data">7</span></p>
        </div>
        <div>
            <h2 class="name">Station name</h2>
            <p>Country <span class="data">Nederland</span></p>
            <p>City <span class="data">Enschede</span></p>
            <p>Longitude <span class="data">6.8937</span></p>
            <p>Latitude <span class="data">52.2215</span></p>
            <p>Elevation <span class="data">42</span></p>
        </div>
        <div>
            <h2 class="name">Station name</h2>
            <p>Country</p>
            <p>City</p>
            <p>Longitude</p>
            <p>Latitude</p>
            <p>Elevation</p>
        </div>
        <div>
            <h2 class="name">Station name</h2>
            <p>Country</p>
            <p>City</p>
            <p>Longitude</p>
            <p>Latitude</p>
            <p>Elevation</p>
        </div>
        <div>
            <h2 class="name">Station name</h2>
            <p>Country</p>
            <p>City</p>
            <p>Longitude</p>
            <p>Latitude</p>
            <p>Elevation</p>
        </div>
    </div>
@endsection
