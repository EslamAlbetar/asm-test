<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\centerDetails;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $center = centerDetails::first();

        return view('profile.edit', [
            'user' => $request->user(),
            'center' => $center // إضافة المتغير هنا
        ]);
    }
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        $user = Auth::user();
        $file = $request->file('image');
        $filename = 'user_' . $user->id . '.' . $file->getClientOriginalExtension();
    
        // نحفظ الصورة في public/staff_img
        $destinationPath = public_path('staff_img');
        $file->move($destinationPath, $filename);
    
        // نحفظ الاسم فقط في الداتا بيز
        $user->image = $filename;
        $user->save();
    
        return response()->json(['status' => 'success', 'path' => asset('staff_img/' . $filename)]);
    }
    


    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $center = centerDetails::first();
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with([
            'status' => 'profile-updated',
            'center' => $center // إضافة المتغير هنا
        ]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $center = centerDetails::first();
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with([
            'center' => $center // إضافة المتغير هنا
        ]);
    }
}
