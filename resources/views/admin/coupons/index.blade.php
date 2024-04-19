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
                            <td class="px-6 py-4 text-center">
                                <a href="{{route('admin.coupons.edit', $coupon->id)}}">
                                    <x-secondary-button>
                                        {{__('coupons.admin.index.edit')}}
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
