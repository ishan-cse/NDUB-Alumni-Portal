@extends('layouts.admin.dashboard')
@section('dashboard_content')

<style>
.section-box{
    border:1px solid #e3e6f0;
    border-left:6px solid #4e73df;
    border-radius:6px;
    padding:20px;
    margin-bottom:30px;
    background:#fff;
}
.section-title{
    font-size:18px;
    font-weight:700;
    color:#4e73df;
    margin-bottom:10px;
}
.question-divider{
    border-top:1px dashed #ddd;
    margin:12px 0;
}
</style>

@php 
    if($exitSurveySubmissionStatus==0){
@endphp

@php
$scale=[
    5=>'Strongly Agree',
    4=>'Agree',
    3=>'Neutral',
    2=>'Disagree',
    1=>'Strongly Disagree'
];

function radioField($name,$label,$scale){
    $html='<div class="form-group row mb-3">';
    $html.='<label class="col-sm-7 col-form-label"><b>'.$label.' <span class="text-danger">*</span></b></label>';
    $html.='<div class="col-sm-5 d-flex justify-content-between">';
    foreach($scale as $v=>$t){
        $checked=old($name)==$v?'checked':'';
        $html.='<div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="'.$name.'" value="'.$v.'" '.$checked.' required>
            <label class="form-check-label">'.$v.'</label>
        </div>';
    }
    $html.='</div></div>';
    return $html;
}
@endphp

<form method="POST" action="{{ route('student_exit_survey.store') }}">
@csrf

<div class="card">
<div class="card-header">
    <h3><b style="color: purple">Student Exit Survey</b></h3>
    <h5><b style="color: blue">Scale: 5 – Strongly Agree | 4 – Agree | 3 – Neutral | 2 – Disagree | 1 – Strongly Disagree</b></h5>
</div>

<div class="card-body">

{{-- ================= 1. GOVERNANCE ================= --}}
<div class="section-box">
<div class="section-title">1. Governance</div>

{!! radioField('a1','Vision, mission and objectives of CSE, NDUB are clearly stated.',$scale) !!}
{!! radioField('a2','Academic decisions are taken by CSE, NDUB with fairness and transparency.',$scale) !!}
{!! radioField('a3','CSE, NDUB has adequate infrastructures to satisfy its mission and objectives.',$scale) !!}
{!! radioField('a4','Academic calendars are maintained strictly by CSE, NDUB.',$scale) !!}
{!! radioField('a5','Results are published timely.',$scale) !!}
{!! radioField('a6','Codes of conduct for the students are well communicated.',$scale) !!}
{!! radioField('a7','Disciplinary rules and regulations are explicitly defined and well-circulated.',$scale) !!}
{!! radioField('a8','The website of CSE, NDUB is updated properly.',$scale) !!}
{!! radioField('a9','CSE, NDUB ensures a conducive learning environment.',$scale) !!}
{!! radioField('a10','Students’ opinions regarding academic and extra-academic matters are addressed properly.',$scale) !!}
</div>

{{-- ================= 2. CURRICULUM ================= --}}
<div class="section-box">
<div class="section-title">2. Curriculum: Content, Design and Review</div>

{!! radioField('b1','Courses in the syllabus are logically arranged from lower to higher levels of knowledge.',$scale) !!}
{!! radioField('b2','Teaching strategies and course content are clearly stated in the syllabus.',$scale) !!}
{!! radioField('b3','Assessment strategies are explicit in the syllabus.',$scale) !!}
{!! radioField('b4','Course load throughout the semesters is optimum and exerts no pressure.',$scale) !!}
</div>

{{-- ================= 3. STRUCTURES ================= --}}
<div class="section-box">
<div class="section-title">3. Structures and Facilities</div>

{!! radioField('c1','Classroom facilities are suitable for ensuring effective learning.',$scale) !!}
{!! radioField('c2','Laboratory facilities are adequate for practical teaching-learning.',$scale) !!}
{!! radioField('c3','Facilities for conducting research are adequate.',$scale) !!}
{!! radioField('c4','The library has adequate up-to-date reading and reference materials.',$scale) !!}
{!! radioField('c5','Indoor and outdoor medical facilities are adequate.',$scale) !!}
{!! radioField('c6','Sports facilities are sufficient.',$scale) !!}
{!! radioField('c7','Existing cafeteria facilities are good enough.',$scale) !!}
</div>

{{-- ================= 4. TEACHING ================= --}}
<div class="section-box">
<div class="section-title">4. Teaching-Learning and Assessment</div>

{!! radioField('d1','Teaching-learning is interactive and supportive.',$scale) !!}
{!! radioField('d2','Class size is optimum for interactive teaching-learning.',$scale) !!}
{!! radioField('d3','Adequate opportunities for practical application are provided.',$scale) !!}
{!! radioField('d4','Modern devices are used to improve teaching-learning.',$scale) !!}
{!! radioField('d5','Lesson plans or course outlines are provided in advance.',$scale) !!}
</div>

{{-- ================= 5. LEARNING ASSESSMENT ================= --}}
<div class="section-box">
<div class="section-title">5. Learning Assessment</div>

{!! radioField('e1','Assessment systems are duly communicated to students at the outset of the semester.',$scale) !!}
{!! radioField('e2','Assessment procedures meet the objectives of the course.',$scale) !!}
{!! radioField('e3','Both formative and summative assessment strategies are followed.',$scale) !!}
{!! radioField('e4','Feedback is provided promptly after assessment.',$scale) !!}
</div>

{{-- ================= 6. STUDENT SUPPORT ================= --}}
<div class="section-box">
<div class="section-title">6. Student Support Services</div>

{!! radioField('f1','Academic guidance and counseling are available through course advisors.',$scale) !!}
{!! radioField('f2','Financial grants are available to students in case of hardship.',$scale) !!}
{!! radioField('f3','CSE, NDUB provides co-curricular and extra-curricular opportunities.',$scale) !!}
{!! radioField('f4','There is an organized and supportive alumni association.',$scale) !!}
{!! radioField('f5','Opportunities exist for club and community service activities (DSW wing).',$scale) !!}
</div>

{{-- ================= 7. ENGINEER ATTRIBUTES ================= --}}
<div class="section-box">
<div class="section-title">7. Engineer’s Attributes (Program Learning Outcomes)</div>

{!! radioField('g1','PO1 – Engineering knowledge: Apply mathematics, science and engineering fundamentals.',$scale) !!}
{!! radioField('g2','PO2 – Problem analysis: Identify and analyze complex engineering problems.',$scale) !!}
{!! radioField('g3','PO3 – Design/development of solutions considering safety and environment.',$scale) !!}
{!! radioField('g4','PO4 – Investigation using data analysis and interpretation.',$scale) !!}
{!! radioField('g5','PO5 – Modern tool usage in engineering practice.',$scale) !!}
{!! radioField('g6','PO6 – Engineer and society: Assess societal and cultural issues responsibly.',$scale) !!}
{!! radioField('g7','PO7 – Environment and sustainability awareness.',$scale) !!}
{!! radioField('g8','PO8 – Ethics and professional responsibility.',$scale) !!}
{!! radioField('g9','PO9 – Individual and teamwork effectiveness.',$scale) !!}
{!! radioField('g10','PO10 – Communication skills.',$scale) !!}
{!! radioField('g11','PO11 – Project management and finance.',$scale) !!}
{!! radioField('g12','PO12 – Life-long learning.',$scale) !!}
</div>

{{-- ================= 8. FEEDBACK ================= --}}
<div class="section-box">
<div class="section-title">8. Feedback and Suggestions</div>

<textarea class="form-control mb-3" name="h1" placeholder="Best or commendable practices followed in CSE, NDUB">{{ old('h1') }}</textarea>
<textarea class="form-control mb-3" name="h2" placeholder="Practices of the program that need improvement">{{ old('h2') }}</textarea>
<textarea class="form-control mb-3" name="h3" placeholder="Courses that may be included to improve graduate quality">{{ old('h3') }}</textarea>
<textarea class="form-control mb-3" name="h4" placeholder="Any additional comments or suggestions">{{ old('h4') }}</textarea>
</div>

</div>

<div class="card-footer text-center">
<button class="btn btn-success btn-lg">Submit Survey</button>
</div>

</div>
</form>

@php
    }elseif($exitSurveySubmissionStatus=1){
@endphp

<div class="card shadow-sm border-left-info mb-4">
    <div class="card-body text-center">
        <i class="fas fa-check-circle fa-3x text-info mb-3"></i>

        <h4 class="text-info font-weight-bold mb-2">
            Exit Survey Already Submitted
        </h4>

        <p class="text-muted mb-0">
            You have already submitted the Student Exit Survey form.
            Thank you for sharing your valuable feedback.
        </p>
    </div>
</div>

@php
    }
@endphp

@endsection