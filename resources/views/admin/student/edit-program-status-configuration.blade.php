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

@php
    $loggedUser = Auth::user();
@endphp
@if($loggedUser->user_slug!='Account-1')

<br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="{{ route('admin_update_student_program_status_configuration') }}" enctype="multipart/form-data">    
            @csrf
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-11">
                            <h4 class="card-title"><h4><i class="fab fa-gg-circle"></i><b> Program Status Configuration: <br>One program (Bachelor or Master) or Both programs (Bachelor and Master)</b></h4></h4>
                        </div>
                        <div class="col-md-1 text-right">
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

                <input type="hidden" name="id" value="{{$user->id}}">
                
                <div class="form-group row mb-3 @error('student_program_choice') is-invalid @enderror">
                    <label class="col-sm-4 col-form-label"><b>Program Status Configuration<span class="text-danger">*</span></b></label>
                
                  
                    <div class="col-sm-4">
                    <input type="radio" value="1" required name="student_program_choice"
                    @php
                        if($user->student_program_choice==1){
                        echo "checked";
                        }
                    @endphp
                    >
                    <b>One program</b>
                    </div>

                    <div class="col-sm-4">
                    <input type="radio" value="3" required name="student_program_choice"
                    @php
                        if($user->student_program_choice==3){
                        echo "checked";
                        }
                    @endphp
                    >
                    <b>Both programs</b>
                    </div>
                </div>

                
                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-md btn-primary">Update</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

@endif

@endsection