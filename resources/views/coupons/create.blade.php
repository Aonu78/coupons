<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg px-5 py-7">
                <h1 class="text-3xl text-center	text-gray-900 dark:text-gray-100">{{__('Create Coupon')}}</h1>
                <form method="POST" action="{{route('coupons.create')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-2">
                        <x-input-label for="name" :value="__('Coupon Name')"/>
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="coupon_name" :value="old('coupon_name')"
                                      required autofocus/>
                        <x-input-error :messages="$errors->get('coupon_name')" class="mt-2"/>
                    </div>

                    <div class="mt-2">
                        <x-input-label for="description" :value="__('Coupon Description')"/>
                        <x-textarea
                            id="description"
                            class="block mt-1 w-full"
                            name="coupon_description"
                            required
                        ></x-textarea>
                        <x-input-error :messages="$errors->get('coupon_description')" class="mt-2"/>
                    </div>

                    <div class="mt-2">
                        <x-input-label for="price" :value="__('Coupon Price')"/>
                        <x-text-input id="price" class="block mt-1 w-full" type="number" name="coupon_price"
                                      :value="old('coupon_price')" required/>
                        <x-input-error :messages="$errors->get('coupon_price')" class="mt-2"/>
                    </div>
                    
                    <div class="mt-2">
                        <x-input-label for="game_id" :value="__('Select Game')"/>
                        <select required class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" name="game_id" id="game_id">
                            @foreach ($games as $item)
                            <option value="{{ $item->id }}">{{ $item->game_name }}</option>
                            @endforeach                            
                        </select>
                    </div>

                    <div class="flex flex-row gap-x-2">
                        <div class="mt-2 flex-1">
                            <x-input-label for="start_date" :value="__('Start Date')"/>
                            <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="coupon_usage_start_date"
                                          :value="old('coupon_usage_start_date')" required/>
                            <x-input-error :messages="$errors->get('coupon_usage_start_date')" class="mt-2"/>
                        </div>
                        <div class="mt-2 flex-1">
                            <x-input-label for="end_date" :value="__('End Date')"/>
                            <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="coupon_usage_end_date"
                                          :value="old('coupon_usage_end_date')" required/>
                            <x-input-error :messages="$errors->get('coupon_usage_end_date')" class="mt-2"/>
                        </div>
                    </div>

                    <div class="flex flex-row gap-x-2">
                        <div class="mt-2 flex-1">
                            <x-input-label for="sales_start_date" :value="__('Sales Start Date')"/>
                            <x-text-input id="sales_start_date" class="block mt-1 w-full" type="date" name="coupon_sale_start_date"
                                          :value="old('coupon_sale_start_date')" required/>
                            <x-input-error :messages="$errors->get('coupon_sale_start_date')" class="mt-2"/>
                        </div>
                        <div class="mt-2 flex-1">
                            <x-input-label for="sales_end_date" :value="__('Sales End Date')"/>
                            <x-text-input id="sales_end_date" class="block mt-1 w-full" type="date" name="coupon_sale_end_date"
                                          :value="old('coupon_sale_end_date')" required/>
                            <x-input-error :messages="$errors->get('coupon_sale_end_date')" class="mt-2"/>
                        </div>
                    </div>

                    <div class="mt-2">
                        <x-input-label for="coupons_available" :value="__('Coupon Available')"/>
                        <x-text-input id="coupons_available" class="block mt-1 w-full" type="number" name="coupons_available"
                                      :value="old('coupons_available')"/>
                        <x-input-error :messages="$errors->get('coupons_available')" class="mt-2"/>
                    </div>

                    <div class="mt-2">
                        <x-input-label for="coupon_image" :value="__('Design')"/>
                        <x-text-input id="coupon_image" class="block mt-1 w-full" type="file" name="coupon_image"
                                      :value="old('coupon_image')" accept="image/*" required/>
                        <x-input-error :messages="$errors->get('coupon_image')" class="mt-2"/>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('Create') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
