<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('New Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Transaction Detail Input') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Input detail information of a new Transaction.") }}
                            </p>
                        </header>


                        <form method="POST"  action="{{ route('transactions.save') }}" class="mt-6 space-y-6">
                            @csrf

                            <div>
                                <x-input-label for="amount" :value="__('Amount / USD $')" />
                                <x-text-input id="amount" name="amount" type="number" class="mt-1 block w-full"  required autofocus autocomplete="amount" />
                                <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                            </div>

                            <div>
                                <x-input-label for="payer" :value="__('Payer')" />
                                <x-text-input id="payer" name="payer" type="text" class="mt-1 block w-full"  required autofocus autocomplete="payer" />
                                <x-input-error class="mt-2" :messages="$errors->get('payer')" />
                            </div>

                            <div>
                                <x-input-label for="due_on" :value="__('Due On')" />
                                <x-text-input  id="due_on" name="due_on" type="date" class="mt-1 block w-full"  required autofocus autocomplete="due_on" />
                                <x-input-error class="mt-2" :messages="$errors->get('due_on')" />
                            </div>

                            <div>
                                <x-input-label for="vat" :value="__('VAT')" />
                                <x-text-input id="vat" name="vat" type="number" min="0" max="100" step="1" class="mt-1 block w-full"  required autofocus autocomplete="vat" />
                                <x-input-error class="mt-2" :messages="$errors->get('vat')" />
                            </div>

                            <div>
                                <x-input-label for="is_vat_inclusive" :value="__('Is VAT Inclusive')" />
                                <input id="is_vat_inclusive" name="is_vat_inclusive" type="checkbox"  class="mt-1 block w-10"  autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('is_vat_inclusive')" />
                            </div>

                            <div class="flex items-center gap-4">
{{--                                <x-primary-button>{{ __('Save') }}</x-primary-button>--}}
                                <input type="submit" value="Save">
                            </div>
                        </form>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
