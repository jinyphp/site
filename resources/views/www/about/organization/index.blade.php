@extends($layout ?? 'jiny-site::layouts.about')

@section('content')
    <main>
        <!-- Page Header -->
        <section class="bg-primary py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center">
                        <h1 class="display-4 text-white">{{ $config['title'] ?? 'Our Organization' }}</h1>
                        <p class="lead text-white mb-0">{{ $config['subtitle'] ?? 'Meet our team and organizational structure' }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Organization Statistics -->
        <section class="py-4 bg-light">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-diagram-3 text-primary me-2" style="font-size: 1.5rem;"></i>
                            <div>
                                <h5 class="mb-0">{{ $totalOrganizations }}</h5>
                                <small class="text-muted">Departments</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-people text-primary me-2" style="font-size: 1.5rem;"></i>
                            <div>
                                <h5 class="mb-0">{{ $totalMembers }}</h5>
                                <small class="text-muted">Team Members</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-badge text-primary me-2" style="font-size: 1.5rem;"></i>
                            <div>
                                <h5 class="mb-0">{{ $totalManagers }}</h5>
                                <small class="text-muted">Managers</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Organization Tree -->
        <section class="py-5">
            <div class="container">
                @if($organizations->count() > 0)
                    <!-- Usage Hint and Controls -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="organization-hint">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>How to use:</strong> Click on any organization to view team members and contact information.
                                Use <kbd>Ctrl+E</kbd> to expand all or <kbd>Ctrl+C</kbd> to collapse all.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-primary btn-sm" onclick="toggleAllOrganizations(true)">
                                    <i class="bi bi-arrows-expand me-1"></i>Expand All
                                </button>
                                <button class="btn btn-outline-secondary btn-sm" onclick="toggleAllOrganizations(false)">
                                    <i class="bi bi-arrows-collapse me-1"></i>Collapse All
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Organization Cards -->
                    @foreach($organizations as $organization)
                        @include('jiny-site::www.about.organization.partials.organization-card', ['organization' => $organization, 'level' => 0])
                    @endforeach
                @else
                    <!-- Empty State -->
                    <div class="row">
                        <div class="col-lg-8 mx-auto text-center py-5">
                            <i class="bi bi-diagram-3 display-1 text-muted"></i>
                            <h3 class="mt-4 text-muted">No Organization Data Available</h3>
                            <p class="text-muted">We'll be adding organizational information soon. Please check back later.</p>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <!-- Custom Styles for Organization Tree -->
    <style>
        .org-card {
            border-left: 4px solid var(--bs-primary);
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .org-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .org-card.level-1 {
            margin-left: 2rem;
            border-left-color: var(--bs-secondary);
        }

        .org-card.level-2 {
            margin-left: 4rem;
            border-left-color: var(--bs-info);
        }

        .org-card.level-3 {
            margin-left: 6rem;
            border-left-color: var(--bs-warning);
        }

        .org-header-clickable {
            transition: background-color 0.2s ease;
        }

        .org-header-clickable:hover {
            background-color: #f8f9fa !important;
        }

        .org-header-non-clickable {
            opacity: 0.8;
        }

        .org-header-non-clickable h5 {
            color: #6c757d;
        }

        .toggle-icon {
            transition: transform 0.3s ease;
            font-size: 0.8rem;
        }

        .toggle-icon.rotated {
            transform: rotate(180deg);
        }

        .team-members-section, .contact-info-section {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                max-height: 0;
                overflow: hidden;
            }
            to {
                opacity: 1;
                max-height: 1000px;
                overflow: visible;
            }
        }

        .member-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .member-card {
            transition: all 0.2s ease;
        }

        .member-card:hover {
            background-color: var(--bs-light);
        }

        .specialty-badge {
            font-size: 0.75rem;
        }

        .manager-badge {
            background: linear-gradient(45deg, var(--bs-warning), var(--bs-orange, #fd7e14));
            color: white;
        }

        .organization-hint {
            color: #6c757d;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
            padding: 0.75rem 1rem;
            background-color: #f8f9fa;
            border-radius: 0.375rem;
            border-left: 3px solid var(--bs-primary);
        }
    </style>

    <!-- JavaScript for Toggle Functionality -->
    <script>
        function toggleTeamMembers(orgId) {
            const teamMembersSection = document.getElementById('team-members-' + orgId);
            const contactInfoSection = document.getElementById('contact-info-' + orgId);
            const toggleIcon = document.getElementById('toggle-icon-' + orgId);

            if (teamMembersSection) {
                const isVisible = teamMembersSection.style.display !== 'none';

                if (isVisible) {
                    // Hide sections
                    teamMembersSection.style.display = 'none';
                    if (contactInfoSection) {
                        contactInfoSection.style.display = 'none';
                    }
                    if (toggleIcon) {
                        toggleIcon.classList.remove('rotated');
                    }
                } else {
                    // Show sections
                    teamMembersSection.style.display = 'block';
                    if (contactInfoSection) {
                        contactInfoSection.style.display = 'block';
                    }
                    if (toggleIcon) {
                        toggleIcon.classList.add('rotated');
                    }
                }
            }
        }

        // Add expand all / collapse all functionality
        function toggleAllOrganizations(expand = true) {
            const allTeamSections = document.querySelectorAll('.team-members-section');
            const allContactSections = document.querySelectorAll('.contact-info-section');
            const allToggleIcons = document.querySelectorAll('.toggle-icon');

            allTeamSections.forEach(section => {
                section.style.display = expand ? 'block' : 'none';
            });

            allContactSections.forEach(section => {
                section.style.display = expand ? 'block' : 'none';
            });

            allToggleIcons.forEach(icon => {
                if (expand) {
                    icon.classList.add('rotated');
                } else {
                    icon.classList.remove('rotated');
                }
            });
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listeners for keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey || e.metaKey) {
                    if (e.key === 'e' || e.key === 'E') {
                        e.preventDefault();
                        toggleAllOrganizations(true);
                    } else if (e.key === 'c' || e.key === 'C') {
                        e.preventDefault();
                        toggleAllOrganizations(false);
                    }
                }
            });
        });
    </script>
@endsection