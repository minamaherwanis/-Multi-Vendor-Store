<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;

class MakeAdminController extends Controller
{
    /**
     * Display all admin users.
     */
    public function index()
    {
        $admins = User::where('type', 'admin')->get();

        return view('super-admin.index', compact('admins'));
    }

    /**
     * Show form to assign a store to a specific admin user.
     */
    public function create(User $admin)
    {
        $stores = Store::all();

        return view('super-admin.create', compact('admin', 'stores'));
    }

    /**
     * Assign existing store, create new store, or remove assignment.
     */
    public function store(Request $request, User $admin)
    {
        $action = $request->input('action');

        // --- Remove Assignment ---
        if ($action === 'remove') {
            $admin->update(['store_id' => null]);
            return redirect()->route('adminstore.index')
                ->with('success', 'Store assignment removed from ' . $admin->name . '.');
        }

        // --- Create New Store & Assign ---
        if ($action === 'create') {
            $request->validate([
                'name'        => 'required|string|max:255',
                'slug'        => 'required|string|max:255|unique:stores,slug',
                'description' => 'nullable|string',
                'status'      => 'required|in:active,inactive',
            ]);

            $store = Store::create([
                'name'        => $request->name,
                'slug'        => $request->slug,
                'description' => $request->description,
                'status'      => $request->status,
            ]);

            $admin->store_id = $store->id;
            $admin->save();

            return redirect()->route('adminstore.index')
                ->with('success', 'New store created and assigned to ' . $admin->name . '!');
        }

        // --- Assign Existing Store ---
        $request->validate([
            'store_id' => 'required|exists:stores,id',
        ]);

        $admin->store_id = $request->store_id;
        $admin->save();

        return redirect()->route('adminstore.index')
            ->with('success', 'Store assigned to ' . $admin->name . ' successfully!');
    }

    /**
     * Show edit form for a store.
     */
    public function editStore(Store $store)
    {
        return view('super-admin.edit-store', compact('store'));
    }

    /**
     * Update the store.
     */
    public function updateStore(Request $request, Store $store)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:stores,slug,' . $store->id,
            'description' => 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ]);

        $store->update([
            'name'        => $request->name,
            'slug'        => $request->slug,
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        return redirect()->route('adminstore.index')
            ->with('success', 'Store "' . $store->name . '" updated successfully!');
    }
}