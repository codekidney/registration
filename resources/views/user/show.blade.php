@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    Profile
                    <a href="{{ route('user_edit') }}" class="btn btn-primary float-right">Edit</a>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row">First Name</th>
                                <td>{{ $user->first_name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Last Name</th>
                                <td>{{ $user->last_name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">E-mail</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Pesel</th>
                                <td>{{ $user->pesel }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Języki programowania</th>
                                <td>
                                    @foreach ($user->languages as $lang)
                                        <span class="lang">{{ $lang->name }}</span>, 
                                    @endforeach
                                </td>
                            </tr>
                        </tbody>
                    </table>                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection