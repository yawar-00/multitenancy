<x-app-layout>
    <style>
        [type=checkbox]:checked{
            background-color: #198754;
        }
        [type=checkbox]:checked:hover, [type=checkbox]:checked:focus, [type=radio]:checked:hover, [type=radio]:checked:focus {
            background-color: #198754;
            
        }
        
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 d-flex justify-content-between">
                    {{ __("You're logged in!") }}
                    <x-btn-link href="{{url('tanent/create')}}" >
                        Add Tenancy
                    </x-btn-link>
                </div>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Domain Name</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tenants as $index => $tenant)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{$tenant->name}}</td>
                            <td>{{$tenant->email}}</td>
                            <td>{{$tenant->domains->first()->domain}}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input toggleStatus"
                                    type="checkbox"
                                    role="switch"
                                    data-id="{{ $tenant->id }}"
                                    {{ $tenant->status ? 'checked' : '' }}>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
