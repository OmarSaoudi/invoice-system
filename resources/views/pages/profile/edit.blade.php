@extends('layouts.master')

@section('title')
     Eidt Profile
@stop

@section('css')

@endsection

@section('content')

<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>
        Profile
     </h1>
     <ol class="breadcrumb">
       <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
       <li class="active">Profile</li>
     </ol>
   </section>

   <section class="content">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Update Profile Information</h3>
        </div>
        <div class="box-body">

            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                {{-- 1 --}}
                <div class="row">
                   <div class="col-md-6">
                      <div class="form-group">
                         <label>Name</label>
                         <input id="name" name="name" value="{{ old('name', $user->name) }}" type="text" class="form-control" required autofocus autocomplete="name">
                         <x-input-error class="mt-2 text-red" :messages="$errors->get('name')" />
                      </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                           <label>Email</label>
                           <input id="email" name="email" value="{{ old('email', $user->email) }}" type="email" class="form-control" required autofocus autocomplete="email">
                           <x-input-error class="mt-2 text-red" :messages="$errors->get('email')" />
                        </div>
                    </div>

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                      <div>
                        <p class="text-sm mt-2 text-gray-800">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                      </div>
                    @endif
                </div>
                {{-- End 1 --}}


                <div class="form-group" style="text-align:center">
                    <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Saving Data</button>
                    @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition
                        x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600" >{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>
        </div>
        <div class="box-header">
            <h3 class="box-title">Update Password</h3>
        </div>
        <div class="box-body">

            <form method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')

                {{-- 1 --}}
                <div class="row">

                   <div class="col-md-4">
                      <div class="form-group">
                         <label>Current Password</label>
                         <input id="current_password" name="current_password" type="password" autocomplete="current-password" class="form-control">
                         <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-red"/>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                           <label>New Password</label>
                           <input id="password" name="password" type="password" autocomplete="new-password" class="form-control">
                           <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-red"/>
                        </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                           <label>Confirm Password</label>
                           <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="form-control">
                           <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-red"/>
                        </div>
                    </div>

                </div>
                {{-- End 1 --}}


                <div class="form-group" style="text-align:center">
                    <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Saving Data</button>
                    @if (session('status') === 'password-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>
        </div>
    </div>
   </section>

</div>

@endsection

@section('scripts')

@endsection
