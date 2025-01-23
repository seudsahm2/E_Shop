<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

use League\ISO3166\ISO3166;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $iso3166 = new ISO3166();
        $countries = $iso3166->all();

        // Extract country codes and names
        $countryList = [];
        foreach ($countries as $country) {
            $countryList[$country['alpha2']] = $country['name'];
        }

        return view('profile.edit', compact('countryList'), [
            'user' => $request->user(),
            'profile' => $request->user()->profile,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Update user information
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Update or create profile information
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $request->only(['company_name', 'country', 'address', 'town', 'zipcode', 'phone_number'])
        );

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function showShoppingProfile(Request $request)
    {

        $user = $request->user();
        $cartItemCount = $this->getCartItemCount();
        // Fetch user or other necessary data for the shopping profile page
        return view('profile.activity.shopping-profile', compact('user', 'cartItemCount'));  // Return the view for the shopping profile

    }
}
