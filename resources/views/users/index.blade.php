@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    User
                    <div class="float-right">
                        Created: 
                        <a href="{{ url('/admin/users/last/3') }}" class="btn btn-primary @if($daysFilter === 3){{'active'}}@endif">3 days</a>
                        <a href="{{ url('/admin/users/last/7') }}" class="btn btn-primary @if($daysFilter === 7){{'active'}}@endif">7 days</a>
                        <a href="{{ url('/admin/users/last/30') }}" class="btn btn-primary @if($daysFilter === 30){{'active'}}@endif">30 days</a>
                    </div>
                </div>                
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>First/Last Name</th>
                                <th>Pesel</th>
                                <th>Birth</th>
                                <th>Age</th>
                                <th>Languages</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            @php
                            $birth = Helper::peselDate($user->pesel);
                            $tillMature = Helper::timeToMaturity($birth);
                            @endphp
                            <tr>
                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td>{{ $user->pesel }}</td>
                                <td>{{ $birth->format('Y-m-d') }} @if ($tillMature)<br />till mature: {{ $tillMature->years }} years, {{ $tillMature->days }} days @endif</td>
                                <td>{{ Helper::age($birth) }}</td>
                                <td>{{ Helper::propByComma($user,'languages') }}</td>
                                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>    
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection