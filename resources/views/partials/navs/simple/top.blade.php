{{-- Simple Navigation --}}
<div class="collapse navbar-collapse" id="navbar-default">
    <ul class="navbar-nav @@navbarAuto">
        @foreach(Site::menuItems('simple') as $menuItem)
            @include('jiny-site::partials.navs.simple.menu-item', ['item' => $menuItem])
        @endforeach
    </ul>
</div>