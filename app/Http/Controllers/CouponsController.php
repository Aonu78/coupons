<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Constants\CouponsFiles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Services\Coupons\CouponsService;
use App\Services\Filesystem\FilesystemService;
use App\Http\Requests\Coupons\CreateCouponRequest;

final class CouponsController extends Controller
{
    public function __construct(
        private readonly FilesystemService $filesystemService,
        private readonly CouponsService $couponsService
    ) {}

    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $coupons = $user->coupons()->paginate();

        return view('coupons.index', compact('coupons'));
    }

    public function add()
    {
        return view('coupons.create');
    }

    public function edit(int $id)
    {
        /** @var User $user */
        $user = Auth::user();
        $coupon = $user->coupons()->where('id', $id)->first();

        if (is_null($coupon)) {
            return back();
        }

        return view('coupons.edit', compact('coupon'));
    }

    public function update(int $id, Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $coupon = $user->coupons()->where('id', $id)->first();

        if (is_null($coupon)) {
            return back();
        }

        $coupon->name = $request->str('coupon_name');
        $coupon->price = $request->str('coupon_price');
        $coupon->sale_start_date = $request->str('coupon_sale_start_date');
        $coupon->sale_end_date = $request->str('coupon_sale_end_date');
        $coupon->coupon_usage_start_date = $request->str('coupon_usage_start_date');
        $coupon->coupon_usage_end_date = $request->str('coupon_usage_end_date');
        $coupon->coupon_description = $request->str('coupon_description');
        $coupon->coupons_available = $request->integer('coupons_available', null);
        $coupon->save();

        if ($request->has('coupon_image')) {
            $file = $request->file('coupon_image');
            $fileName = sprintf(CouponsFiles::COUPON_IMAGE, $coupon->id);

            $this->filesystemService->save($fileName, $file->getContent());
        }

        return redirect()->route('coupons.index');
    }

    public function create(CreateCouponRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $couponDTO = $request->getDTO();

        /** @var Coupon $coupon */
        $coupon = $user->coupons()->newModelInstance();

        $coupon->user_id = $user->id;
        $coupon->name = $couponDTO->name;
        $coupon->price = $couponDTO->price;
        $coupon->sale_start_date = $couponDTO->saleStartDate;
        $coupon->sale_end_date = $couponDTO->saleEndDate;
        $coupon->coupon_usage_start_date = $couponDTO->usageStartDate;
        $coupon->coupon_usage_end_date = $couponDTO->usageEndDate;
        $coupon->coupon_description = $couponDTO->description;
        $coupon->coupon_rebuyible = $couponDTO->rebuyible;
        $coupon->coupons_available = $couponDTO->couponsAvailable;
        $coupon->save();

        $file = $couponDTO->icon;
        $fileName = sprintf(CouponsFiles::COUPON_IMAGE, $coupon->id);
        $this->filesystemService->save($fileName, $file->getContent());

        return redirect()->route('coupons.index');
    }

    public function usePage(int $id)
    {
        $userCoupon = $this->couponsService->findBoughtCoupon($id);

        return view('coupons.use', compact('userCoupon'));
    }

    public function use(int $id)
    {
        $processed = false;
        $message = "You have successfully used the coupon";

        $userCoupon = $this->couponsService->findBoughtCoupon($id);

        if (is_null($userCoupon)) {
            $message = "Coupon not found!";

            return view('coupons.result', compact('processed', 'message'));
        }

        if (isset($userCoupon->used_at)) {
            $message = "Coupon has been used before!";

            return view('coupons.result', compact('processed', 'message'));
        }

        $this->couponsService->useCoupon($userCoupon);

        $processed = true;

        return view('coupons.result', compact('processed', 'message'));
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
