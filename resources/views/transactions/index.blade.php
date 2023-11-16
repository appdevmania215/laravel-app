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
                    <a href="{{route('transactions.edit')}}" ><x-primary-button >{{ __('New Transaction') }}</x-primary-button></a>
                    <div class="space-y-5">
                        <table class="w-full text-center border-s-black " >
                            <thead>
                                <tr>
                                    <td class="w-1/12" ></td>
                                    <td class="w-1/12">Total Amount</td>
                                    <td class="w-1/12" >Paid</td>
                                    <td class="w-1/12">Payer</td>
                                    <td class="w-1/12">Due Date</td>
                                    <td class="w-1/12">VAT</td>
                                    <td class="w-1/12">VAT inclusive?</td>
                                    <td class="w-1/12">Status</td>
                                </tr>

                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td><a href="{{route('transactions.read',['id'=>$transaction->id])}}"><x-primary-button>{{__('View')}}</x-primary-button></a></td>
                                        <td>{{ $transaction->amount }}</td>
                                        <td>{{ $transaction->paid() }}</td>
                                        <td>{{ $transaction->payer }}</td>
                                        <td>{{ $transaction->due_on }}</td>
                                        <td>{{ $transaction->vat }}%</td>
                                        <td class="text-{{$transaction->is_vat_inclusive==1?"red":"blue"}}" >{{ $transaction->is_vat_inclusive==1?"Yes":"No" }}</td>
                                        <td>
                                            @php
                                                $status="Calculating...";
                                                 if($transaction->paid()>=$transaction->amount){
                                                     $status="Paid";
                                                 }else{
                                                    $date1 = new DateTime($transaction->due_on);
                                                    $date2 = new DateTime();
                                                    if($date1>$date2) $status="Outstanding";
                                                    else $status= "Overdue";
                                                 }
                                                // Create DateTime objects from the date texts

                                            @endphp
                                            {{$status}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                        {{$transactions->links()}}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
