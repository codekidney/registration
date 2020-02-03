@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    Programming Languages
                </div>                
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Amount of users</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($languages as $lang)
                            <tr>
                                <td>{{ $lang->name }}</td>
                                <td>{{ $lang->users_count }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>    
                    {{ $languages->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection