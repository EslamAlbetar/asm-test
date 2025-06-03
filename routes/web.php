<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PagePermissionController;
use App\Http\Controllers\ProfitController;
use Carbon\Carbon;
use App\Models\AllPatient;
use App\Http\Middleware\CheckPage;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});


require __DIR__ . '/auth.php';



Route::post('/update-center-name', [HomeController::class, 'updateName'])->name('update.center.name');


// ===================== المستخدمين اللى لهم صلاحيات =====================

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');




    Route::put('/permissions/{user}', [PagePermissionController::class, 'update'])->name('permissions.update');



    // توجيىة الأدمن عند تسجيل الدخول الى صفحة الادمن
    Route::get('/admin/dashboard', [HomeController::class, 'index'])
        ->middleware(CheckPage::class . ':admin_dashboard')
        ->name('admin.dashboard');

    // صفحة الشركاء
    Route::get('/parteners', [AdminController::class, 'parteners'])
        ->middleware(CheckPage::class . ':parteners')
        ->name('parteners');

    Route::post('/parteners/store', [AdminController::class, 'store_partener'])->name('store.partener');
    Route::delete('/partners/{id}', [AdminController::class, 'destroy_partener'])
        ->name('partners.destroy');
    Route::post('/update-profits', [AdminController::class, 'updateProfits'])
        ->name('update.profits');


    // صفحة المالية
    Route::get('/financial_accounting', [AdminController::class, 'financial_accounting'])
        ->middleware(CheckPage::class . ':financial_accounting')
        ->name('financial_accounting');
    Route::get('/refresh-financial-data', [AdminController::class, 'refresh_financial_data'])->name('financial.refresh');


    // تقارير الموظفين
    Route::get('/staff/{id}/details', [AdminController::class, 'details_staff'])->name('staff.details');
    Route::post('/staff/{id}/filter', [AdminController::class, 'filterStaffData'])->name('staff.filter');
    Route::get('/staff/{id}/report/{month?}', [AdminController::class, 'generateStaffReport'])->name('staff.report');

    // صفحة تعديل البروفايل  
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::post('/profile/upload-image', [ProfileController::class, 'uploadImage'])->name('profile.uploadImage');

    // صفحة البروفايل العامة 
    Route::get('profile_user', [AdminController::class, 'profile_user'])
        ->middleware(CheckPage::class . ':profile_user')
        ->name('profile_user');

    // عرض صفحة إضافة الأنواع
    Route::get('add_user_type', [AdminController::class, 'add_user_type'])
        ->middleware(CheckPage::class . ':add_user_type')
        ->name('add_user_type');

    // CRUD Routes لليوزر تايب
    Route::get('/usertypes', [AdminController::class, 'index_usertype']);
    Route::post('/usertypes', [AdminController::class, 'store_usertype']);
    Route::delete('/usertypes/{usertype}', [AdminController::class, 'destroy_usertype']);
    Route::put('/usertypes/{usertype}', [AdminController::class, 'update_usertype']);

    // صفحة الاجازات
    Route::get('vacation', [AdminController::class, 'vacation'])
        ->name('vacation');

    Route::post('/vacation/store', [AdminController::class, 'storeVacation'])
        ->name('vacation.store');

    Route::delete('/vacation/{id}', [AdminController::class, 'destroyVacation'])
        ->name('vacation.destroy');

    Route::get('permission', [AdminController::class, 'permission'])
        ->name('permission');

    Route::post('permission/store', [AdminController::class, 'storePermission'])
        ->name('permission.store');

    Route::delete('permission/{id}', [AdminController::class, 'destroyPermission'])
        ->name('permission.destroy');

    // صفحة الخصومات
    Route::get('deduction', [AdminController::class, 'deduction'])->name('deduction');

    // إضافة خصم
    Route::post('deduction/store', [AdminController::class, 'storeDeduction'])->name('deduction.store');

    // حذف خصم
    Route::delete('deduction/{id}', [AdminController::class, 'destroyDeduction'])->name('deduction.destroy');

    // إرسال الاعتراض
    Route::post('deduction/objection', [AdminController::class, 'submitObjection'])->name('objection.submit');

    // إلغاء الاعتراض
    Route::post('deduction/objection/cancel', [AdminController::class, 'cancelObjection'])->name('objection.cancel');

    // الرد على الاعتراض
    Route::post('/deductions/reply', [AdminController::class, 'reply_objection'])->name('deductions.reply');



    Route::post('/permissions/reply', [AdminController::class, 'reply_per'])
        ->name('permissions.reply');

    Route::post('/vacations/reply', [AdminController::class, 'reply_vacation'])
        ->name('vacations.reply');


    // صفحة اضافة فئات الاجهزه واوضاع ومواقع التسجيل 
    Route::get('view_category', [AdminController::class, 'view_category'])
        ->middleware(CheckPage::class . ':view_category')
        ->name('view_category');


    // اضافة وحذف وتعديل وتحديث بيانات تصوير الاشعة
    Route::post('add_location', [AdminController::class, 'add_location']);
    Route::delete('location/{id}', [AdminController::class, 'delete_location']);
    Route::get('edit_location/{id}', [AdminController::class, 'edit_location']);
    Route::put('update_location/{id}', [AdminController::class, 'update_location']);

    // اضافة وحذف وتعديل وتحديث بيانات صلاحيات المستخدم
    route::post('add_usertype', [AdminController::class, 'add_usertype']);
    route::get('delete_usertype/{id}', [AdminController::class, 'delete_usertype']);
    route::get('edit_usertype/{id}', [AdminController::class, 'edit_usertype']);
    route::post('update_usertype/{id}', [AdminController::class, 'update_usertype']);



    Route::get('/waiting-list-count', [App\Http\Controllers\AdminController::class, 'waitingListCount']);
    Route::get('/today-patients-count', function () {
        $count = AllPatient::whereDate('created_at', Carbon::today())->count();
        return response()->json(['count' => $count]);
    });

    // web.php
    Route::get('/get-categories', function () {
        return \App\Models\Category::select('id', 'name')->get();
    });

    Route::get('/get-positions/{category}', function ($category) {
        return \App\Models\PositionName::where('category_id', $category)->get();
    });

    Route::get('/get-situations/{position}', function ($position) {
        return \App\Models\Situation::where('position_id', $position)->get();
    });

    Route::get('/get-locations', function () {
        return \App\Models\Location::select('id', 'location_name')->get();
    });


    Route::post('/shift/start', [AdminController::class, 'startShift'])->name('shift.start');
    Route::post('/end-shift', [AdminController::class, 'endShift'])->name('shift.end');
    Route::get('/shift/status', [AdminController::class, 'checkShiftStatus'])->name('shift.status');

    Route::get('/salary/user/{id_user}', [AdminController::class, 'showSalaryForm'])->name('salary.form');
    Route::post('/user/{id_user}', [AdminController::class, 'updateSalary'])->name('salary.update');
    Route::get('/calculate/{id_user}', [AdminController::class, 'calculateMonthlySalary'])->name('salary.calculate');

    // total Items
    Route::put('/update_category/{id}', [AdminController::class, 'updateCategoryTotalItem']);
    Route::delete('/delete_category/{id}', [AdminController::class, 'destroyCategoryTotalItem'])->name('categories.destroy');


    // تصدير التقارير
    Route::get('/export/pdf', [ProfitController::class, 'exportPdf'])->name('export.pdf');
    Route::get('/export/monthly/pdf', [ProfitController::class, 'exportMonthlyPdf'])->name('export.monthly.pdf');
    Route::get('/export/yearly/pdf', [ProfitController::class, 'exportYearlyPdf'])->name('export.yearly.pdf');


    Route::get('/details_staff/{id}', [AdminController::class, 'details_staff'])
        ->middleware(CheckPage::class . ':details_staff')
        ->name('details_staff');


    Route::get('/staff/{id}/pdf/{month}', [AdminController::class, 'generatePdf'])->name('staff.shifts.pdf');

    // إضافة هذا المسار للحصول على بيانات تبرع معين
    Route::get('/donations/{id}/edit', [AdminController::class, 'edit'])->name('donations.edit');


    // عمليات CRUD
    Route::post('/donations', [AdminController::class, 'store'])
        ->name('donations.store');

    Route::get('/donations', [AdminController::class, 'list'])
        ->name('donations.list');

    Route::put('/donations/{id}', [AdminController::class, 'update'])
        ->name('donations.update');

    Route::delete('/donations/{id}', [AdminController::class, 'destroy'])
        ->name('donations.destroy');

    // صفحة الاارباح
    Route::get('/profit', [ProfitController::class, 'index'])
        ->middleware(CheckPage::class . ':profit')
        ->name('admin.profit');

    Route::get('/profit/fetch', [ProfitController::class, 'fetchProfitData'])
        ->name('profit.fetch');
    Route::get('/profit/years-months', [ProfitController::class, 'getAvailableYearsMonths'])
        ->name('profit.years_months');


    Route::post('/add_position_success_ajax/{category}', [AdminController::class, 'add_position_success_ajax'])
        ->name('add_item_success_ajax');

    Route::post('/add_situation/{id}', [AdminController::class, 'add_situation'])
        ->name('add_situation');

    Route::delete('/delete_position/{id}', [AdminController::class, 'delete_position'])
        ->name('categories.destroy');

    Route::delete('/delete_cetegory_pos/{id}', [AdminController::class, 'delete_cetegory_pos'])->name('categories.destroy');

    Route::delete('/delete_situation/{id}', [AdminController::class, 'delete_situation'])->name('categories.destroy');

    Route::post('/update_position/{id}', [AdminController::class, 'update_position'])->name('update_position');

    Route::put('/update_situation/{id}', [AdminController::class, 'update_situation'])->name('update_situation');


    Route::get('add_patient_admin', [AdminController::class, 'add_patient_admin'])
        ->middleware(CheckPage::class . ':add_patient_admin')
        ->name('add_patient_admin');

    // اضافة مريض جديد
    route::post('upload_patient_admin', [AdminController::class, 'upload_patient_admin'])
        ->name('upload_patient_admin');


    route::get('add_new_bill', [AdminController::class, 'add_new_bill'])
        ->name('add_new_bill');


    Route::get('donations_admin', [AdminController::class, 'donations_admin'])
        ->middleware(CheckPage::class . ':donations_admin')
        ->name('donations_admin');


    // قائمة الموارد الموجودة
    route::get('total_items_admin', [AdminController::class, 'total_items_admin'])
        ->middleware(CheckPage::class . ':total_items_admin')
        ->name('total_items_admin');

    Route::post('/update-item-quantity', [AdminController::class, 'updateQuantity']);
    Route::post('/delete-item', [AdminController::class, 'delete']);


    route::get('add_category_page', [AdminController::class, 'add_category_page'])
        ->name('add_category_page');

    route::post('add_category_items', [AdminController::class, 'add_category_items'])
        ->name('add_category_items');

    Route::get('/add_category_items', [AdminController::class, 'add_category_items'])
        ->name('add_category_items');


    route::get('add_item/{id}', [AdminController::class, 'add_item'])
        ->name('add_item');

    // Add Item Ajax
    Route::post('/add_item_success_ajax/{category}', [AdminController::class, 'add_item_success_ajax'])
        ->name('add_item_success_ajax');

    // Update Item
    Route::post('/update_item/{id}', [AdminController::class, 'update_item'])->name('update_item');

    // Delete Item
    Route::delete('/delete_item/{id}', [AdminController::class, 'delete_item'])->name('delete_item');


    // تحديث الفئة
    Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');

    // حذف الفئة
    Route::delete('/categories/{id}', [AdminController::class, 'deleteCategory'])->name('admin.categories.delete');

    Route::get('/view_add_category_position', [AdminController::class, 'view_add_category_position'])
        ->name('view_add_category_position');

    Route::post('/add_category_position', [AdminController::class, 'add_category_position'])
        ->name('add_category_position');

    Route::get('/add_pos_situ/{id}', [AdminController::class, 'add_pos_situ'])
        ->name('add_pos_situ');



    Route::get('/total_patients_admin', [AdminController::class, 'total_patients_admin'])
        ->middleware(CheckPage::class . ':total_patients_admin')
        ->name('total_patients_admin');


    // قائمة انتظار المرضى
    Route::get('waiting_list_admin', [AdminController::class, 'waiting_list_admin'])
        ->middleware(CheckPage::class . ':waiting_list_admin')
        ->name('waiting_list_admin');
    route::get('update_patient_list_admin/{id}', [AdminController::class, 'update_patient_list_admin'])
        ->middleware(CheckPage::class . ':update_patient_list_admin')
        ->name('update_patient_list_admin');
    route::post('edit_waiting_list_admin/{id}', [AdminController::class, 'edit_waiting_list_admin'])
        ->name('edit_waiting_list_admin');
    route::get('update_waiting_list_admin/{id}', [AdminController::class, 'update_waiting_list_admin'])
        ->middleware(CheckPage::class . ':update_waiting_list_admin')
        ->name('update_waiting_list_admin');
    route::post('edit_patient_list_admin/{id}', [AdminController::class, 'edit_patient_list_admin'])
        ->name('edit_patient_list_admin');
    route::get('delete_waiting_patient_admin/{id}', [AdminController::class, 'delete_waiting_patient_admin'])
        ->name('delete_waiting_patient_admin');
    route::get('delete_patient_admin/{id}', [AdminController::class, 'delete_patient_admin'])
        ->name('delete_patient_admin');
    route::get('user_info/{id}', [AdminController::class, 'user_info'])
        ->name('user_info');
    route::get('completePatient/{id}', [AdminController::class, 'completePatient'])
        ->middleware(CheckPage::class . ':completePatient')
        ->name('completePatient');
    Route::get('/completeAjax/{id}', [AdminController::class, 'completeAjax'])->name('complete.ajax');

    // الحصول على الفحوصات حسب الفئة
    Route::get('/get-price/{situationId}', [AdminController::class, 'getPrice'])->name('get_price');

    // اضافة مريض جديد

    Route::get('/print-report/{id}', [AdminController::class, 'generate'])->name('print.report');

    // تحديث التقرير
    Route::post('/confirm_report/{id}', [AdminController::class, 'confirmReport'])->name('confirm.report');

    Route::get('/update_write_report/{id}', [AdminController::class, 'update_write_report'])->name('update_write_report');

    Route::post('/edit_write_report/{id}', [AdminController::class, 'edit_write_report'])->name('edit_write_report');


    // اضافة وحذف وتعديل وتحديث بيانات طاقم العمل
    Route::get('staff_team', [AdminController::class, 'staff_team'])
        ->middleware(CheckPage::class . ':staff_team')
        ->name('staff_team');
    route::get('delete_staff/{id}', [AdminController::class, 'delete_staff'])
        ->middleware(CheckPage::class . ':delete_staff')
        ->name('delete_staff');
    route::get('update_staff/{id}', [AdminController::class, 'update_staff'])
        ->middleware(CheckPage::class . ':update_staff')
        ->name('update_staff');
    route::post('edit_staff_team/{id}', [AdminController::class, 'edit_staff_team'])->name('edit_staff_team');

    // قائمة الأجهزة
    Route::get('center_devices', [AdminController::class, 'center_devices'])
        ->middleware(CheckPage::class . ':center_devices')
        ->name('center_devices');
    route::get('add_device', [AdminController::class, 'add_device'])
        ->name('add_device');
    route::post('add_devices', [AdminController::class, 'add_devices'])
        ->name('add_devices');
    route::get('delete_device/{id}', [AdminController::class, 'delete_device'])
        ->name('delete_device');
    route::get('device_details/{id}', [AdminController::class, 'device_details'])
        ->name('device_details');
    route::get('update_device/{id}', [AdminController::class, 'update_device'])
        ->name('update_device');
    route::post('edit_device/{id}', [AdminController::class, 'edit_device'])
        ->name('edit_device');

    // قائمة التقارير
    Route::get('writing_report', [AdminController::class, 'writing_report'])
        ->middleware(CheckPage::class . ':writing_report')
        ->name('writing_report');
    route::get('write_report_now/{id}', [AdminController::class, 'write_report_now'])
        ->middleware(CheckPage::class . ':write_report_now')
        ->name('write_report_now');

    // قائمة الفواتير
    route::get('bills_admin', [AdminController::class, 'bills_admin'])
        ->middleware(CheckPage::class . ':bills_admin')
        ->name('bills_admin');
    route::get('continue_bill/{id}', [AdminController::class, 'continue_bill'])->name('continue_bill');
    Route::post('/continueBillSubmit', [AdminController::class, 'continueBillSubmit'])->name('continueBill.submit');
    Route::post('/upload_bill', [AdminController::class, 'upload_bill'])->middleware(CheckPage::class . ':bills_admin')
        ->name('upload_bill');



    // قائمة الفواتير جميعها
    route::get('all_bills', [AdminController::class, 'all_bills'])
        ->middleware(CheckPage::class . ':all_bills')
        ->name('all_bills');
    route::get('update_invoice/{id}', [AdminController::class, 'update_invoice'])->name('update_invoice');
    Route::delete('delete_invoice/{id}', [AdminController::class, 'delete_invoice'])->name('delete_invoice');
    route::post('edit_invoice/{id}', [AdminController::class, 'edit_invoice'])->name('edit_invoice');
// طباعة الفاتورة
    Route::get('/invoice/print/{id}', [AdminController::class, 'printInvoice'])->name('invoice.print');
});
