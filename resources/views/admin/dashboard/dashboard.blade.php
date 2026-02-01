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
<!-- card start -->
<div class="container-fluid">
    <div class="row">
        
        <div class="col-12 col-md-3">
            <div class="card bg-dark">
                <h5 class="card-header">Not signed up yet</h5>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                        <p class="card-text">
                            {{$notSignUp}}
                        </p>
                        <br>
                    <!-- <a href="" class="btn btn-primary"></a> -->
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-3">
            <div class="card" style="background-color: #9fd609; color: white;">
                <h5 class="card-header">Signed up but did not complete registration</h5>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                        <p class="card-text">
                            {{$SignUpNotRegistered}}
                        </p>
                        <br>
                    <!-- <a href="" class="btn btn-primary"></a> -->
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-3">
            <div class="card" style="background-color: #9327d6; color: white;">
                <h5 class="card-header">Information completed, but documents were not uploaded</h5>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                        <p class="card-text">
                            {{$InfoFillUp}}
                        </p>
                        <br>
                    <!-- <a href="" class="btn btn-primary"></a> -->
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-3">
            <div class="card" style="background-color: #1fe31b; color: white;">
                <h5 class="card-header">Total Registration Completed</h5>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                        <p class="card-text">
                            {{$TotalRegistrationComplete}}
                        </p>
                        <br>
                    <!-- <a href="" class="btn btn-primary"></a> -->
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-3">
            <div class="card" style="background-color: #E024E3; color: white;">
                <h5 class="card-header">Registered for One Program (Bachelor or Master)</h5>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                        <p class="card-text">
                            <b>{{$TotalRegisteredOneProgram}}</b><br><br>
                            <a href="{{ route('registrationCompletedStudentListSingleProgramInExcel') }}" class="btn btn-light">Download</a>
                        </p>
                        <br>
                    <!-- <a href="" class="btn btn-primary"></a> -->
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-3">
            <div class="card" style="background-color: #f20a0a; color: white;">
                <h5 class="card-header">Registered for Both programs (Bachelor and Master)</h5>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                        <p class="card-text">
                            <b>{{$TotalRegisteredDoubleProgram}}</b><br><br>
                            <a href="{{ route('registrationCompletedStudentListDoubleProgramInExcel') }}" class="btn btn-light">Download</a>
                        </p>
                        <br>
                    <!-- <a href="" class="btn btn-primary"></a> -->
                </div>
            </div>
        </div>
        
        
        <div class="col-12 col-md-3">
            <div class="card" style="background-color: #ed1f6a; color: white;">
                <h5 class="card-header">Download Unregistered Student List</h5>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                        <p class="card-text">
                            <b>Total Unregistered Student Number: {{$TotalUnregisteredStudent}}</b> <br><br>
                            <a href="{{ route('unRegisteredStudentListInExcel') }}" class="btn btn-light">Download</a>
                        </p>
                        <br>
                    <!-- <a href="" class="btn btn-primary"></a> -->
                </div>
            </div>
        </div>
        
        <!-- Registration confirmed information -->
        
        <div class="col-12 col-md-3">
            <div class="card" style="background-color: #0e89ed; color: white;">
                <h5 class="card-header">Total Registration Confirmed</h5>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                        <p class="card-text">
                            {{$TotalRegistrationConfirmed}}
                        </p>
                        <br>
                    <!-- <a href="" class="btn btn-primary"></a> -->
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-3">
            <div class="card" style="background-color: #ed0e85; color: white;">
                <h5 class="card-header">Registration Confirmed for One Program (Bachelor or Master)</h5>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                        <p class="card-text">
                            <b>{{$TotalRegistrationConfirmedOneProgram}}</b><br><br>
                            <a href="{{ route('registrationConfirmedStudentListSingleProgramInExcel') }}" class="btn btn-light">Download</a>
                        </p>
                        <br>
                    <!-- <a href="" class="btn btn-primary"></a> -->
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-3">
            <div class="card" style="background-color: #ed810e; color: white;">
                <h5 class="card-header">Registration Confirmed for Both programs (Bachelor and Master)</h5>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                        <p class="card-text">
                            <b>{{$TotalRegistrationConfirmedDoubleProgram}}</b><br><br>
                            <a href="{{ route('registrationConfirmedStudentListDoubleProgramInExcel') }}" class="btn btn-light">Download</a>
                        </p>
                        <br>
                    <!-- <a href="" class="btn btn-primary"></a> -->
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-3">
            <div class="card bg-danger" style="color: white;">
                <h5 class="card-header">Registration Completed but not confirmed - One program (Bachelor or Master)</h5>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                        <p class="card-text">
                            <b>Single + Double = {{$TotalRegistrationCompletedButNotConfirmed}}</b><br><br>
                            <a href="{{ route('totalRegistrationCompletedButNotConfirmedSingleProgramInExcel') }}" class="btn btn-light">Download</a>
                        </p>
                        <br>
                    <!-- <a href="" class="btn btn-primary"></a> -->
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-3">
            <div class="card bg-danger" style="color: white;">
                <h5 class="card-header">Registration Completed but not confirmed - Both programs (Bachelor and Master)</h5>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                        <p class="card-text">
                            <b>Single + Double = {{$TotalRegistrationCompletedButNotConfirmed}}</b><br><br>
                            <a href="{{ route('totalRegistrationCompletedButNotConfirmedDoubleProgramInExcel') }}" class="btn btn-light">Download</a>
                        </p>
                        <br>
                    <!-- <a href="" class="btn btn-primary"></a> -->
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-3">
            <div class="card" style="background-color: #7242f5; color: white;">
                <h5 class="card-header">Entry Pass Generator</h5>
                    <form method="get" action="{{ route('adminAllSelectedEntryPassPDF') }}" enctype="multipart/form-data">    
                    @csrf
                        <div class="form-group row mb-3 @error('program') is-invalid @enderror pt-3">
                            <label class="col-sm-3 col-form-label"><b><span
                                        class="text-danger"></span></b></label>
                            <div class="col-sm-6">
                                <select name="program" id="program" class="form-control" required>
                                    <option value="">Select Program</option>
                                    @forelse ($programs as $program )
                                    <option value="{{ $program->program_id }}">{{ $program->program_name }}
                                    </option>
                                    @empty
                                    No program found
                                    @endforelse
                                </select>
                                @error('program')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
        
                        <div class="form-group row mb-3 @error('batch') is-invalid @enderror">
                            <label class="col-sm-3 col-form-label"><b><span
                                        class="text-danger"></span></b></label>
                            <div class="col-sm-6">
                                <select name="batch" id="batch" class="form-control" required>
                                    <option value="">Select Batch</option>
                                    @forelse ($batchs as $batch )
                                    <option value="{{ $batch->batch_id }}">{{ $batch->batch_name }}
                                    </option>
                                    @empty
                                    No batch found
                                    @endforelse
                                </select>
                                @error('batch')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> 
        
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-md btn-light">Generate</button>
                        </div>
                        </form>
                    </div>
                </div>
                <br>
                    <!-- <a href="" class="btn btn-primary"></a> -->
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-3">
            <div class="card" style="background-color: #7242f5; color: white;">
                <h5 class="card-header">Report Generator</h5>
                    <form method="get" action="{{ route('adminAllSelectedStudentListInExcel') }}" enctype="multipart/form-data">    
                    @csrf
                        <div class="form-group row mb-3 @error('program') is-invalid @enderror pt-3">
                            <label class="col-sm-3 col-form-label"><b><span
                                        class="text-danger"></span></b></label>
                            <div class="col-sm-6">
                                <select name="program" id="program" class="form-control" required>
                                    <option value="">Select Program</option>
                                    @forelse ($programs as $program )
                                    <option value="{{ $program->program_id }}">{{ $program->program_name }}
                                    </option>
                                    @empty
                                    No program found
                                    @endforelse
                                </select>
                                @error('program')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
        
                        <div class="form-group row mb-3 @error('batch') is-invalid @enderror">
                            <label class="col-sm-3 col-form-label"><b><span
                                        class="text-danger"></span></b></label>
                            <div class="col-sm-6">
                                <select name="batch" id="batch" class="form-control" required>
                                    <option value="">Select Batch</option>
                                    @forelse ($batchs as $batch )
                                    <option value="{{ $batch->batch_id }}">{{ $batch->batch_name }}
                                    </option>
                                    @empty
                                    No batch found
                                    @endforelse
                                </select>
                                @error('batch')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> 
        
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-md btn-light">Generate</button>
                        </div>
                        </form>
                    </div>
                </div>
                <br>
                    <!-- <a href="" class="btn btn-primary"></a> -->
                </div>
            </div>
        </div>
        
    </div>
</div>
@endif
<!-- card end -->
@endsection