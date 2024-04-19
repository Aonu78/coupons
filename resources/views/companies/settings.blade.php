<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg px-5 py-7">
                <h1 class="text-3xl text-center text-gray-900 dark:text-gray-100">{{ __('Company Settings') }}</h1>
                <form method="POST" action="{{ route('profile.company.update') }}">
                    @csrf
                    <div class="mt-4">
                        <x-input-label for="company_name" :value="__('Company Name')" />
                        <x-text-input required id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name', $company->company_name ?? null)" required autofocus />
                        <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="address" :value="__('Address')" />
                        <x-text-input required id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address', $company->address ?? null)" required />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="telephone_number" :value="__('Telephone Number')" />
                        <x-text-input required id="telephone_number" class="block mt-1 w-full" type="text" name="telephone_number" :value="old('telephone_number', $company->telephone_number ?? null)" required />
                        <x-input-error :messages="$errors->get('telephone_number')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="email_address" :value="__('Email Address')" />
                        <x-text-input required id="email_address" class="block mt-1 w-full" type="email" name="email_address" :value="old('email_address', $company->email_address ?? null)" required />
                        <x-input-error :messages="$errors->get('email_address')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="sns_account" :value="__('SNS Account')" />
                        <x-text-input required id="sns_account" class="block mt-1 w-full" type="text" name="sns_account" :value="old('sns_account', $company->sns_account ?? null)" required />
                        <x-input-error :messages="$errors->get('sns_account')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="bank_account_information" :value="__('Bank Account Information')" />
                        <x-text-input required id="bank_account_information" class="block mt-1 w-full" type="text" name="bank_account_information" :value="old('bank_account_information', $company->bank_account_information ?? null)" />
                        <x-input-error :messages="$errors->get('bank_account_information')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button class="ml-4">
                            {{ __('Save') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
