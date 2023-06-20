<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Coupon\CouponStoreRequest;

class CouponController extends Controller
{

    public function index()
    {
        $coupons = Coupon::all();
        return view('Dashboard.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('Dashboard.coupons.create');
    }

    public function store(CouponStoreRequest $request)
    {
        $validated = $request->validated();
        $validated = $request->except('_token');
        Coupon::create($validated);
        return redirect()->route('coupon.index');
    }

    public function show($id)
    {
        $coupon = Coupon::with('users')->findorfail($id);
        return view('Dashboard.coupons.show', compact('coupon'));
    }

    public function edit($id)
    {
        $coupon = Coupon::findorfail($id);
        return view('Dashboard.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::find($id);
        $data = $request->except('_token');
        $coupon->update($data);
        return redirect()->route('coupon.show', $coupon->id)->with('sucess', 'تم تحديث الكوبون بنجاح');
    }

    public function delete($id)
    {
        $coupon = Coupon::find($id);
        if ($coupon) {
            $coupon->delete();
            return redirect()->route('coupon.index')->with('success', 'Coupon deleted successfully.');
        } else {
            return redirect()->route('coupons.index')->with('error', 'Coupon not found.');
        }
    }
}
