<x-coupon-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-2">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 py-7">
                <div class="flex flex-row justify-between">
                    <h1 class="text-3xl text-center	text-gray-900 dark:text-gray-100">{{__('Use Coupon')}}</h1>
                </div>
                @if(isset($userCoupon) && is_null($userCoupon->used_at))
                <table class="mt-5 min-w-full text-left text-gray-900 dark:text-gray-100">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="text-left">
                        <th scope="col" class="px-6 py-3">Coupon Name</th>
                        <th scope="col" class="px-6 py-3">User Name</th>
                        <th scope="col" class="px-6 py-3">Discount</th>
                        <th scope="col" class="px-6 py-3 text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-6 py-4">{{$userCoupon->user->name}}</td>
                            <td class="px-6 py-4">{{$userCoupon->coupon->name}}</td>
                            <td class="px-6 py-4">{{$userCoupon->coupon->discount}}%</td>
                            <td class="px-6 py-4">
                                <form action="{{route('coupons.use.process', $userCoupon->id)}}" method="POST">
                                    @csrf
                                    <x-secondary-button type="submit">
                                        {{ __('Use') }}
                                    </x-secondary-button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
                @elseif(isset($userCoupon) && !is_null($userCoupon->used_at))
                    <div class="p-4 mt-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-900 dark:text-red-400 border" role="alert">
                        <b class="font-medium">Coupon Used Before!</b> Please Scan Another QR Code
                    </div>
                @else
                    <div class="p-4 mt-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-900 dark:text-red-400 border" role="alert">
                        <b class="font-medium">Coupon Not Found!</b> Please Rescan QR Code Again
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-coupon-layout>
