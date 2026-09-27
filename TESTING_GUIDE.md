# 🧪 TESTING GUIDE - Address & Phone Feature

## Quick Start Testing

### Prerequisites
- Application running (`php artisan serve`)
- Database migrated (`php artisan migrate` ✅)
- Authentication system working

---

## ✅ Test Case 1: New User Auto-Save Address on Checkout

### Setup
1. Clear your browser cookies or use incognito mode
2. Go to application home page

### Steps
1. Add item to cart
2. Click "Checkout"
3. If not logged in → Register new account
4. Fill checkout form:
   ```
   Full Name: John Doe
   Email: john@example.com
   Phone: 08123456789
   Address: Jl. Sudirman No. 123, Jakarta
   ```
5. Click "Complete Payment"
6. Proceed with Midtrans payment (sandbox)

### Verification
```sql
-- Check if address was saved (in database)
SELECT * FROM addresses WHERE user_id = [user_id];
-- Should show 1 record with address & phone

-- Check if order was created with address info
SELECT order_id, customer_phone, address FROM orders 
WHERE user_id = [user_id] ORDER BY created_at DESC LIMIT 1;
-- Should show order with customer_phone & address
```

### Expected Result
✅ Order created successfully
✅ Address saved in `addresses` table
✅ Customer phone saved in `orders.customer_phone`

---

## ✅ Test Case 2: Existing User with Addresses - Checkout

### Setup
1. Login with existing account (or use account from Test 1)
2. Ensure account has at least 1 address

### Steps
1. Go to cart (add items if needed)
2. Click "Checkout"
3. See address dropdown/radio buttons:
   ```
   ☑ Jl. Sudirman No. 123 (Default)
      Phone: 08123456789
   
   ○ [Add New Address]
   ```
4. Select existing address
5. Phone number auto-fills from selected address
6. Click "Complete Payment"
7. Complete Midtrans payment

### Verification
```sql
-- Verify order has address_id
SELECT order_id, address_id, customer_phone FROM orders 
WHERE user_id = [user_id] ORDER BY created_at DESC LIMIT 1;
-- Should show: address_id = [id], customer_phone = [phone]

-- Verify address linked to order
SELECT o.order_id, a.address, a.phone 
FROM orders o
JOIN addresses a ON o.address_id = a.id
WHERE o.user_id = [user_id]
ORDER BY o.created_at DESC LIMIT 1;
```

### Expected Result
✅ Order shows `address_id` (not NULL)
✅ Address linked correctly via foreign key
✅ Phone number from address is saved

---

## ✅ Test Case 3: Add New Address During Checkout

### Setup
1. Login with account that has addresses
2. Go to checkout

### Steps
1. Click "+ Add New Address" link
2. Form appears with fields:
   - Address (textarea)
   - Phone (input)
3. Fill form:
   ```
   Address: Jl. Ahmad Yani No. 456
   Phone: 08987654321
   ```
4. Click "Save Address" button
5. Page should reload showing new address in list
6. Select new address from list
7. Complete payment

### Verification
```sql
-- Check if new address was created
SELECT COUNT(*) FROM addresses WHERE user_id = [user_id];
-- Count should increase by 1

-- Verify new address details
SELECT * FROM addresses WHERE user_id = [user_id] 
ORDER BY created_at DESC LIMIT 1;
-- Should show new address with correct phone
```

### Expected Result
✅ New address saved without page navigation
✅ Address appears in dropdown immediately after save
✅ Can select new address for checkout
✅ Order creates with correct `address_id`

---

## ✅ Test Case 4: Manage Addresses in Profile

### Setup
1. Login with account
2. Navigate to `/profile` or click "Profile" in navigation

### Steps

#### 4.1 View Addresses
1. Scroll to "Manage Addresses" section
2. See list of all addresses with:
   - Address text
   - Phone number
   - "Default" badge on default address
   - Action buttons: Edit, Delete, Set Default

#### 4.2 Add New Address
1. Click "+ Add New Address" button
2. Form appears:
   ```
   Address: Jl. Gatot Subroto...
   Phone: 08111111111
   [Save Address] [Cancel]
   ```
3. Fill and click "Save Address"
4. Page reloads, new address appears in list
5. Verify new address visible in list

#### 4.3 Edit Address
1. Click "Edit" button on any address
2. Form loads with current values:
   ```
   Address: Jl. Gatot Subroto...
   Phone: 08111111111
   [Update Address] [Cancel]
   ```
3. Modify values (e.g., phone number)
4. Click "Update Address"
5. Page reloads, changes applied
6. Verify modified data in list

#### 4.4 Set Default Address
1. Select an address that's NOT default
2. Click "Set Default" button
3. Page reloads
4. Verify:
   - Previous default loses "Default" badge
   - New address shows "Default" badge

#### 4.5 Delete Address
1. Click "Delete" button on any address
2. Confirmation dialog appears: "Are you sure..."
3. Click "OK" to confirm
4. Page reloads
5. Address removed from list

### Verification
```sql
-- View all addresses for user
SELECT id, address, phone, is_default 
FROM addresses WHERE user_id = [user_id];

-- Verify only one default address
SELECT COUNT(*) FROM addresses 
WHERE user_id = [user_id] AND is_default = 1;
-- Should return 1 (or 0 if no default set)

-- Check edit history (timestamps)
SELECT id, address, updated_at FROM addresses 
WHERE user_id = [user_id] ORDER BY updated_at DESC;
```

### Expected Result
✅ All CRUD operations work via AJAX
✅ No page refresh on add/edit/delete
✅ Only one address marked as default
✅ Changes reflect immediately in UI

---

## ✅ Test Case 5: Mobile Responsiveness

### Setup
1. Open application on mobile device or use browser dev tools
2. Set viewport to mobile (375px width)

### Steps
1. Go to Checkout page
2. Verify:
   - Address radio buttons stack vertically
   - Phone input displays correctly
   - Form labels are readable
   - Payment button is clickable

3. Go to Profile → Manage Addresses
4. Verify:
   - Address cards stack properly
   - Action buttons visible and clickable
   - Form inputs responsive

### Expected Result
✅ All elements readable and clickable on mobile
✅ No horizontal scrolling required
✅ Form submission works on mobile

---

## ✅ Test Case 6: Validation & Error Handling

### Setup
1. Login and go to Checkout OR Profile

### Steps

#### 6.1 Checkout Validation
1. Try to submit without filling phone:
   - Expected: Alert "Nomor telepon harus diisi"
2. Try to submit without selecting address:
   - Expected: Alert "Alamat pengiriman harus dipilih atau diisi"
3. Try to submit with empty address textarea:
   - Expected: Browser validation error

#### 6.2 Profile Validation
1. Try to add address without phone:
   - Expected: Required field validation
2. Try to add address with address > 500 chars:
   - Expected: Validation error message

### Expected Result
✅ All validations working
✅ User-friendly error messages
✅ No silent failures

---

## ✅ Test Case 7: Order Integration

### Setup
1. Complete checkout flow with address selection

### Steps
1. Check database:
   ```sql
   SELECT * FROM orders WHERE user_id = [id] ORDER BY created_at DESC LIMIT 1;
   ```
2. Verify order has:
   - `address_id` (not NULL if selected from list)
   - `customer_phone` (from selected address)
   - `address` (address text, either raw or from linked address)
   - `customer_name`, `customer_email`
   - `status` = 'completed' (after successful payment)

3. Go to profile → Transactions
4. Click on order to view details
5. Should show address information

### Expected Result
✅ Order links correctly to Address record
✅ Order displays correct address & phone info
✅ All information persisted correctly

---

## 🔍 Database State Verification

```sql
-- 1. Check addresses table structure
DESCRIBE addresses;
-- Columns: id, user_id, address, phone, is_default, created_at, updated_at

-- 2. Check users table has phone
DESCRIBE users;
-- Should see: phone VARCHAR(255) NULL

-- 3. Check orders table updates
DESCRIBE orders;
-- Should see: address_id BIGINT NULL, customer_phone VARCHAR(255) NULL

-- 4. Sample data check
SELECT u.id, u.name, u.phone, COUNT(a.id) as address_count
FROM users u
LEFT JOIN addresses a ON u.id = a.user_id
GROUP BY u.id
LIMIT 5;
```

---

## 🚨 Troubleshooting

### Issue: Routes not found (404)
```bash
# Clear route cache
php artisan route:clear
php artisan cache:clear

# Verify routes
php artisan route:list | Select-String "addresses"
```

### Issue: Database errors
```bash
# Run migrations again
php artisan migrate --force

# Check migration status
php artisan migrate:status
```

### Issue: AJAX requests failing
```javascript
// Check browser console for errors
// Verify CSRF token in form:
<input type="hidden" name="_token" value="{{ csrf_token() }}">

// Check network tab in DevTools
// Verify response status (should be 200 or JSON error)
```

### Issue: Address not saving
```bash
# Check user_id is correct
SELECT * FROM addresses WHERE user_id = [id];

# Check fillable in Address model
# Verify middleware auth is protecting routes
```

---

## 📊 Test Checklist

### Backend Tests
- [ ] Models created correctly (Address, User, Order)
- [ ] Migrations executed (2 migrations)
- [ ] Routes registered (5 address routes)
- [ ] Controller methods working (5 methods)
- [ ] Database relationships working
- [ ] CSRF protection active
- [ ] Auth middleware protecting endpoints

### Frontend Tests
- [ ] Checkout page displays addresses correctly
- [ ] Address selection dropdown works
- [ ] Phone auto-fills when selecting address
- [ ] Add address modal works
- [ ] Profile page loads manage-addresses component
- [ ] AJAX operations work without page reload
- [ ] Validation messages display
- [ ] Mobile responsive

### Integration Tests
- [ ] New user flow: register → enter address → auto-save
- [ ] Existing user flow: select address → checkout → order created
- [ ] Edit address works
- [ ] Delete address works
- [ ] Set default address works
- [ ] Order contains correct address_id
- [ ] Order contains correct customer_phone

### Security Tests
- [ ] Auth middleware prevents unauthorized access
- [ ] Users can only access/modify their own addresses
- [ ] CSRF token required for POST/PUT/DELETE
- [ ] Input validation working
- [ ] No SQL injection vulnerabilities

### Performance Tests
- [ ] Address list loads quickly
- [ ] AJAX requests complete in < 1 second
- [ ] No N+1 queries
- [ ] Database indexes working

---

## ✨ Success Criteria

All features are working correctly when:

1. ✅ New user can register and auto-save address during checkout
2. ✅ Existing user sees and can select from their addresses
3. ✅ User can add/edit/delete addresses in profile
4. ✅ Default address management working
5. ✅ Orders store correct address_id and customer_phone
6. ✅ All AJAX operations work smoothly
7. ✅ Mobile responsive design
8. ✅ Proper validation and error handling
9. ✅ Database integrity maintained
10. ✅ Security measures in place

---

**Status**: Ready for comprehensive testing! 🚀
