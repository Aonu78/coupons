<?php

namespace App\Http\Controllers\Admin;

use App\Models\Game;
use App\Models\User;
use App\Models\Coupon;
use App\Constants\CouponsFiles;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Coupons\CouponsService;
use Illuminate\Support\Facades\Auth;
use App\Services\Filesystem\FilesystemService;


final class CouponsController extends Controller
{
    public function __construct(
        private readonly CouponsService $couponsService,
        private readonly FilesystemService $filesystemService
    ) {}

    public function index()
    {
        $coupons = $this->couponsService->getAll();
        // dd($coupons);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        
        return view('admin.coupons.create');
    }

    public function save(Request $request)
    {
        /** @var User $user */
        $user = Auth::guard('admin')->user();
        
        $coupon = $user->coupons()->create(
            $request->only(['name', 'price', 'discount', 'sales_price', 'start_date', 'end_date'])
        );
        
        $file = $request->file('design');
       
        $fileName = sprintf(CouponsFiles::COUPON_IMAGE, $coupon->id);
        
        $this->filesystemService->save($fileName, $file->getContent());

        $bgFile = $request->file('background');
        $bgFileName = sprintf(CouponsFiles::COUPON_BG_IMAGE, $coupon->id);
        // dd("%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%");
        $this->filesystemService->save($bgFileName, $bgFile->getContent());

        // dd($request->all());
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon Created successfully.');
    }

    public function edit(int $id)
    {
        $coupon = $this->couponsService->find($id)->first();

        if (is_null($coupon)) {
            return back();
        }

        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(int $id, Request $request)
    {
        $coupon = $this->couponsService->find($id);

        if (is_null($coupon)) {
            return back();
        }

        $coupon->update(
            $request->only(['name', 'price', 'discount', 'sales_price', 'start_date', 'end_date'])
        );

        if ($request->has('design')) {
            $file = $request->file('design');
            $fileName = sprintf(CouponsFiles::COUPON_IMAGE, $coupon->id);

            $this->filesystemService->save($fileName, $file->getContent());
        }

        if ($request->hasFile('background')) {
            $bgFile = $request->file('background');
            $bgFileName = sprintf(CouponsFiles::COUPON_BG_IMAGE, $coupon->id);

            $this->filesystemService->save($bgFileName, $bgFile->getContent());
        }

        return redirect()->route('admin.coupons.index');
    }
    public function destroy($id)
    {
        try {
            $coupon = Coupon::findOrFail($id); // Ensure the coupon exists
            $coupon->delete();
            return redirect()->back()->with('success', 'Coupon deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Coupon could not be deleted.');
        }
    }
    
}
