@php
    $levelClass = 'level-' . $level;
@endphp

<div class="org-card {{ $levelClass }}">
    <div class="card border-0 shadow-sm">
        <!-- Organization Header -->
        <div class="card-header bg-white @if($organization->teamMembers->count() > 0) org-header-clickable @else org-header-non-clickable @endif"
             data-org-id="{{ $organization->id }}"
             @if($organization->teamMembers->count() > 0)
                style="cursor: pointer;"
                onclick="toggleTeamMembers({{ $organization->id }})"
             @else
                style="cursor: default;"
             @endif>
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-1">
                        @if($level > 0)
                            <i class="bi bi-arrow-return-right text-muted me-2"></i>
                        @endif
                        {{ $organization->name }}
                        @if($organization->code)
                            <small class="text-muted">({{ $organization->code }})</small>
                        @endif
                        @if($organization->teamMembers->count() > 0)
                            <i class="bi bi-chevron-down ms-2 toggle-icon" id="toggle-icon-{{ $organization->id }}"></i>
                        @endif
                    </h5>
                    @if($organization->description)
                        <p class="text-muted mb-0 small">{{ $organization->description }}</p>
                    @endif
                </div>
                <div class="col-auto">
                    <div class="d-flex align-items-center text-muted small">
                        @if($organization->teamMembers->count() > 0)
                            <span class="me-3">
                                <i class="bi bi-people me-1"></i>
                                {{ $organization->teamMembers->count() }} members
                            </span>
                            @if($organization->managers->count() > 0)
                                <span>
                                    <i class="bi bi-person-badge me-1"></i>
                                    {{ $organization->managers->count() }} managers
                                </span>
                            @endif
                        @else
                            <span class="text-muted fst-italic">
                                <i class="bi bi-people me-1"></i>
                                No team members
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Members -->
        @if($organization->teamMembers->count() > 0)
            <div class="card-body team-members-section" id="team-members-{{ $organization->id }}" style="display: none;">
                <div class="row g-3">
                    @foreach($organization->teamMembers->sortBy('sort_order') as $member)
                        <div class="col-lg-6">
                            <div class="member-card p-3 rounded border">
                                <div class="d-flex align-items-start">
                                    <!-- Avatar -->
                                    <div class="me-3">
                                        @if($member->avatar)
                                            <img src="{{ $member->avatar }}" alt="{{ $member->name }}" class="member-avatar">
                                        @else
                                            <div class="member-avatar bg-primary d-flex align-items-center justify-content-center text-white">
                                                {{ strtoupper(substr($member->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Member Info -->
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-1">
                                            <h6 class="mb-0 me-2">{{ $member->name }}</h6>
                                            @if($member->is_manager)
                                                <span class="badge manager-badge">Manager</span>
                                            @endif
                                        </div>

                                        <div class="text-primary fw-medium mb-1">{{ $member->position }}</div>

                                        @if($member->title)
                                            <div class="text-muted small mb-2">{{ $member->title }}</div>
                                        @endif

                                        @if($member->bio)
                                            <p class="text-muted small mb-2">{{ Str::limit($member->bio, 100) }}</p>
                                        @endif

                                        <!-- Contact Info -->
                                        @if($member->email || $member->phone)
                                            <div class="small mb-2">
                                                @if($member->email)
                                                    <div>
                                                        <i class="bi bi-envelope me-1"></i>
                                                        <a href="mailto:{{ $member->email }}" class="text-decoration-none">{{ $member->email }}</a>
                                                    </div>
                                                @endif
                                                @if($member->phone)
                                                    <div>
                                                        <i class="bi bi-telephone me-1"></i>
                                                        <a href="tel:{{ $member->phone }}" class="text-decoration-none">{{ $member->phone }}</a>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif

                                        <!-- Specialties -->
                                        @if($member->specialties && count($member->specialties) > 0)
                                            <div class="mb-2">
                                                @foreach($member->specialties as $specialty)
                                                    <span class="badge bg-light text-dark specialty-badge me-1">{{ $specialty }}</span>
                                                @endforeach
                                            </div>
                                        @endif

                                        <!-- Years of Service -->
                                        @if($member->join_date)
                                            <div class="text-muted small">
                                                <i class="bi bi-calendar me-1"></i>
                                                Joined {{ $member->join_date->format('M Y') }}
                                                @if($member->years_of_service)
                                                    ({{ $member->years_of_service }} {{ Str::plural('year', $member->years_of_service) }})
                                                @endif
                                            </div>
                                        @endif

                                        <!-- LinkedIn -->
                                        @if($member->linkedin)
                                            <div class="mt-2">
                                                <a href="{{ $member->linkedin }}" target="_blank" class="text-decoration-none small">
                                                    <i class="bi bi-linkedin text-primary me-1"></i>
                                                    LinkedIn Profile
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Contact Info -->
        @if($organization->contact_email || $organization->contact_phone)
            <div class="card-footer bg-light contact-info-section" id="contact-info-{{ $organization->id }}" style="display: none;">
                <div class="small text-muted">
                    <strong>Department Contact:</strong>
                    @if($organization->contact_email)
                        <a href="mailto:{{ $organization->contact_email }}" class="text-decoration-none me-3">
                            <i class="bi bi-envelope me-1"></i>{{ $organization->contact_email }}
                        </a>
                    @endif
                    @if($organization->contact_phone)
                        <a href="tel:{{ $organization->contact_phone }}" class="text-decoration-none">
                            <i class="bi bi-telephone me-1"></i>{{ $organization->contact_phone }}
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Recursively render child organizations -->
@if($organization->allChildren && $organization->allChildren->count() > 0)
    @foreach($organization->allChildren->sortBy('sort_order') as $childOrganization)
        @include('jiny-site::www.about.organization.partials.organization-card', [
            'organization' => $childOrganization,
            'level' => $level + 1
        ])
    @endforeach
@endif