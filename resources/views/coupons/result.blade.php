<x-coupon-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-2">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 py-7">
                <div class="flex flex-row justify-between">
                    <h1 class="text-3xl text-center	text-gray-900 dark:text-gray-100">{{__('Use Coupon')}}</h1>
                </div>
                @if($processed)
                    <div class="p-4 mt-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border" role="alert">
                        {{$message}}
                    </div>
                @else
                    <div class="p-4 mt-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-900 dark:text-red-400 border" role="alert">
                        {{$message}}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-coupon-layout>
