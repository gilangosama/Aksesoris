# Legal Pages & Terms Setup Guide

## ✅ Setup Complete

Sistem untuk mengelola Syarat & Ketentuan, Kebijakan Privasi, dan Kebijakan Lainnya sudah diimplementasikan.

---

## 📁 Struktur Files

```
app/
  Models/
    └── LegalPage.php              # Model untuk legal pages
  Http/
    Controllers/
      └── LegalPageController.php  # Controller untuk display
  Filament/
    Resources/
      └── LegalPageResource.php    # Admin panel resource

database/
  migrations/
    └── 2026_01_13_134446_create_legal_pages_table.php
  seeders/
    └── LegalPageSeeder.php        # Default legal content

resources/
  views/
    pages/
      └── legal.blade.php          # Template untuk tampilan legal page
    components/
      └── footer.blade.php         # Footer dengan legal links

routes/
  └── web.php                      # Route untuk legal pages
```

---

## 🎯 Fitur Utama

### 1. **Dynamic Content Management**
- Semua syarat & ketentuan bisa di-edit dari admin panel Filament
- Tidak perlu deploy ulang saat update legal pages
- Support markdown/HTML via RichEditor

### 2. **Admin Panel Integration**
- Menu: Settings → Legal Pages
- CRUD lengkap: Create, Read, Update, Delete
- Filter & search by slug/title
- Toggle active/inactive

### 3. **Public Pages**
- Route: `/{slug}` (e.g., `/terms`, `/privacy`, `/refund-policy`, `/shipping`)
- Auto-generated breadcrumb
- Related policies sidebar
- Last updated timestamp

### 4. **Footer Navigation**
- Auto-populate links ke semua active legal pages
- Responsive design
- Social media links placeholder

---

## 📋 Available Pages

| Slug | Title | Status |
|------|-------|--------|
| `terms` | Terms & Conditions | ✅ Active |
| `privacy` | Privacy Policy | ✅ Active |
| `refund-policy` | Refund & Return Policy | ✅ Active |
| `shipping` | Shipping Policy | ✅ Active |

---

## 🔧 Cara Menggunakan

### **Di Admin Panel**

1. Go to: `https://yourdomain.com/admin`
2. Sidebar → Settings → Legal Pages
3. Click "Create" untuk tambah page baru
4. Isi:
   - **Slug**: `terms` (unique, untuk URL)
   - **Title**: `Terms & Conditions`
   - **Content**: Editor dengan formatting options
   - **Is Active**: Toggle untuk publish/hide

### **Di Public Website**

Akses pages:
- `https://yourdomain.com/terms`
- `https://yourdomain.com/privacy`
- `https://yourdomain.com/refund-policy`
- `https://yourdomain.com/shipping`

Links tersedia di footer.

---

## 📝 Customize Content

Default content sudah disediakan di seeder. Untuk customize:

**Edit di admin panel:**
1. Login ke admin
2. Pilih page yang ingin diedit
3. Klik "Edit"
4. Update content
5. Save

**Atau edit seeder** (sebelum deploy):
```php
// database/seeders/LegalPageSeeder.php
$legalPages = [
    [
        'slug' => 'terms',
        'title' => 'Terms & Conditions',
        'content' => '...HTML content here...',
        'is_active' => true,
    ],
    // Tambah page baru...
];
```

Lalu run:
```bash
php artisan db:seed --class=LegalPageSeeder
```

---

## 🎨 Styling

View menggunakan:
- **Tailwind CSS** untuk responsive design
- **Prose classes** untuk formatting artikel
- **Custom colors**: `blush-*`, `charcoal`

Bisa customize di: `resources/views/pages/legal.blade.php`

---

## 🚀 Production Checklist

- [x] Model & Migration created
- [x] Filament Resource integrated
- [x] Routes configured
- [x] Views created
- [x] Footer component updated
- [x] Default content seeded
- [ ] Update email address di footer
- [ ] Update social media links
- [ ] Add more legal pages jika diperlukan
- [ ] Test all links working
- [ ] Add to sitemap (jika pakai)

---

## 🔒 Security Notes

✅ **Protected:**
- Only active pages ditampilkan ke public
- Controller checks `is_active` sebelum render
- Filament resource protected dengan auth (admin only)

---

## 📧 Untuk Email Marketing/Contact

Ubah email di footer:
```blade
Email: <a href="mailto:info@aksesoris.com">info@aksesoris.com</a>
```

Edit di: `resources/views/components/footer.blade.php`

---

## 🎁 Next Steps

1. **Add more pages:** Buat page baru dari admin (e.g., FAQ, Warranty, Contact)
2. **Add to header navigation:** Link ke Terms di header navigation
3. **Schema markup:** Add `@context` untuk SEO jika diperlukan
4. **Analytics tracking:** Add GA tracking ke legal pages

---

**Status:** ✅ **Ready for Production**

