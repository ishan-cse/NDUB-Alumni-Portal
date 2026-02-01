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
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="{{ route('update_student_information') }}" enctype="multipart/form-data">    
            @csrf
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title"><h4><i class="fab fa-gg-circle"></i><b> Edit Information</b></h4></h4>
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

                <input type="hidden" name="id" value="{{$user->id}}">

                <div class="form-group row mb-3 @error('name') is-invalid @enderror">
                    <label class="col-sm-3 col-form-label"><b>Name:<span class="text-danger">*</span></b></label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="{{$user->name}}" readonly>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                </div>

                <div class="form-group row mb-3 @error('program') is-invalid @enderror">
                    <label class="col-sm-3 col-form-label"><b>Program:<span
                                class="text-danger">*</span></b></label>
                    <div class="col-sm-6">
                        <select name="program" id="program" class="form-control" readonly>
                            <option value="">Select your program</option>
                            @forelse ($programs as $program )
                            @if($user->bachelor_program_status==1)
                                @if($program->is_program_from_master==0)
                            <option value="{{ $program->program_id }}" @if ( $user->program_id ==
                                $program->program_id) selected @endif >{{ $program->program_name }}
                            </option>
                                @endif
                            @endif
                            @if($user->master_program_status==1)
                                @if($program->is_program_from_master==1)
                            <option value="{{ $program->program_id }}" @if ( $user->program_id ==
                                $program->program_id) selected @endif >{{ $program->program_name }}
                            </option>
                                @endif
                            @endif
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
                    <label class="col-sm-3 col-form-label"><b>Batch:<span
                                class="text-danger">*</span></b></label>
                    <div class="col-sm-6">
                        <select name="batch" id="batch" class="form-control" readonly>
                            <option value="">Select your batch</option>
                            @forelse ($batchs as $batch )
                            <option value="{{ $batch->batch_id }}" @if ( $user->batch_id ==
                                $batch->batch_id) selected @endif >{{ $batch->batch_name }}
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

                <div class="form-group row mb-3 @error('major') is-invalid @enderror">
                    <label class="col-sm-3 col-form-label"><b>Major: (If Applicable)<span class="text-danger"></span></b></label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="major" value="{{$user->major}}" placeholder="According to the transcript">
                    @error('major')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                </div>

                <div class="form-group row mb-3 @error('minor') is-invalid @enderror">
                    <label class="col-sm-3 col-form-label"><b>Minor: (If Applicable)<span class="text-danger"></span></b></label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="minor" value="{{$user->minor}}" placeholder="According to the transcript">
                    @error('minor')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                </div>

                <div class="form-group row mb-3 @error('admission_year') is-invalid @enderror">
                    <label class="col-sm-3 col-form-label"><b>Admission Year:<span class="text-danger">*</span></b></label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="admission_year" value="{{$user->admission_year}}" placeholder="According to the transcript" required>
                    @error('admission_year')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                </div>

                <div class="form-group row mb-3 @error('admission_semester') is-invalid @enderror">
                    <label class="col-sm-3 col-form-label"><b>Admission Trimester/Semester:<span class="text-danger">*</span></b></label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="admission_semester" value="{{$user->admission_semester}}" placeholder="According to the transcript" required>
                    @error('admission_semester')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                </div>
                
                <div class="form-group row mb-3 @error('passing_year') is-invalid @enderror">
                    <label class="col-sm-3 col-form-label"><b>Passing Year:<span class="text-danger">*</span></b></label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="passing_year" value="{{$user->passing_year}}" placeholder="According to the transcript" required>
                    @error('passing_year')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                </div>

                <div class="form-group row mb-3 @error('passing_trimester') is-invalid @enderror">
                    <label class="col-sm-3 col-form-label"><b>Passing Trimester/Semester:<span class="text-danger">*</span></b></label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="passing_trimester" value="{{$user->passing_trimester}}" placeholder="According to the transcript" required>
                    @error('passing_trimester')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                </div>
                
                <hr>
                <div class="text-center text-bold"><h4>Employment Status (If any)</h4>
                </div>
                <hr>
                <div class="text-danger text-bold mb-4">
                    *If no employment status information is available, fill these fields with 'N/A'.<br>
                </div>
                <div class="form-group row mb-3 @error('organization_name') is-invalid @enderror">
                    <label class="col-sm-3 col-form-label"><b> Name of the Organization:<span class="text-danger">*</span></b></label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="organization_name" value="{{$user->organization_name}}" required>
                    @error('organization_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                </div>

                <div class="form-group row mb-3 @error('designation') is-invalid @enderror">
                    <label class="col-sm-3 col-form-label"><b>Designation:<span class="text-danger">*</span></b></label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="designation" value="{{$user->designation}}" required>
                    @error('designation')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                </div>

                <div class="form-group row mb-3 @error('office_address') is-invalid @enderror">
                    <label class="col-sm-3 col-form-label"><b>Office Address:<span
                                class="text-danger">*</span></b></label>
                    <div class="col-sm-6">
                        <textarea type="text" class="form-control" name="office_address" required>{{ $user->office_address }}</textarea>
                        @error('office_address')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-3 @error('office_phone') is-invalid @enderror">
                    <label class="col-sm-3 col-form-label"><b>Office Telephone No.:<span class="text-danger">*</span></b></label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="office_phone" value="{{$user->office_phone}}" required>
                    @error('office_phone')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                </div>

                <div class="form-group row mb-3 @error('office_mobile') is-invalid @enderror">
                    <label class="col-sm-3 col-form-label"><b>Office Mobile:<span class="text-danger">*</span></b></label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="office_mobile" value="{{$user->office_mobile}}" required>
                    @error('office_mobile')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                </div>

                <div class="form-group row mb-3 @error('employer_email') is-invalid @enderror">
                    <label class="col-sm-3 col-form-label"><b>Employer Email:<span class="text-danger"></span></b></label>
                    <div class="col-sm-6">
                    <input type="email" class="form-control" name="employer_email" value="{{$user->employer_email}}">
                    @error('employer_email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                </div>

                <div class="form-group row mb-3 @error('higher_studies') is-invalid @enderror">
                    <label class="col-sm-3 col-form-label"><b>Pursuing Higher Studies:<span class="text-danger"></span></b></label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="higher_studies" value="{{$user->higher_studies}}">
                    @error('higher_studies')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                </div>

                <div class="form-group row mb-3 @error('self_emp') is-invalid @enderror">
                    <label class="col-sm-3 col-form-label"><b>Self-employed:<span class="text-danger"></span></b></label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="self_emp" value="{{$user->self_emp}}">
                    @error('self_emp')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                </div>

                <div class="form-group row mb-3 @error('other') is-invalid @enderror">
                    <label class="col-sm-3 col-form-label"><b>Other::<span class="text-danger"></span></b></label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="other" value="{{$user->other}}">
                    @error('other')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                </div>
                <hr>
                
                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-md btn-primary">Update</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection