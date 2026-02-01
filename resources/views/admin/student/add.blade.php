@extends('layouts.admin.dashboard')
@section('dashboard_content')
@if(Session::has('success'))
    <script>
    Swal.fire({
        position: 'center',
        icon: 'success',
        text: '{{Session::get('success')}}',
        showConfirmButton: true,
        timer: '5000',
    })
    </script>
    @endif
    @if(Session::has('error'))
    <script>
    Swal.fire({
        position: 'center',
        icon: 'error',
        text: '{{Session::get('error')}}',
        showConfirmButton: true,
        timer: '5000',
    })
    </script>
@endif

<br>
@php
    $loggedUser = Auth::user();
@endphp
@if($loggedUser->user_slug!='Account-1')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="{{ route('submit_student') }}" enctype="multipart/form-data">    
            @csrf
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title"><h4><i class="fab fa-gg-circle"></i><b> Add Student</b></h4></h4>
                        </div>
                        <div class="col-md-4 text-right">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-7">
                    </div>
                    <div class="col-md-2"></div>
                </div>

                <div class="form-group row mb-3 @error('student_id') is-invalid @enderror">
                    <label class="col-sm-3 col-form-label"><b>Student ID:<span class="text-danger">*</span></b></label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="student_id" value="{{ old('student_id') }}" required>
                    @error('student_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                </div>

                <div class="form-group row mb-3 @error('name') is-invalid @enderror">
                    <label class="col-sm-3 col-form-label"><b>Name:<span class="text-danger">*</span></b></label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                </div>

                <div class="form-group row mb-3 @error('email') is-invalid @enderror">
                    <label class="col-sm-3 col-form-label"><b>Email:<span class="text-danger">*</span></b></label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                </div>

                <div class="form-group row mb-3 @error('program') is-invalid @enderror">
                    <label class="col-sm-3 col-form-label"><b>Program:<span
                                class="text-danger">*</span></b></label>
                    <div class="col-sm-6">
                        <select name="program" id="program" class="form-control" required>
                            <option value="">Select student program</option>
                            <option value="1">Bachelor program</option>
                            <option value="2">Master program</option>
                        </select>
                        @error('program')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-md btn-primary">Add</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection