@extends('layouts.admin.dashboard')

@section('dashboard_content')

{{-- ================== DESIGN CSS ================== --}}
<style>
.section-box {
    border: 1px solid #e3e6f0;
    border-left: 6px solid #4e73df;
    border-radius: 6px;
    padding: 20px;
    margin-bottom: 30px;
    background: #ffffff;
}

.section-title {
    font-size: 18px;
    font-weight: 700;
    color: #4e73df;
    margin-bottom: 8px;
}

.section-desc {
    font-size: 14px;
    color: #6c757d;
    margin-bottom: 18px;
}

.question-divider {
    border-top: 1px dashed #ddd;
    margin: 12px 0;
}

textarea {
    resize: vertical;
}
</style>

{{-- ================== SWEET ALERT ================== --}}
@if(Session::has('success'))
<script>
Swal.fire({
    position: 'center',
    icon: 'success',
    text: '{{ Session::get('success') }}',
    showConfirmButton: true,
    timer: 5000
});
</script>
@endif

@if(Session::has('error'))
<script>
Swal.fire({
    position: 'center',
    icon: 'error',
    text: '{{ Session::get('error') }}',
    showConfirmButton: true,
    timer: 5000
});
</script>
@endif

@php
$scale = [
    5 => 'Strongly Agree',
    4 => 'Agree',
    3 => 'Neutral',
    2 => 'Disagree',
    1 => 'Strongly Disagree'
];

function radioField($name, $label, $scale) {
    $html  = '<div class="form-group row mb-3">';
    $html .= '<label class="col-sm-7 col-form-label"><b>'.$label.' <span class="text-danger">*</span></b></label>';
    $html .= '<div class="col-sm-4 d-flex justify-content-between">';
    foreach ($scale as $val => $text) {
        $checked = old($name)==$val ? 'checked' : '';
        $html .= '
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="'.$name.'" value="'.$val.'" '.$checked.' required>
            <label class="form-check-label">'.$val.'</label>
        </div>';
    }
    $html .= '</div></div>';
    return $html;
}
@endphp

<div class="container">
<div class="row">
<div class="col-md-12">

<form method="POST" action="{{ route('student_exit_survey.store') }}">
@csrf

<div class="card">
<div class="card-header">
    <h4><i class="fab fa-gg-circle"></i> <b>Student Exit Survey</b></h4>
</div>

<div class="card-body">

{{-- ================== 1. GOVERNANCE ================== --}}
<div class="section-box">
    <div class="section-title">1. Governance</div>
    <div class="section-desc">Evaluate governance related aspects of the program.</div>

    {!! radioField('a1','Vision, mission and objectives of CSE, NDUB are clearly stated.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('a2','Academic decisions are taken with fairness and transparency.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('a3','Adequate infrastructure exists to meet objectives.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('a4','Academic calendars are strictly maintained.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('a5','Results are published timely.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('a6','Codes of conduct are well communicated.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('a7','Disciplinary rules are clearly defined.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('a8','Website is properly updated.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('a9','A conducive learning environment exists.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('a10','Students’ opinions are addressed properly.',$scale) !!}
</div>

{{-- ================== 2. CURRICULUM ================== --}}
<div class="section-box">
    <div class="section-title">2. Curriculum: Content, Design & Review</div>
    <div class="section-desc">Evaluate curriculum structure and workload.</div>

    {!! radioField('b1','Courses are logically arranged.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('b2','Teaching strategies are clearly stated.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('b3','Assessment strategies are explicit.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('b4','Course load is optimum.',$scale) !!}

    <div class="form-group row mt-4">
        <label class="col-sm-7 col-form-label"><b>Structures and Facilities (Comments)</b></label>
        <div class="col-sm-5">
            <textarea class="form-control" name="b5" rows="3"
            placeholder="Write your comments...">{{ old('b5') }}</textarea>
        </div>
    </div>
</div>

{{-- ================== 3. STRUCTURES ================== --}}
<div class="section-box">
    <div class="section-title">3. Structures & Facilities</div>

    {!! radioField('c1','Classroom facilities are suitable.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('c2','Laboratory facilities are adequate.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('c3','Research facilities are adequate.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('c4','Library resources are sufficient.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('c5','Medical facilities are adequate.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('c6','Sports facilities are sufficient.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('c7','Cafeteria facilities are satisfactory.',$scale) !!}
</div>

{{-- ================== 4. TEACHING ================== --}}
<div class="section-box">
    <div class="section-title">4. Teaching–Learning & Assessment</div>

    {!! radioField('d1','Teaching-learning is interactive.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('d2','Class size is optimum.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('d3','Practical application opportunities exist.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('d4','Modern teaching tools are used.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('d5','Lesson plans are provided in advance.',$scale) !!}
</div>

{{-- ================== 5. LEARNING ASSESSMENT ================== --}}
<div class="section-box">
    <div class="section-title">5. Learning Assessment</div>

    {!! radioField('e1','Assessment systems are communicated clearly.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('e2','Assessment meets course objectives.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('e3','Formative & summative assessments are used.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('e4','Feedback is provided promptly.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('e6','Academic guidance is available.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('e7','Financial grants are available.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('e8','Co-curricular activities are available.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('e9','Alumni association is supportive.',$scale) !!}
    <div class="question-divider"></div>
    {!! radioField('e10','Club/community service opportunities exist.',$scale) !!}

    <div class="form-group row mt-4">
        <label class="col-sm-7 col-form-label"><b>Student Support Services (Comments)</b></label>
        <div class="col-sm-5">
            <textarea class="form-control" name="e5"
            placeholder="Your feedback...">{{ old('e5') }}</textarea>
        </div>
    </div>
</div>

{{-- ================== 6. ENGINEER ATTRIBUTES ================== --}}
<div class="section-box">
    <div class="section-title">6. Engineer’s Attributes (PLOs)</div>

    @for($i=1;$i<=12;$i++)
        {!! radioField("f$i","PO$i Evaluation",$scale) !!}
        <div class="question-divider"></div>
    @endfor

    @foreach(['f13','f14','f15','f16','f17'] as $f)
    <div class="form-group row mb-3">
        <label class="col-sm-7 col-form-label"><b>{{ strtoupper($f) }}</b></label>
        <div class="col-sm-5">
            <textarea class="form-control" name="{{ $f }}"
            placeholder="Write your response...">{{ old($f) }}</textarea>
        </div>
    </div>
    @endforeach
</div>

</div>

<div class="card-footer text-center bg-light">
    <button type="submit" class="btn btn-success btn-lg px-5">
        <i class="fas fa-paper-plane"></i> Submit Survey
    </button>
</div>

</div>
</form>

</div>
</div>
</div>

@endsection
