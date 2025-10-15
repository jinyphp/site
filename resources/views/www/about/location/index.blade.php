@extends($layout ?? 'jiny-site::layouts.about')

@section('content')
    <main>
        <!-- Page Header -->
        <section class="bg-primary py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center">
                        <h1 class="display-4 text-white">{{ $config['title'] ?? 'Our Locations' }}</h1>
                        <p class="lead text-white mb-0">{{ $config['subtitle'] ?? 'Find us at these locations' }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Locations Section -->
        <section class="py-5">
            <div class="container">
                @php
                    $hasCoordinates = $locations->filter(function($location) {
                        return !empty($location->latitude) && !empty($location->longitude);
                    });
                @endphp

                @if($locations->count() > 0)
                    <div class="row g-4">
                        @foreach($locations as $location)
                            <div class="col-lg-6 col-xl-4">
                                <div class="card h-100 shadow-sm border-0">
                                    @if($location->image)
                                        <img src="{{ $location->image }}" class="card-img-top" alt="{{ $location->title }}" style="height: 200px; object-fit: cover;">
                                    @endif

                                    <div class="card-body">
                                        <h5 class="card-title">{{ $location->title }}</h5>

                                        @if($location->description)
                                            <p class="card-text text-muted">{{ $location->description }}</p>
                                        @endif

                                        <!-- Address -->
                                        @if($location->address || $location->city || $location->country)
                                            <div class="mb-3">
                                                <h6 class="text-primary mb-2">
                                                    <i class="bi bi-geo-alt me-2"></i>Address
                                                </h6>
                                                <address class="mb-0">
                                                    @if($location->address)
                                                        {{ $location->address }}<br>
                                                    @endif
                                                    @if($location->city || $location->state)
                                                        {{ $location->city }}@if($location->city && $location->state), @endif{{ $location->state }}
                                                        @if($location->postal_code) {{ $location->postal_code }}@endif<br>
                                                    @endif
                                                    @if($location->country)
                                                        {{ $location->country }}
                                                    @endif
                                                </address>
                                            </div>
                                        @endif

                                        <!-- Contact Info -->
                                        @if($location->phone || $location->email)
                                            <div class="mb-3">
                                                <h6 class="text-primary mb-2">
                                                    <i class="bi bi-telephone me-2"></i>Contact
                                                </h6>
                                                @if($location->phone)
                                                    <div class="mb-1">
                                                        <i class="bi bi-phone me-2"></i>
                                                        <a href="tel:{{ $location->phone }}" class="text-decoration-none">{{ $location->phone }}</a>
                                                    </div>
                                                @endif
                                                @if($location->email)
                                                    <div>
                                                        <i class="bi bi-envelope me-2"></i>
                                                        <a href="mailto:{{ $location->email }}" class="text-decoration-none">{{ $location->email }}</a>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif

                                        <!-- Map Link -->
                                        @if($location->latitude && $location->longitude)
                                            <div class="d-grid">
                                                <a href="https://www.google.com/maps?q={{ $location->latitude }},{{ $location->longitude }}"
                                                   target="_blank"
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-map me-2"></i>View on Map
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Map Section -->
                    @if($hasCoordinates->count() > 0)
                        <div class="row mt-5">
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-white">
                                        <h5 class="mb-0">
                                            <i class="bi bi-map me-2"></i>All Locations Map
                                        </h5>
                                    </div>
                                    <div class="card-body p-0">
                                        <div id="map" style="height: 400px; width: 100%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="row">
                        <div class="col-lg-8 mx-auto text-center py-5">
                            <i class="bi bi-geo-alt display-1 text-muted"></i>
                            <h3 class="mt-4 text-muted">No Locations Available</h3>
                            <p class="text-muted">We'll be adding location information soon. Please check back later.</p>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>

    @if($hasCoordinates && $hasCoordinates->count() > 0)
        <!-- Google Maps Script -->
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap">
        </script>

        <script>
            function initMap() {
                // Initialize map
                const map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 10,
                    center: { lat: {{ $hasCoordinates->first()->latitude }}, lng: {{ $hasCoordinates->first()->longitude }} }
                });

                // Add markers for each location
                const locations = [
                    @foreach($hasCoordinates as $location)
                    {
                        lat: {{ $location->latitude }},
                        lng: {{ $location->longitude }},
                        title: "{{ addslashes($location->title) }}",
                        @if($location->address)
                        address: "{{ addslashes($location->address) }}",
                        @endif
                        @if($location->phone)
                        phone: "{{ addslashes($location->phone) }}",
                        @endif
                        @if($location->email)
                        email: "{{ addslashes($location->email) }}"
                        @endif
                    }@if(!$loop->last),@endif
                    @endforeach
                ];

                locations.forEach(location => {
                    const marker = new google.maps.Marker({
                        position: { lat: location.lat, lng: location.lng },
                        map: map,
                        title: location.title
                    });

                    let infoContent = `<div><h6>${location.title}</h6>`;
                    if (location.address) {
                        infoContent += `<p class="mb-1"><small>${location.address}</small></p>`;
                    }
                    if (location.phone) {
                        infoContent += `<p class="mb-1"><small><i class="bi bi-phone"></i> ${location.phone}</small></p>`;
                    }
                    if (location.email) {
                        infoContent += `<p class="mb-0"><small><i class="bi bi-envelope"></i> ${location.email}</small></p>`;
                    }
                    infoContent += `</div>`;

                    const infoWindow = new google.maps.InfoWindow({
                        content: infoContent
                    });

                    marker.addListener('click', () => {
                        infoWindow.open(map, marker);
                    });
                });

                // Adjust map bounds to show all markers
                if (locations.length > 1) {
                    const bounds = new google.maps.LatLngBounds();
                    locations.forEach(location => {
                        bounds.extend(new google.maps.LatLng(location.lat, location.lng));
                    });
                    map.fitBounds(bounds);
                }
            }
        </script>
    @endif

    <!-- Initialize tooltips -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endsection
