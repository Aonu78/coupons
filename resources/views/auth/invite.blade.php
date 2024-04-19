<x-coupon-layout>
    <div class="p-5">
        <h1 class="mb-4 text-3xl text-center text-gray-600 dark:text-gray-200">
            {{ __('You have been invited to the Couprize!') }}
        </h1>

        <a href="couponssenet://signup/{{$user->invite_code}}" class="flex flex-row justify-center">
            <x-primary-button class="ml-3">
                {{ __('Sign up') }}
            </x-primary-button>
        </a>
    </div>

</x-coupon-layout>
