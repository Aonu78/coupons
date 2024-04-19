<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 py-7">
                <div class="flex flex-row justify-between">
                    <h1 class="text-3xl text-center	text-gray-900 dark:text-gray-100">{{__('Your Coupons')}}</h1>

                    <a href="{{route('coupons.add')}}">
                        <x-primary-button class="ml-4">
                            {{ __('New') }}
                        </x-primary-button>
                    </a>
                </div>

                <table class="mt-5 min-w-full text-left text-gray-900 dark:text-gray-100">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="text-left">
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Price</th>
                        <th scope="col" class="px-6 py-3">Start Date</th>
                        <th scope="col" class="px-6 py-3">End Date</th>
                        <th scope="col" class="px-6 py-3">Sales Start Date</th>
                        <th scope="col" class="px-6 py-3">Sales End Date</th>
                        <th scope="col" class="px-6 py-3">Coupons Available</th>
                        <th scope="col" class="px-6 py-3 text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($coupons as $coupon)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ $coupon->id }}</td>
                            <td class="px-6 py-4">{{ $coupon->name }}</td>
                            <td class="px-6 py-4">{{ $coupon->price }}</td>
                            <td class="px-6 py-4">{{ $coupon->coupon_usage_start_date }}</td>
                            <td class="px-6 py-4">{{ $coupon->coupon_usage_end_date }}</td>
                            <td class="px-6 py-4">{{ $coupon->sale_start_date }}</td>
                            <td class="px-6 py-4">{{ $coupon->sale_end_date }}</td>
                            <td class="px-6 py-4">{{ $coupon->coupons_available ?? '--' }}</td>
                            <td class="px-6 py-4">
                                <a href="{{route('coupons.edit', $coupon->id)}}">
                                    <x-secondary-button>
                                        {{ __('Edit') }}
                                    </x-secondary-button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $coupons->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
