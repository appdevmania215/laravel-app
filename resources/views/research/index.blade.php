<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Research') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-2 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex w-full p-10" >
                    <form method="POST" action="{{route('research.research')}}" class="mt-6 p-6 space-y-6 space-x-10" >
                        @csrf
                        <div>
                            <x-input-label for="start" :value="__('Start')" />
                            <x-text-input  id="start" value='{{count($researchResults)>0?$researchResults[0]->year."-".$researchResults[0]->month."-01":date("Y-m-d")}}' name="start" type="date" class="mt-1 block w-full"  required autofocus autocomplete="start" />
                            <x-input-error class="mt-2" :messages="$errors->get('start')" />
                        </div>
                        <div>
                            <x-input-label for="to" :value="__('To')" />
                            <x-text-input  id="to" value='{{count($researchResults)>0?$researchResults[count($researchResults)-1]->year."-".$researchResults[count($researchResults)-1]->month."-30":date("Y-m-d")}}' name="to" type="date" class="mt-1 block w-full"  required autofocus autocomplete="to" />
                            <x-input-error class="mt-2" :messages="$errors->get('to')" />
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Research') }}</x-primary-button>
                        </div>
                    </form>
                </div>
                <div>
                    <table class="w-full text-center" >
                        <caption>Report of Research</caption>
                        <thead>
                            <tr>
                                <td class="w-1/12" >
                                    Year
                                </td>
                                <td class="w-1/12" >
                                    Month
                                </td>
                                <td class="w-1/12" >
                                    Paid
                                </td>
                                <td class="w-1/12" >
                                    Outstanding
                                </td>
                                <td class="w-1/12" >
                                    Overdue
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($researchResults as $researchMonth)
                            <tr>
                                <td class="w-1/12" >
                                    {{$researchMonth->year}}
                                </td>
                                <td class="w-1/12" >
                                    {{$researchMonth->month}}
                                </td>
                                <td class="w-1/12" >
                                    {{$researchMonth->paid}}
                                </td>
                                <td class="w-1/12" >
                                    {{$researchMonth->outstanding}}
                                </td>
                                <td class="w-1/12" >
                                    {{$researchMonth->overdue}}
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
