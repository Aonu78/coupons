<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 py-7">
                <div class="flex flex-row justify-between">
                    <h1 class="text-3xl text-center	text-gray-900 dark:text-gray-100">{{__('user.admin.details.title')}}</h1>
                </div>

                @if( session()->has('success') )
                    <div
                        class="p-4 mt-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border"
                        role="alert">
                        {{ session()->get('success') }}
                    </div>
                @endif

                <form method="POST" action="{{route('admin.games.update', $user->id)}}" enctype="multipart/form-data">
                    @csrf

                    <div class="mt-2">
                        <x-input-label for="name" :value="__('user.admin.details.name')"/>
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                      :value="old('name', $user->name)"
                                      required autofocus readonly disabled/>
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>

                    <div class="mt-2">
                        <x-input-label for="email" :value="__('user.admin.details.email')"/>
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                      :value="old('email', $user->email)"
                                      required autofocus readonly disabled/>
                        <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                    </div>

                    <div class="mt-2">
                        <label for="email_verified" class="inline-flex items-center">
                            <input
                                id="email_verified"
                                type="checkbox"
                                class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                name="email_verified"
                                readonly
                                disabled
                                @if(!is_null($user->email_verified_at)) checked @endif
                            >
                            <span
                                class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('user.admin.details.email_verified') }}</span>
                        </label>
                    </div>


                    <div class="mt-2">
                        <x-input-label for="phone_number" :value="__('user.admin.details.phone_number')"/>
                        <x-text-input
                            id="phone_number"
                            class="block mt-1 w-full"
                            type="text"
                            name="phone_number"
                            :value="old('phone_number', $user->phone_number)"
                            required
                            autofocus
                            readonly
                            disabled
                        />
                        <x-input-error :messages="$errors->get('phone_number')" class="mt-2"/>
                    </div>

                    <h2 class="text-2xl text-gray-900 dark:text-gray-100 my-3">{{__('user.admin.details.wallets')}}</h2>

                    <div class="mt-2">
                        <x-input-label for="usd_balance" :value="__('user.admin.details.usd_balance')"/>
                        <x-text-input
                            id="usd_balance"
                            class="block mt-1 w-full"
                            type="number"
                            name="usd_balance"
                            :value="old('usd_balance', $usdWallet?->wallet_balance?->getAmountString() ?? 0)"
                            required
                            autofocus
                            readonly
                            disabled
                        />
                        <x-input-error :messages="$errors->get('usd_balance')" class="mt-2"/>
                    </div>

                    <div class="mt-2">
                        <x-input-label for="cp_balance" :value="__('user.admin.details.cp_balance')"/>
                        <x-text-input
                            id="cp_balance"
                            class="block mt-1 w-full"
                            type="number"
                            name="cp_balance"
                            :value="old('cp_balance', $cpTokenWallet?->wallet_balance?->getAmountString() ?? 0)"
                            required
                            autofocus
                            readonly
                            disabled
                        />
                        <x-input-error :messages="$errors->get('cp_balance')" class="mt-2"/>
                    </div>
                </form>
            </div>

            @if(isset($user->invitedBy))
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 py-7 mt-5">
                    <div class="flex flex-row justify-between">
                        <h1 class="text-3xl text-center	text-gray-900 dark:text-gray-100">
                            {{__('user.admin.details.invited_by.title')}}
                        </h1>
                    </div>

                    <p class="my-3 text-gray-900 dark:text-gray-100">
                        <b>{{__('user.admin.details.invited_by.inviter_name')}}</b> {{$user->invitedBy->name}}
                    </p>
                    <p class="my-3 text-gray-900 dark:text-gray-100">
                        <b>{{__('user.admin.details.invited_by.inviter_email')}}</b> {{$user->invitedBy->email}}
                    </p>
                    <p class="my-3 text-gray-900 dark:text-gray-100">
                        <b>{{__('user.admin.details.invited_by.invited_at')}}</b> {{\Carbon\Carbon::parse($user->created_at)->format('Y-m-d H:i')}}
                    </p>
                </div>
            @endif

            @if($user->invitedUsers->isNotEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 py-7 mt-5">
                    <div class="flex flex-row justify-between">
                        <h1 class="text-3xl text-center	text-gray-900 dark:text-gray-100">{{__('user.admin.details.invited_users.title')}}</h1>
                    </div>

                    <table class="mt-5 min-w-full text-left text-gray-900 dark:text-gray-100">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="text-left">
                            <th scope="col" class="px-6 py-3">#</th>
                            <th scope="col" class="px-6 py-3">{{__('user.admin.details.name')}}</th>
                            <th scope="col" class="px-6 py-3">{{__('user.admin.details.email')}}</th>
                            <th scope="col" class="px-6 py-3">{{__('user.admin.details.invited_users.invited_at')}}</th>
                            <th scope="col" class="px-6 py-3 text-center">{{__('user.admin.index.actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user->invitedUsers as $invitedUser)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $loop->index + 1 }}</td>
                                <td class="px-6 py-4">{{ $invitedUser->name }}</td>
                                <td class="px-6 py-4">{{ $invitedUser->email }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($invitedUser->created_at)->format('Y-m-d H:i') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{route('admin.users.edit', $invitedUser->id)}}">
                                        <x-secondary-button>
                                            {{__('user.admin.index.show_details')}}
                                        </x-secondary-button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
