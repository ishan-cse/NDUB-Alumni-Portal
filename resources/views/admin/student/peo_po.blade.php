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
            <form method="post" action="{{ route('submit_peo_po') }}" enctype="multipart/form-data">    
            @csrf
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title"><h4><i class="fab fa-gg-circle"></i><b> PEO + PO Form</b></h4></h4>
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

                <hr>
                    <center><h3>Feedback on Program Outcomes (POs)</h3></center>
                <hr>

 <div class="form-group row mb-3 @error('c1') is-invalid @enderror">
                    <label class="col-sm-7 col-form-label">
                        <b>
                            Apply engineering knowledge in practice
                            <span class="text-danger">*</span>
                        </b>
                    </label>

                    <div class="col-sm-4 d-flex justify-content-between">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="c1" id="c1_{{ $i }}" value="{{ $i }}" 
                                    {{ old('c1') == $i ? 'checked' : '' }} required>
                                <label class="form-check-label" for="c1_{{ $i }}">{{ $i }}</label>
                            </div>
                        @endfor
                    </div>

                    @error('c1')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group row mb-3 @error('c2') is-invalid @enderror">
                    <label class="col-sm-7 col-form-label">
                        <b>
                           Problem analysis and critical thinking
                            <span class="text-danger">*</span>
                        </b>
                    </label>

                    <div class="col-sm-4 d-flex justify-content-between">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="c2" id="c2_{{ $i }}" value="{{ $i }}" 
                                    {{ old('c2') == $i ? 'checked' : '' }} required>
                                <label class="form-check-label" for="c2_{{ $i }}">{{ $i }}</label>
                            </div>
                        @endfor
                    </div>

                    @error('c2')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group row mb-3 @error('c3') is-invalid @enderror">
                    <label class="col-sm-7 col-form-label">
                        <b>
                           Design and development of solutions
                            <span class="text-danger">*</span>
                        </b>
                    </label>

                    <div class="col-sm-4 d-flex justify-content-between">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="c3" id="c3_{{ $i }}" value="{{ $i }}" 
                                    {{ old('c3') == $i ? 'checked' : '' }} required>
                                <label class="form-check-label" for="c3_{{ $i }}">{{ $i }}</label>
                            </div>
                        @endfor
                    </div>

                    @error('c3')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group row mb-3 @error('c4') is-invalid @enderror">
                    <label class="col-sm-7 col-form-label">
                        <b>
                            Use of modern tools and technology
                            <span class="text-danger">*</span>
                        </b>
                    </label>

                    <div class="col-sm-4 d-flex justify-content-between">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="c4" id="c4_{{ $i }}" value="{{ $i }}" 
                                    {{ old('c4') == $i ? 'checked' : '' }} required>
                                <label class="form-check-label" for="b1_{{ $i }}">{{ $i }}</label>
                            </div>

                            
                        @endfor

                        
                    </div>

                    @error('c4')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>


                <div class="form-group row mb-3 @error('c5') is-invalid @enderror">
                    <label class="col-sm-7 col-form-label">
                        <b>
                            Communication skills (oral and written)
                            <span class="text-danger">*</span>
                        </b>
                    </label>

                    <div class="col-sm-4 d-flex justify-content-between">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="c5" id="c5_{{ $i }}" value="{{ $i }}" 
                                    {{ old('c5') == $i ? 'checked' : '' }} required>
                                <label class="form-check-label" for="c5_{{ $i }}">{{ $i }}</label>
                            </div>

                            
                        @endfor

                        
                    </div>

                    @error('c5')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                

                
                <div class="form-group row mb-3 @error('c6') is-invalid @enderror">
                    <label class="col-sm-7 col-form-label">
                        <b>
                            Teamwork and leadership ability
                            <span class="text-danger">*</span>
                        </b>
                    </label>

                    <div class="col-sm-4 d-flex justify-content-between">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="c6" id="c6_{{ $i }}" value="{{ $i }}" 
                                    {{ old('c6') == $i ? 'checked' : '' }} required>
                                <label class="form-check-label" for="c6_{{ $i }}">{{ $i }}</label>
                            </div>

                            
                        @endfor

                        
                    </div>

                    @error('c6')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                
                <div class="form-group row mb-3 @error('c7') is-invalid @enderror">
                    <label class="col-sm-7 col-form-label">
                        <b>
                            Lifelong learning and adaptability
                            <span class="text-danger">*</span>
                        </b>
                    </label>

                    <div class="col-sm-4 d-flex justify-content-between">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="c7" id="c7_{{ $i }}" value="{{ $i }}" 
                                    {{ old('c7') == $i ? 'checked' : '' }} required>
                                <label class="form-check-label" for="c7_{{ $i }}">{{ $i }}</label>
                            </div>

                            
                        @endfor

                        
                    </div>

                    @error('c7')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>


                
                <div class="form-group row mb-3 @error('c8') is-invalid @enderror">
                    <label class="col-sm-7 col-form-label">
                        <b>
                            Professional ethics and responsibility
                            <span class="text-danger">*</span>
                        </b>
                    </label>

                    <div class="col-sm-4 d-flex justify-content-between">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="c8" id="c8_{{ $i }}" value="{{ $i }}" 
                                    {{ old('c8') == $i ? 'checked' : '' }} required>
                                <label class="form-check-label" for="c8_{{ $i }}">{{ $i }}</label>
                            </div>

                            
                        @endfor

                        
                    </div>

                    @error('c8')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                
                <div class="form-group row mb-3 @error('c9') is-invalid @enderror">
                    <label class="col-sm-7 col-form-label">
                        <b>
                            Knowledge of contemporary issues and societal
impact
                            <span class="text-danger">*</span>
                        </b>
                    </label>

                    <div class="col-sm-4 d-flex justify-content-between">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="c9" id="c9_{{ $i }}" value="{{ $i }}" 
                                    {{ old('c9') == $i ? 'checked' : '' }} required>
                                <label class="form-check-label" for="c9_{{ $i }}">{{ $i }}</label>
                            </div>

                            
                        @endfor

                        
                    </div>

                    @error('c9')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <hr>
                <center><h3>Suggestions</h3></center>
                <hr>

                <div class="form-group row mb-3 @error('d1') is-invalid @enderror">
                    <label class="col-sm-5 col-form-label"><b>Which POs and PEOs are being achieved effectively in your career?:<span class="text-danger">*</span></b></label>
                    <div class="col-sm-7">
                    <input type="text" class="form-control" name="d1" value="{{ old('d1') }}" required>
                    @error('d1')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                </div>

                <div class="form-group row mb-3 @error('d2') is-invalid @enderror">
                    <label class="col-sm-5 col-form-label"><b>Which areas need further emphasis in the program?:<span class="text-danger">*</span></b></label>
                    <div class="col-sm-7">
                    <input type="text" class="form-control" name="d2" value="{{ old('d2') }}" required>
                    @error('d2')
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
@endif

@endsection