<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 py-7">
                <div class="flex flex-row justify-between">
                    <h1 class="text-3xl text-center	text-gray-900 dark:text-gray-100">{{ __("settings.admin.title") }}</h1>
                </div>
                @if( session()->has('success') )
                    <div class="p-4 mt-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border" role="alert">
                        {{ session()->get('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.settings.save') }}">
                    @csrf

                    <div class="mt-2">
                        <x-input-label for="live_stripe_key" :value="__('settings.admin.live_stripe_key')"/>
                        <x-text-input id="live_stripe_key" class="block mt-1 w-full" type="text" name="live_stripe_key" :value="old('live_stripe_key', $settings->liveStripeKey)"
                                      required autofocus/>
                        <x-input-error :messages="$errors->get('live_stripe_key')" class="mt-2"/>
                    </div>

                    <div class="mt-2">
                        <x-input-label for="live_stripe_secret" :value="__('settings.admin.live_stripe_secret')"/>
                        <x-text-input id="live_stripe_secret" class="block mt-1 w-full" type="text" name="live_stripe_secret" :value="old('live_stripe_secret', $settings->liveStripeSecret)"
                                      required autofocus/>
                        <x-input-error :messages="$errors->get('live_stripe_secret')" class="mt-2"/>
                    </div>

                    <div class="mt-2">
                        <x-input-label for="test_stripe_key" :value="__('settings.admin.test_stripe_key')"/>
                        <x-text-input id="test_stripe_key" class="block mt-1 w-full" type="text" name="test_stripe_key" :value="old('test_stripe_key', $settings->testStripeKey)"
                                      required autofocus/>
                        <x-input-error :messages="$errors->get('test_stripe_key')" class="mt-2"/>
                    </div>

                    <div class="mt-2">
                        <x-input-label for="test_stripe_secret" :value="__('settings.admin.test_stripe_secret')"/>
                        <x-text-input id="test_stripe_secret" class="block mt-1 w-full" type="text" name="test_stripe_secret" :value="old('test_stripe_secret', $settings->testStripeSecret)"
                                      required autofocus/>
                        <x-input-error :messages="$errors->get('test_stripe_secret')" class="mt-2"/>
                    </div>

                    <div class="mt-2">
                        <x-input-label for="login_tokens" :value="__('settings.admin.daily_login_tokens')"/>
                        <x-text-input
                            id="login_tokens"
                            class="block mt-1 w-full"
                            type="number"
                            name="login_tokens"
                            :value="old('login_tokens', $settings->loginTokens ?? 0)"
                            required
                            placeholder="0"
                        />
                        <x-input-error :messages="$errors->get('login_tokens')" class="mt-2"/>
                    </div>

                    <div class="mt-2">
                        <label for="is_payment_live" class="inline-flex items-center">
                            <input
                                id="is_payment_live"
                                type="checkbox"
                                @if($settings->isPaymentLive) checked @endif
                                class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                name="is_payment_live"
                            >
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('settings.admin.is_live_payments') }}</span>
                            <x-input-error :messages="$errors->get('is_payment_live')" class="mt-2"/>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('settings.admin.save') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
