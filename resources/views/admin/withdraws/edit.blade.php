<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 py-7">
                <div class="flex flex-row justify-between">
                    <h1 class="text-3xl text-center	text-gray-900 dark:text-gray-100">{{__('withdraw.admin.details.title')}}</h1>
                </div>

                @if( session()->has('success') )
                    <div class="p-4 mt-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border" role="alert">
                        {{ session()->get('success') }}
                    </div>
                @endif

                <p class="my-3 text-gray-900 dark:text-gray-100">
                    <b>{{__('withdraw.admin.details.system_id')}}</b> {{$withdraw->withdraw_uuid}}
                </p>
                <p class="my-3 text-gray-900 dark:text-gray-100">
                    <b>{{__('withdraw.admin.details.status')}}</b> {{$withdraw->withdraw_status->title()}}
                </p>
                <p class="my-3 text-gray-900 dark:text-gray-100">
                    <b>{{__('withdraw.admin.details.amount')}}</b> ${{$withdraw->withdraw_history_amount->getAmountString()}}
                </p>
            </div>

            @if(isset($withdraw->entity->bank))
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 py-7 mt-5">
                    <div class="flex flex-row justify-between">
                        <h1 class="text-3xl text-center	text-gray-900 dark:text-gray-100">{{__('withdraw.admin.bank.title')}}</h1>
                    </div>

                    <p class="my-3 text-gray-900 dark:text-gray-100">
                        <b>{{__('withdraw.admin.bank.account_name')}}</b> {{$withdraw->entity->bank->account_name}}
                    </p>
                    <p class="my-3 text-gray-900 dark:text-gray-100">
                        <b>{{__('withdraw.admin.bank.account_number')}}</b> {{$withdraw->entity->bank->account_number}}
                    </p>
                    <p class="my-3 text-gray-900 dark:text-gray-100">
                        <b>{{__('withdraw.admin.bank.bank_name')}}</b> {{$withdraw->entity->bank->bank_name}}
                    </p>
                    <p class="my-3 text-gray-900 dark:text-gray-100">
                        <b>{{__('withdraw.admin.bank.ifsc')}}</b> {{$withdraw->entity->bank->ifsc_code}}
                    </p>
                </div>
            @endif

            @if($withdraw->withdraw_status->value === "pending")
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 py-7 mt-5">
                    <div class="flex flex-row justify-between">
                        <h1 class="text-3xl text-center	text-gray-900 dark:text-gray-100">{{__('Process Withdraw')}}</h1>
                    </div>

                    <form method="POST" action="{{ route('admin.withdraws.save', $withdraw->withdraw_uuid) }}">
                        @csrf

                        <div class="mt-2">
                            <x-input-label for="withdraw_status" :value="__('Withdraw Status')"/>
                            <select id="withdraw_status" name="withdraw_status"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                <option selected disabled>Choose the status</option>
                                <option value="accepted">Accepted</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <x-input-error :messages="$errors->get('withdraw_status')" class="mt-2"/>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Save') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
