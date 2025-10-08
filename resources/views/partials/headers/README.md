# Header System Documentation

## Available Headers

The application provides the following header options:

1. **default.blade.php** - Main site header with full navigation
2. **dashboard.blade.php** - Simple dashboard header
3. **dashboard-full.blade.php** - Full dashboard header with search and notifications
4. **landing.blade.php** - Landing page header with category dropdown
5. **landing-academy.blade.php** - Academy landing header with search

## How to Use

### Priority System (높은 순위 → 낮은 순위)

1. **@section('header')** - Custom header defined in the page
2. **$header variable** - Header type passed to @extends
3. **Default value** - Each layout's default header

### 1. Default Header
```blade
@extends('layouts.app')
```

### 2. Specify Different Header
```blade
@extends('layouts.app', ['header' => 'landing'])
@extends('layouts.dashboard', ['header' => 'dashboard'])
```

### 3. Custom Header Section
```blade
@section('header')
    <nav class="custom-navbar">
        <!-- Custom navigation -->
    </nav>
@endsection
```

### 4. No Header
```blade
@section('header')
    {{-- Empty section for no header --}}
@endsection
```

### 5. Dynamic Header from Controller
```php
// Controller
return view('page')->with('header', 'landing');

// View
@extends('layouts.app', ['header' => $header ?? 'default'])
```

## Layout Default Headers

Each layout has its own default header:

- `app.blade.php` → `default`
- `dashboard.blade.php` → `dashboard-full`
- `landing-academy.blade.php` → `landing-academy`
- `landing-job.blade.php` → `landing`
- `landing-simple.blade.php` → `landing`

## Creating Custom Headers

1. Create a new file in `/resources/views/partials/headers/`
2. Name it descriptively (e.g., `minimal.blade.php`)
3. Use it in your views:
```blade
@extends('layouts.app', ['header' => 'minimal'])
```

## Header Structure

Each header should be a complete navigation element:

```html
<nav class="navbar navbar-*">
    <div class="container">
        <!-- Navigation content -->
    </div>
</nav>
```

## Usage Examples

### Different headers for different pages
```blade
{{-- Home page with default header --}}
@extends('layouts.app')

{{-- About page with minimal header --}}
@extends('layouts.app', ['header' => 'minimal'])

{{-- Dashboard with dashboard header --}}
@extends('layouts.dashboard', ['header' => 'dashboard'])
```

### Conditional header based on authentication
```blade
@php
    $header = auth()->check() ? 'dashboard' : 'default';
@endphp

@extends('layouts.app', ['header' => $header])
```