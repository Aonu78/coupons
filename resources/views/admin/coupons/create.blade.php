<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg px-5 py-7">
                <h1 class="text-3xl text-center	text-gray-900 dark:text-gray-100">{{__('coupons.admin.create.title')}}</h1>
                <form method="POST" action="{{route('admin.coupons.save')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-2">
                        <x-input-label for="name" :value="__('coupons.admin.index.name')"/>
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                                      required autofocus/>
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>
                    <div class="mt-2">
                        <x-input-label for="price" :value="__('coupons.admin.index.price')"/>
                        <x-text-input id="price" class="block mt-1 w-full" type="number" name="price"
                                      :value="old('price')" required/>
                        <x-input-error :messages="$errors->get('price')" class="mt-2"/>
                    </div>
                    <div class="mt-2">
                        <x-input-label for="discount" :value="__('coupons.admin.create.discount_rate')"/>
                        <x-text-input id="discount" class="block mt-1 w-full" type="number" name="discount"
                                      :value="old('discount')" required/>
                        <x-input-error :messages="$errors->get('discount')" class="mt-2"/>
                    </div>
                    <div class="mt-2">
                        <x-input-label for="sales_price" :value="__('coupons.admin.index.sales_price')"/>
                        <x-text-input id="sales_price" class="block mt-1 w-full" type="number" name="sales_price"
                                      :value="old('sales_price')" required/>
                        <x-input-error :messages="$errors->get('sales_price')" class="mt-2"/>
                    </div>
                    <div class="mt-2">
                        <x-input-label for="start_date" :value="__('coupons.admin.index.start_date')"/>
                        <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date"
                                      :value="old('start_date')" required/>
                        <x-input-error :messages="$errors->get('start_date')" class="mt-2"/>
                    </div>
                    <div class="mt-2">
                        <x-input-label for="end_date" :value="__('coupons.admin.index.end_date')"/>
                        <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date"
                                      :value="old('end_date')" required/>
                        <x-input-error :messages="$errors->get('end_date')" class="mt-2"/>
                    </div>
                    <div class="mt-2">
                        <x-input-label for="design" :value="__('coupons.admin.create.design')"/>
                        <x-text-input id="design" class="block mt-1 w-full" type="file" name="design"
                                      :value="old('design')" accept="image/*" required/>
                        <x-input-error :messages="$errors->get('design')" class="mt-2"/>
                    </div>

                    <div class="mt-2">
                        <x-input-label for="background" :value="__('coupons.admin.create.bg_image')"/>
                        <x-text-input id="background" class="block mt-1 w-full" type="file" name="background"
                                      :value="old('background')" accept="image/*" required/>
                        <x-input-error :messages="$errors->get('background')" class="mt-2"/>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('coupons.admin.create.create') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
