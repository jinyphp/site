# Footer System Documentation

## Available Footers

The application provides 4 footer options:

1. **dark.blade.php** - Dark footer with full content (default)
2. **light.blade.php** - Light/colored footer
3. **white.blade.php** - White background footer
4. **simple.blade.php** - Minimal footer with basic info

## How to Use

### 1. Default Footer (Dark)
```blade
@extends('layouts.app')
```

### 2. Specify Different Footer
```blade
@extends('layouts.app', ['footer' => 'white'])
@extends('layouts.app', ['footer' => 'simple'])
@extends('layouts.app', ['footer' => 'light'])
```

### 3. No Footer
```blade
@extends('layouts.app', ['footer' => false])
```

### 4. Dynamic Footer from Controller
```php
// Controller
return view('page')->with('footer', 'light');

// View
@extends('layouts.app', ['footer' => $footer ?? 'dark'])
```

### 5. Conditional Footer
```blade
@php
    $footer = auth()->check() ? 'white' : 'dark';
@endphp

@extends('layouts.app', ['footer' => $footer])
```

## Creating Custom Footers

1. Create a new file in `/resources/views/partials/footers/`
2. Name it descriptively (e.g., `minimal.blade.php`)
3. Use it in your views:
```blade
@extends('layouts.app', ['footer' => 'minimal'])
```

## Footer Structure

Each footer should be a complete `<footer>` element:

```html
<footer class="footer bg-*">
    <div class="container">
        <!-- Footer content -->
    </div>
</footer>
```