
fetch("/api/stations")
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
            const col = document.createElement("div");
            col.classList.add("col-auto");
            const card = document.createElement("div");
            card.classList.add("card", "stations-card");

            card.innerHTML = `
        <div class="card-body p-3">
            <h2 class="name">Station ${station.name}</h2>
            <hr>
            <p>
                <img src="/location.svg" class="me-2" style="width:40px; vertical-align:middle;">
                ${station.geolocations?.[0]?.country ?? 'Country'}, ${station.geolocations?.[0]?.city ?? 'City'}
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
