@extends('layouts.app')

@section('title', 'Monitoring weerstations')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('background-sky.jpg');
        }
        .stations-card{
            width: 18rem;
            margin: 1rem;
            border-radius: 0.5rem;
            min-height: 260px;
            max-height: 300px;
            overflow: hidden;
        }
        #stations-scroll {
            max-height: 100%;
            overflow-y: auto;
        }
        .location-text {
            display: inline-block;
            max-width: 10rem;
            word-wrap: break-word;
            word-break: break-word;
            overflow: hidden;
        }
        h2{text-align:center; color:#294B71;padding-top: 21px}
        h1{text-align:center; color:white;padding-top: 21px}
        p{font-weight: bold; color:#294B71 }
    </style>
</head>
<body>
<div class="card shadow-lg mx-auto mt-5 align-items-center rounded-top-4" style="width:1600px;height:100px;background-color:#262626;">
    <h1>All weatherstations</h1>
</div>
<div class="card shadow-lg p-4 mx-auto align-items-center rounded-bottom-4"
     style="width:1600px;height:700px; background-color:rgba(255,255,255,0.5)">
    <div class="w-100" id="stations-scroll">
        <div class="row p-4 g-4 justify-content-center" id="stations-container">
        </div>
    </div>
</div>
<script>
    fetch("stations.json")
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById("stations-container");
            if (!container) {
                console.error("No element with id 'stations-container' found");
                return;
            }
            if (!data.stations || !Array.isArray(data.stations)) {
                console.error("Expected data.stations to be an array", data);
                return;
            }

            data.stations.forEach(station => {
                const firstGeo = station.geolocations && station.geolocations[0]
                    ? station.geolocations[0]
                    : null;
                const country = firstGeo && firstGeo.country
                    ? firstGeo.country
                    : 'Country';
                const city = firstGeo && firstGeo.city
                    ? firstGeo.city
                    : 'City';

                const col = document.createElement("div");
                col.classList.add("col-auto");
                const card = document.createElement("div");
                card.classList.add("card", "stations-card");

                card.innerHTML = `
        <div class="card-body p-3">
            <h2 class="name">Station ${station.name}</h2>
            <hr>
            <p>
                <img src="location.svg" class="me-2" style="width:40px; vertical-align:middle;">
                <span class="location-text">${country}, ${city}</span>
            </p>
            <p>Longitude ${station.longitude ?? ''}</p>
            <p>Latitude ${station.latitude ?? ''}</p>
            <p>Elevation ${station.elevation ?? ''} m</p>
        </div>
    `;
                col.appendChild(card);
                container.appendChild(col);
            });
        })
        .catch(error => {
            console.error("Error loading stations.json:", error);
        });
</script>
@endsection
