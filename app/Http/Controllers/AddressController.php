<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AddressController extends Controller
{
    /**
     * Show user's addresses list
     */
    public function index()
    {
        $addresses = auth()->user()->addresses;
        return view('addresses.index', compact('addresses'));
    }

    /**
     * Store a new address
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'recipient_name' => 'required|string|max:100',
                'street' => 'required|string|max:500',
                'city' => 'required|string|max:100',
                'province' => 'required|string|max:100',
                'postal_code' => 'required|string|max:10',
                'phone' => 'required|string|max:20',
                'is_default' => 'sometimes|boolean',
            ]);

            // If setting as default, unset other defaults
            if ($request->boolean('is_default')) {
                auth()->user()->addresses()->update(['is_default' => false]);
            }

            $address = auth()->user()->addresses()->create([
                'user_id' => auth()->id(),
                'recipient_name' => $validated['recipient_name'],
                'street' => $validated['street'],
                'city' => $validated['city'],
                'province' => $validated['province'],
                'postal_code' => $validated['postal_code'],
                'phone' => $validated['phone'],
                'is_default' => $validated['is_default'] ?? false,
            ]);

            return response()->json([
                'success' => true,
                'message' => __('messages.address.saved'),
                'address' => $address,
            ]);
        } catch (ValidationException $e) {
            \Log::error('Address validation: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => __('messages.validation.failed'),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Address store error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update an address
     */
    public function update(Request $request, Address $address)
    {
        // Check if user owns this address
        if ($address->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => __('messages.auth.unauthorized'),
            ], 403);
        }

        try {
            $validated = $request->validate([
                'recipient_name' => 'required|string|max:100',
                'street' => 'required|string|max:500',
                'city' => 'required|string|max:100',
                'province' => 'required|string|max:100',
                'postal_code' => 'required|string|max:10',
                'phone' => 'required|string|max:20',
                'is_default' => 'sometimes|boolean',
            ]);

            // If setting as default, unset other defaults
            if ($request->boolean('is_default')) {
                auth()->user()->addresses()->update(['is_default' => false]);
            }

            $address->update($validated);

            return response()->json([
                'success' => true,
                'message' => __('messages.address.updated'),
                'address' => $address,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => __('messages.validation.failed'),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Address update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete an address
     */
    public function destroy(Address $address)
    {
        // Check if user owns this address
        if ($address->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => __('messages.auth.unauthorized'),
            ], 403);
        }

        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Address deleted successfully',
        ]);
    }

    /**
     * Set an address as default
     */
    public function setDefault(Address $address)
    {
        // Check if user owns this address
        if ($address->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        // Unset all defaults and set this one as default
        auth()->user()->addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Default address updated',
            'address' => $address,
        ]);
    }

    /**
     * Get user's addresses as JSON (for modals)
     */
    public function getAddresses()
    {
        $addresses = auth()->user()->addresses;

        return response()->json([
            'success' => true,
            'addresses' => $addresses,
        ]);
    }
}

