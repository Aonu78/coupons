<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 py-7">
                <div class="flex flex-row justify-between">
                    <h1 class="text-3xl text-center	text-gray-900 dark:text-gray-100">{{__('coupons.admin.index.title')}}</h1>

                    <a href="{{route('admin.coupons.create')}}">
                        <x-primary-button class="ml-4">
                            {{__('coupons.admin.index.new')}}
                        </x-primary-button>
                    </a>
                </div>

                <table class="mt-5 min-w-full text-left text-gray-900 dark:text-gray-100">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="text-left">
                        <th scope="col" class="px-6 py-3">{{__('coupons.admin.index.id')}}</th>
                        <th scope="col" class="px-6 py-3">{{__('coupons.admin.index.name')}}</th>
                        <th scope="col" class="px-6 py-3">{{__('coupons.admin.index.price')}}</th>
                        <th scope="col" class="px-6 py-3">{{__('coupons.admin.index.discount')}}</th>
                        <th scope="col" class="px-6 py-3">{{__('coupons.admin.index.sales_price')}}</th>
                        <th scope="col" class="px-6 py-3">{{__('coupons.admin.index.start_date')}}</th>
                        <th scope="col" class="px-6 py-3">{{__('coupons.admin.index.end_date')}}</th>
                        <th scope="col" class="px-6 py-3 text-center">{{__('coupons.admin.index.actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($coupons as $coupon)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ $coupon->id }}</td>
                            <td class="px-6 py-4">{{ $coupon->name }}</td>
                            <td class="px-6 py-4">{{ $coupon->price }}</td>
                            <td class="px-6 py-4">{{ $coupon->discount }}</td>
                            <td class="px-6 py-4">{{ $coupon->sales_price }}</td>
                            <td class="px-6 py-4">{{ $coupon->start_date }}</td>
                            <td class="px-6 py-4">{{ $coupon->end_date }}</td>
                            <td class="px-6 py-4 text-center" style="display: flex;justify-content: space-around;">
                                <a href="{{route('admin.coupons.edit', $coupon->id)}}">
                                    <x-secondary-button>
                                        {{__('coupons.admin.index.edit')}}
                                    </x-secondary-button>
                                </a>
                                <a href="{{route('admin.coupons.destroy', $coupon->id)}}">
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
</x-admin-layout>
