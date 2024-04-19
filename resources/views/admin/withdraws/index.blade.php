<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 py-7">
                <div class="flex flex-row justify-between">
                    <h1 class="text-3xl text-center	text-gray-900 dark:text-gray-100">{{__('withdraw.admin.index.title')}}</h1>
                </div>

                <table class="mt-5 min-w-full text-left text-gray-900 dark:text-gray-100">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="text-left">
                        <th scope="col" class="px-6 py-3">#</th>
                        <th scope="col" class="px-6 py-3">{{__('withdraw.admin.index.user_name')}}</th>
                        <th scope="col" class="px-6 py-3">{{__('withdraw.admin.index.amount')}}</th>
                        <th scope="col" class="px-6 py-3">{{__('withdraw.admin.index.status')}}</th>
                        <th scope="col" class="px-6 py-3">{{__('withdraw.admin.index.created_at')}}</th>
                        <th scope="col" class="px-6 py-3 text-center">{{__('withdraw.admin.index.actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($withdraws as $withdraw)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ ($withdraws->currentPage() - 1) * $withdraws->perPage() + $loop->index + 1 }}</td>
                            <td class="px-6 py-4">{{ $withdraw->entity->name }}</td>
                            <td class="px-6 py-4">${{ $withdraw->withdraw_history_amount->getAmountString() }}</td>
                            <td class="px-6 py-4">{{ $withdraw->withdraw_status->title() }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($withdraw->created_at)->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{route('admin.withdraws.edit', $withdraw->withdraw_uuid)}}">
                                    <x-secondary-button>
                                        {{__('withdraw.admin.index.details')}}
                                    </x-secondary-button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="mt-5">
                    {{ $withdraws->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
