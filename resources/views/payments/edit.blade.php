<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('New Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Payment Detail Input') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __("Input detail information of a new Payment.") }}
                        </p>
                    </header>


                    <form method="POST"  action="{{ route('payments.save') }}" class="mt-6 space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="transaction" :value="__('Transaction ID')" />
                            <x-text-input id="transaction" value="{{$transaction}}"  name="transaction" type="number" class="mt-1 block w-full"  required autofocus autocomplete="transaction" />
                            <x-input-error class="mt-2" :messages="$errors->get('transaction')" />
                        </div>

                        <div>
                            <x-input-label for="amount" :value="__('Amount / USD $')" />
                            <x-text-input id="amount" name="amount" type="number" class="mt-1 block w-full"  required autofocus autocomplete="amount" />
                            <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                        </div>


                        <div>
                            <x-input-label for="paid_on" :value="__('Paid On')" />
                            <x-text-input  id="paid_on" value="{{date('n/d/Y')}}" name="paid_on" type="date" class="mt-1 block w-full"  required autofocus autocomplete="paid_on" />
                            <x-input-error class="mt-2" :messages="$errors->get('paid_on')" />
                        </div>

                        <div>
                            <x-input-label for="detail" :value="__('Detail')" />
                            <x-text-input id="detail" name="detail" type="text" class="mt-1 block w-full"  required autofocus autocomplete="detail" />
                            <x-input-error class="mt-2" :messages="$errors->get('detail')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
