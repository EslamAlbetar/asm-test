<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuthedPage;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'id_user' => $data['id_user'] ?? 0, // أو القيمة المناسبة

        ]);




        event(new Registered($user));

        Auth::login($user);

        // إعداد الحقول حسب نوع المستخدم
        $permissions = [
            'admin_dashboard',
            'add_patient_admin',
            'view_category',
            'waiting_list_admin',
            'total_patients_admin',
            'writing_report',
            'center_devices',
            'donations_admin',
            'staff_team',
            'bills_admin',
            'all_bills',
            'total_items_admin',
            'profit',
            'profile_user',
            'details_staff',
            'update_patient_list_admin',
            'update_waiting_list_admin',
            'completePatient',
            'completePatient',
            'delete_staff',
            'update_staff',
            'write_report_now',
        ];

        $defaultPermissions = [];

        foreach ($permissions as $permission) {
            if ($user->usertype === 'superadmin') {
                $defaultPermissions[$permission] = true;
            } else {
                $defaultPermissions[$permission] = $permission === 'profile_user';
            }
        }

        // حفظ الصلاحيات
        AuthedPage::create(array_merge(
            ['user_id' => $user->id],
            $defaultPermissions
        ));

        return redirect()->back()->with('success', 'تم إنشاء المستخدم مع صلاحياته.');
    }
}
