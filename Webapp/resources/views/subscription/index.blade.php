@extends('layouts.commercial')

@section('title', 'Startpagina')
@section('header', 'Startpagina')

@section('content')
    @parent

    <style>
        #subscriptions > .card {
            display: inline-block;
            vertical-align: top;
        }

    </style>

    <div class="card shadow-lg m-2 rounded-5"
         style="width:82%;height:700px; background-color:rgba(255,255,255,0.7)">
        <div class="row p-3">
            <div class="col-sm-2 m-5 d-flex flex-wrap gap-3">
                <p class="mb-0">ID</p>
                <p class="mb-0">Bedrijf</p>
                <hr class="w-100 my-0">
            </div>
            <div class="col-sm-2 m-5 d-flex flex-wrap gap-3">
                <p class="mb-0">Startdatum</p>
                <p class="mb-0">Einddatum</p>
                <hr class="w-100 my-0">
            </div>
            <div class="col-sm-5 m-5 d-flex flex-wrap gap-1" >
                <p class="mb-0">Abonnement</p>
                <p class="mb-0">Omschrijving </p>
                <p class="mb-0">Prijs</p>
                <p class="mb-0">Notities</p>
                <hr class="w-100 my-0">
            </div>
        </div>
        <div class="w-100">
            <div id="subscriptions-container" class="row p-5 g-4 justify-content-center"></div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const container = document.getElementById("subscriptions-container");
            if (!container) {
                console.error("Missing #subscriptions-container in DOM");
                return;
            }

            fetch("/api/subscriptions")
                .then(res => {
                    if (!res.ok) throw new Error(`HTTP ${res.status} on /api/subscriptions`);
                    return res.json();
                })
                .then(data => {
                    const subscriptions = Array.isArray(data) ? data : (data.subscriptions || []);

                    if (!subscriptions.length) {
                        container.innerHTML = '<p class="text-muted">Geen abonnementen gevonden.</p>';
                        return;
                    }

                    subscriptions.forEach(sub => {
                        const row = document.createElement("div");
                        row.classList.add("row", "subscription-row", "rounded-4", "mb-3", "p-3", "mx-0");

                        row.innerHTML = `
                            <div class="col-sm-2 m-5 d-flex flex-wrap gap-3">
                                <p class="mb-0">${sub.id ?? ""}</p>
                                <p class="mb-0">${sub.company_name ?? ""}</p>
                            </div>

                            <div class="col-sm-2 m-5 d-flex flex-wrap gap-3">
                                <p class="mb-0">${sub.start_date ?? ""}</p>
                                <p class="mb-0">${sub.end_date ?? "-"}</p>
                            </div>

                            <div class="col-sm-5 m-5 d-flex flex-wrap gap-1">
                                <p class="mb-0">${sub.type_name ?? ""}</p>
                                <p class="mb-0">${sub.description ?? ""}</p>
                                <p class="mb-0">€${sub.price ?? ""}</p>
                                <p class="mb-0">${sub.notes ?? "-"}</p>
                            </div>
                        `;

                        container.appendChild(row);
                    });
                })
                .catch(err => {
                    console.error("Subscriptions fetch failed:", err);
                    container.innerHTML = '<p class="text-danger">Laden van abonnementen is mislukt.</p>';
                });
        });
    </script>
@endsection

