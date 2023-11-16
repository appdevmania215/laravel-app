<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Transactions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 inline">
                    <table class="text-center w-full" >
                        <caption>Transaction Detail</caption>
                        <thead>
                            <tr>
                                <td class="w-1/12" >Amount</td>
                                <td class="w-1/12" >Paid</td>
                                <td class="w-1/12" >Payer</td>
                                <td class="w-1/12" >Due Date</td>
                                <td class="w-1/12" >VAT</td>
                                <td class="w-1/12" >Is VAT Inclusive?</td>
                                <td class="w-1/12" >Status</td>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="w-1/12" >{{$transaction->amount}} USD $</td>
                            <td class="w-1/12" >{{$transaction->paid()}} USD $</td>
                            <td class="w-1/12" >{{$transaction->payer}}</td>
                            <td class="w-1/12" >{{$transaction->due_on}}</td>
                            <td class="w-1/12" >{{$transaction->vat}}</td>
                            <td class="w-1/12" >{{$transaction->is_vat_inclusive==1?"Yes":"No"}}</td>
                            <td class="w-1/12" >{{$transaction->status()}}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="m-1.5" >
                        <a href="/transactions/{{$transaction->id}}/add-payment" ><x-primary-button >{{ __('New Payment') }}</x-primary-button></a>
                    </div>
                    @if(count($payments)>0)
                    <table class="text-center w-full" >
                        <caption>Payments Detail</caption>
                        <thead>
                        <tr>
                            <td class="w-1/12" >Amount</td>
                            <td class="w-1/12" >Paid Date</td>
                            <td class="w-1/12" >Payment Detail</td>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($payments as $payment)
                        <tr>
                            <td class="w-1/12" >{{$payment->amount}} USD $</td>
                            <td class="w-1/12" >{{$payment->paid_on}}</td>
                            <td class="w-1/12" >{{$payment->detail}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
