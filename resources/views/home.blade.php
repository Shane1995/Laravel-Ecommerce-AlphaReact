@extends('layouts.app')

@section('content')
<div class="container"> @isset($success)
    <div class="alert alert-danger" role="alert">
        Your details have been updated
    </div>
    @endisset
    <div class="row justify-content-center">

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Your Details</div>
                <div class="card-body">
                    <form action="{{ route('updateUserDetails')}}" method="post" enctype="multipart/form-data">

                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                                value="{{ Auth::user()->name }}">
                            @error('name')
                            <div class="alert alert-success">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="lastName">last name</label>
                            <input type="text" class="form-control" name="lastName" id="lastName"
                                placeholder="Last Name" required value="{{ Auth::user()->lastName }}">
                            @error('lastName')
                            <div class="alert alert-success">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="email"
                                value="{{ Auth::user()->email }}">
                            @error('email')
                            <div class="alert alert-success">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="New password">
                            @error('password')
                            <div class="alert alert-success">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>

                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" required autocomplete="new-password">

                        </div>


                        <button type="submit" name="submit" class="btn btn-primary float-right">Submit</button>
                    </form>


                </div>
            </div>


        </div>

        <div style="margin-top:15px;">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <a href="{{ route('AllProducts')}}" class="btn btn-warning" style="margin-right:15px;">Main Website </a>
            @if($userData->isAdmin())
            <a href="{{ route('adminDisplayProducts')}}" class="btn btn-primary">Admin Panel</a>
            @else

            @endif
        </div>

    </div>
</div>
</div>
@endsection