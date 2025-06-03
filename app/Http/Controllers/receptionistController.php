<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Models\Position;
use App\Models\Location;

use App\Models\Patient;

use App\Models\User;

use App\Models\TotalItems;
use App\Models\AddItem;
use App\Models\AllPatient;
use App\Models\Category;
use App\Models\Bill;
use App\Models\Newbill;
use App\Models\PositionName;
use App\Models\Situation;
use Illuminate\Support\Facades\Auth;

class receptionistController extends Controller
{
    public function home_reception()
    {
        return view('receptionist.index');
    }




    // عرض صفحة اضافة مريض جديد
    public function add_patient()
    {
        $user = User::find(Auth::user()->id);
        // احضار جميع البيانات من قاعدة البيانات
        $categories = Category::with(['positions.situations'])->get(); // خلي بالك لازم تكون عامل العلاقة دي في الموديل
        $positions = PositionName::all();
        $situations = Situation::all();

        $dataLoc = Location::all();

        return view('receptionist.sidebar.add_patient', compact('dataLoc', 'user', 'categories', 'positions', 'situations'));
    }

    public function getPositions($categoryId)
    {
        $positions = \App\Models\PositionName::where('category_id', $categoryId)->get();
        return response()->json($positions);
    }

    public function getSituations($positionId)
    {
        return \App\Models\Situation::where('position_id', $positionId)->get();
    }


    public function getPrice($situationId)
    {
        $situation = \App\Models\Situation::find($situationId);
        return response()->json(['price' => $situation->price]);
    }






    // اضافة مريض جديد
    public function upload_patient(Request $request)
    {
        // انشاء مريض جديد
        $data = new Patient;

        // اضافة البيانات
        $data->id_user = $request->id_user;
        $data->full_name = $request->name;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->age = $request->age;
        $data->gender = $request->gender;
        $data->dr_name = $request->doctor;
        $data->category = ($request->category);
        $data->positions = json_encode($request->positions); // List of position_ids
        $data->situations = json_encode($request->situations); // List of situation_ids
        $data->complaint = $request->complaint;
        $data->location = $request->location;
        $data->price = $request->price;
        $data->comments = $request->comments;
        $data->image = $request->image;

        // اضافة الصورة
        if ($request->image) {
            $image = $request->image;
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('Rochetes'), $image_name);
            $data->image = $image_name;
        }

        // حفظ البيانات
        $data->save();

        // حفظ الوظائف المرتبطة
        $data->positions()->attach($request->position);

        // ارجاع الى الصفحة السابقة
        return redirect()->back();
    }



    public function waiting_list()
    {
        if (Auth::id()) {
            $user = Auth::user();

            // إحضار المرضى مع علاقاتهم
            $patients = Patient::with(['positions', 'categoryData', 'locationData'])->paginate(10);

            return view('receptionist.sidebar.waiting_list', compact('patients', 'user'));
        }
    }




    // حذف المريض من قائمة الانتظار
    public function delete_patient($id)
    {
        $data = Patient::find($id);
        $image_path = public_path('Rochetes/' . $data->image);

        // حذف الصورة من التخزين
        if (is_file($image_path)) {
            unlink($image_path);
        }

        $data->delete();
        return redirect()->back();
    }

    public function update_patient_list($id)
    {
        $data = Patient::find($id);
        $dataLoc = Location::all();
        $dataPos = PositionName::all();
        $dataSit = Situation::all();
        $dataCat = Category::all();

        return view('receptionist.sidebar.update_patient_list', compact('data', 'dataLoc', 'dataPos', 'dataSit', 'dataCat'));
    }



    public function edit_patient_list(Request $request, $id)
    {
        $data = Patient::find($id);

        // تعديل البيانات
        $data->full_name = $request->name;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->age = $request->age;
        $data->gender = $request->gender;
        $data->dr_name = $request->doctor;
        $data->category = ($request->category);

        $data->positions = json_encode($request->positions);
        // List of position_ids
        $data->situations = json_encode($request->situations); // List of situation_ids

        $data->complaint = $request->complaint;
        $data->location = $request->location;
        $data->price = $request->price;
        $data->comments = $request->comments;
        $data->image = $request->image;

        // إذا كانت صورة جديدة موجودة
        if ($request->hasFile('image')) {
            // حفظ الصورة الجديدة
            $image_name = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('Rochetes'), $image_name);

            // حذف الصورة القديمة من التخزين (إذا كانت موجودة)
            if ($data->image && file_exists(public_path('Rochetes/' . $data->image))) {
                unlink(public_path('Rochetes/' . $data->image));
            }

            // تعيين الصورة الجديدة
            $data->image = $image_name;
        }
        // حفظ البيانات
        $data->save();

        // ارجاع الى الصفحة السابقة
        return redirect('/waiting_list');
    }

    
    public function view_patients($id)
    {
        $data = AllPatient::find($id);
        return view('receptionist.sidebar.view_patients', compact('data'));
    }



    public function total_patients_admin(Request $request)
    {

        if (Auth::id()) {
            $user = Auth::user();
            $query = AllPatient::with(['positions', 'locationData']);
    
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('full_name', 'LIKE', "%$search%")
                      ->orWhere('phone', 'LIKE', "%$search%");
                });
            }
    
            $patients = $query->paginate(10);
        }
    
        return view('receptionist.sidebar.total_pateints', compact('patients', 'user'));
    }


    public function new_bill()
    {
        $user = User::find(Auth::user()->id);

        $bills = Newbill::all();

        return view('receptionist.sidebar.new_bill', compact('bills', 'user'));
    }

    public function upload_bill(Request $request)
    {
        $data = new Newbill();

        // اضافة البيانات
        $data->id_user = $request->id_user;
        $data->bill_name = $request->bill_name;
        $data->bill_type = $request->bill_type;
        $data->required_qty = $request->required_qty;
        $data->available_qty = $request->available_qty;
        $data->price_bill = $request->price_bill;
        $data->comments_bill = $request->comments_bill;


        // حفظ البيانات
        $data->save();

        // ارجاع الى الصفحة السابقة
        return redirect('/bills_admin');
    }










    public function total_items_reception()
    {
        $categories = TotalItems::all();
        $items = AddItem::all();

        return view('receptionist.sidebar.total_items_reception', compact('categories', 'items'));
    }



    public function update_category_rec(Request $request, $id)
    {
        $request->validate([
            'name_category' => 'required|string|max:255'
        ]);

        try {
            $category = TotalItems::findOrFail($id);
            $category->name_category = $request->name_category;
            $category->save();

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الفئة بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء التحديث: ' . $e->getMessage()
            ], 500);
        }
    }


    public function add_category_page_rec()
    {
        return view('receptionist.sidebar.add_category_items');
    }



    public function add_category_items_rec(Request $request)
    {
        $category = new TotalItems();
        $category->name_category = $request->name_category;
        $category->save();

        return response()->json(['status' => 'success']);
    }



    public function add_item_rec($id)
    {
        $category = TotalItems::find($id);
        $items = AddItem::where('total_items_id', $id)->get();

        return view('receptionist.sidebar.add_item_rec', compact('category', 'items'));
    }


    public function add_item_success_ajax_rec(Request $request, $categoryId)
    {
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $item = new AddItem();
            $item->total_items_id = $categoryId;
            $item->item_name = $request->item_name;
            $item->quantity = $request->quantity;
            $item->total_price = $request->total_price;
            $item->save();

            return response()->json([
                'status' => 'success',
                'item' => $item,
                'message' => 'تمت إضافة العنصر بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء الحفظ: ' . $e->getMessage()
            ], 500);
        }
    }




    public function update_item_rec(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $item = AddItem::findOrFail($id);
            $item->item_name = $request->item_name;
            $item->quantity = $request->quantity;
            $item->total_price = $request->total_price;
            $item->save();

            return response()->json([
                'success' => true,
                'updated_item' => $item,
                'message' => 'تم تحديث العنصر بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء التحديث: ' . $e->getMessage()
            ], 500);
        }
    }
}
