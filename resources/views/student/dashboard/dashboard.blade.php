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
   
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            <hr>
            <h3 class="text-center">Information</h3>
            <hr>
            </div>
            
            <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 col-md-9">
                            <h4 class="card-title"><i class="fab fa-gg-circle"></i><b> My Information</b></h4>
                        </div>
                        <div class="col-12 col-md-3 text-center">
                            @php
                            use Illuminate\Support\Facades\Crypt;
                            $graduate_list_id =  Crypt::encryptString($user->id);
                            @endphp
                            
                                <a class="btn btn-info" href="{{ route('edit_student_information', ['id' => $graduate_list_id]) }}" title="Edit">Edit Information</a>
                               
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover dt-responsive view_table">
                        <thead class="thead-dark">
                        </thead>
                        <tbody>
                        <tr>
                        <td><b>Name</b></td>
                        <td>:</td>
                        <td>{{$user->name ? $user->name : ''}}</td>
                        </tr>
                        <tr>
                        <td><b>Student ID</b></td>
                        <td>:</td>
                        <td>{{$user->student_id ? $user->student_id : ''}}</td>
                        </tr>
                        <tr>
                        <td><b>Program</b></td>
                        <td>:</td>
                        <td>
                            @if($user->program_id!=0)
                            {{$user->programInfo->program_name ? $user->programInfo->program_name : ''}}
                            @endif
                        </td>
                        </tr>
                        <tr>
                        <td><b>Batch</b></td>
                        <td>:</td>
                        <td>
                            @if($user->batch_id!=0)
                            {{$user->batchInfo->batch_name ? $user->batchInfo->batch_name : ''}}
                            @endif
                        </td>
                        </tr>
                        <tr>
                        <td><b>Major</b></td>
                        <td>:</td>
                        <td>{{$user->major ? $user->major : ''}}</td>
                        </tr>
                        <tr>
                        <td><b>Minor</b></td>
                        <td>:</td>
                        <td>{{$user->minor ? $user->minor : ''}}</td>
                        </tr>
                        <tr>
                        <td><b>Admission Year</b></td>
                        <td>:</td>
                        <td>{{$user->admission_year ? $user->admission_year : ''}}</td>
                        </tr>
                        <tr>
                        <td><b>Admission Trimester/Semester</b></td>
                        <td>:</td>
                        <td>{{$user->admission_semester ? $user->admission_semester : ''}}</td>
                        </tr>
                        <tr>
                        <td><b>Passing Year</b></td>
                        <td>:</td>
                        <td>{{$user->passing_year ? $user->passing_year : ''}}</td>
                        </tr>
                        <tr>
                        <td><b>Passing Trimester/Semester</b></td>
                        <td>:</td>
                        <td>{{$user->passing_trimester ? $user->passing_trimester : ''}}</td>
                        </tr>
                        
                        <tr>
                        <td></td>
                        <td></td>
                        <td><div class="text-bold"><h4>Employment Status (If any)</h4></div></td>
                        </tr>
                        <tr>
                        <td><b>Name of the Organization</b></td>
                        <td>:</td>
                        <td>{{$user->organization_name ? $user->organization_name : ''}}</td>
                        </tr>
                        <tr>
                        <td><b>Designation</b></td>
                        <td>:</td>
                        <td>{{$user->designation ? $user->designation : ''}}</td>
                        </tr>
                        <tr>
                        <td><b>Office Address</b></td>
                        <td>:</td>
                        <td>{{$user->office_address ? $user->office_address : ''}}</td>
                        </tr>
                        <tr>
                        <td><b>Office Telephone No.</b></td>
                        <td>:</td>
                        <td>{{$user->office_phone ? $user->office_phone : ''}}</td>
                        </tr>
                        <tr>
                        <td><b>Office Mobile</b></td>
                        <td>:</td>
                        <td>{{$user->office_mobile ? $user->office_mobile : ''}}</td>
                        </tr>
                        <tr>
                        <td><b>Employer Email</b></td>
                        <td>:</td>
                        <td>{{$user->employer_email ? $user->employer_email : ''}}</td>
                        </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
                <div class="card-footer">
               
                </div>
            </div>
        </div>
        </div>

       
                       
                        </tbody>
                    </table>
                    </div>
                </div>
                <div class="card-footer">
               
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection