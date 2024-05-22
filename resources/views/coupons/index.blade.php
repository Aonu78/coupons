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
                            <td class="px-6 py-4" style="display: flex;justify-content: space-around;">
                                <a href="{{route('coupons.edit', $coupon->id)}}">
                                    <x-secondary-button>
                                        {{ __('Edit') }}
                                    </x-secondary-button>
                                </a>
                                <a href="{{route('coupons.destroy', $coupon->id)}}">
                                    <x-secondary-button>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                          </svg>
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
