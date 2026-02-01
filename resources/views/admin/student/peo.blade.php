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
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="{{ route('submit_peo') }}" enctype="multipart/form-data">    
            @csrf
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title"><h4><i class="fab fa-gg-circle"></i><b> PEO Form</b></h4></h4>
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

                <div class="form-group row mb-3 @error('b1') is-invalid @enderror">
                    <label class="col-sm-7 col-form-label">
                        <b>
                            PEO 1 (Professionalism): My degree helped me develop professionalism including problem-solving,
                            teamwork, ethics, leadership, and communication skills.
                            <span class="text-danger">*</span>
                        </b>
                    </label>

                    <div class="col-sm-4 d-flex justify-content-between">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="b1" id="b1_{{ $i }}" value="{{ $i }}" 
                                    {{ old('b1') == $i ? 'checked' : '' }} required>
                                <label class="form-check-label" for="b1_{{ $i }}">{{ $i }}</label>
                            </div>
                        @endfor
                    </div>

                    @error('b1')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group row mb-3 @error('b2') is-invalid @enderror">
                    <label class="col-sm-7 col-form-label">
                        <b>
                            PEO 2 (Continuous Self-Development): My degree encouraged
lifelong learning, higher studies, professional training, and
adaptability.
                            <span class="text-danger">*</span>
                        </b>
                    </label>

                    <div class="col-sm-4 d-flex justify-content-between">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="b2" id="b2_{{ $i }}" value="{{ $i }}" 
                                    {{ old('b2') == $i ? 'checked' : '' }} required>
                                <label class="form-check-label" for="b2_{{ $i }}">{{ $i }}</label>
                            </div>
                        @endfor
                    </div>

                    @error('b2')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group row mb-3 @error('b3') is-invalid @enderror">
                    <label class="col-sm-7 col-form-label">
                        <b>
                            PEO 3 (Sustainable Development): My degree increased my
awareness of societal/environmental issues and sustainable
development.
                            <span class="text-danger">*</span>
                        </b>
                    </label>

                    <div class="col-sm-4 d-flex justify-content-between">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="b3" id="b3_{{ $i }}" value="{{ $i }}" 
                                    {{ old('b3') == $i ? 'checked' : '' }} required>
                                <label class="form-check-label" for="b3_{{ $i }}">{{ $i }}</label>
                            </div>
                        @endfor
                    </div>

                    @error('b3')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group row mb-3 @error('c1') is-invalid @enderror">
                    <label class="col-sm-5 col-form-label"><b>What are the strengths of the program in supporting your professional career?:<span class="text-danger">*</span></b></label>
                    <div class="col-sm-7">
                    <input type="text" class="form-control" name="c1" value="{{ old('c1') }}" required>
                    @error('c1')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                </div>

                <div class="form-group row mb-3 @error('c2') is-invalid @enderror">
                    <label class="col-sm-5 col-form-label"><b>What areas of the program could be improved to achieve the PEOs better?:<span class="text-danger">*</span></b></label>
                    <div class="col-sm-7">
                    <input type="text" class="form-control" name="c2" value="{{ old('c2') }}" required>
                    @error('c2')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                </div>

                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-md btn-primary">Submit</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection