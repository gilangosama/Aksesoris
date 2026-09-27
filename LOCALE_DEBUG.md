# 🔧 Debugging Locale Switching

## Test Steps

1. **Check current locale**
   - Visit: `http://localhost:8000/debug/locale`
   - Expected response (JSON):
     ```json
     {
       "session_locale": null,
       "app_locale": "id",
       "config_default": "id",
       "all_session": {...}
     }
     ```

2. **Click language switcher in navbar**
   - Desktop: dropdown button (In/En)
   - Select "English"
   - Should redirect back to current page

3. **Check locale again**
   - Visit: `http://localhost:8000/debug/locale`
   - Expected response:
     ```json
     {
       "session_locale": "en",
       "app_locale": "en",
       "config_default": "id",
       "all_session": {..., "locale": "en"}
     }
     ```

4. **Check navbar labels**
   - Products → Products (English)
   - Products → Produk (Indonesian)

## Flow

1. User clicks language button → `/locale/en`
2. Route sets session `locale` → `en`
3. Redirect to referer page (same page)
4. Middleware `SetLocale` runs → `App::setLocale('en')`
5. Views get `{{ __('navigation.products') }}` → translated to English

## Files Modified

- `bootstrap/app.php` - Registered SetLocale middleware
- `routes/web.php` - Added locale switch route + debug endpoint
- `app/Http/Middleware/SetLocale.php` - Sets locale from session
- `app/Providers/AppServiceProvider.php` - Removed early boot logic
- `resources/views/layouts/navigation.blade.php` - Localized all labels

## Logs

Check `storage/logs/laravel.log` for debug info:
- Search for "SetLocale middleware"
- Search for "Locale switched"
