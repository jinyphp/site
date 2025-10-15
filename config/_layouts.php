<?php

return [
    [
        'layout_key' => 'jiny-site::layouts.app',
        'name' => 'App Layout',
        'description' => 'Main application layout',
        'header' => 'jiny-site::components.header.app',
        'footer' => 'jiny-site::components.footer.app',
        'sidebar' => null,
    ],
    [
        'layout_key' => 'jiny-site::layouts.about',
        'name' => 'About Layout',
        'description' => 'About page layout',
        'header' => 'jiny-site::components.header.about',
        'footer' => 'jiny-site::components.footer.default',
        'sidebar' => 'jiny-site::components.sidebar.about',
    ],
    [
        'layout_key' => 'jiny-site::layouts.home',
        'name' => 'Home Layout',
        'description' => 'Homepage layout',
        'header' => 'jiny-site::components.header.home',
        'footer' => 'jiny-site::components.footer.home',
        'sidebar' => null,
    ],
    [
        'layout_key' => 'jiny-site::layouts.admin',
        'name' => 'Admin Layout',
        'description' => 'Admin dashboard layout',
        'header' => 'jiny-site::components.header.admin',
        'footer' => 'jiny-site::components.footer.admin',
        'sidebar' => 'jiny-site::components.sidebar.admin',
    ],
    [
        'layout_key' => 'jiny-site::layouts.admin.sidebar',
        'name' => 'Admin Sidebar Layout',
        'description' => 'Admin layout with sidebar',
        'header' => 'jiny-site::components.header.admin',
        'footer' => 'jiny-site::components.footer.admin',
        'sidebar' => 'jiny-site::components.sidebar.admin',
    ],
];