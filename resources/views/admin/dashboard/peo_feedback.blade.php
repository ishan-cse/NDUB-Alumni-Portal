@extends('layouts.admin.dashboard')

@section('dashboard_content')

@php
    $loggedUser = Auth::user();
@endphp

@if($loggedUser->user_slug != 'Account-1')
<div class="container-fluid">
    <div class="row g-4">

        <!-- TOTAL RESPONSE CARD -->
        <div class="col-12">
            <div class="card shadow-lg border-0 text-white" style="background-color: #1e1e1e;">
                <div class="card-body text-center p-4">
                    <h5 class="card-header w-100 text-center mb-3" style="background-color: transparent; border: none; font-weight: 600;">
                        Total PEO Form Responses
                    </h5>
                    <i class="fa-solid fa-clipboard-list" style="font-size: 2.5rem; color: #9fd609;"></i>
                    <div style="font-size: 3rem; font-weight: bold; color: #9fd609; margin-top: 10px;">
                        {{ $peoSubmissionCount }}
                    </div>
                    <p class="card-text mt-2" style="font-size: 1rem; color: #ccc;">
                        Total number of responses submitted so far
                    </p>
                </div>
            </div>
        </div>

        <!-- PEO Cards -->
        @php
            $peos = [
                'b1' => ['title' => 'PEO 1 (Professionalism)', 'desc' => 'My degree helped me develop professionalism including problem-solving, teamwork, ethics, leadership, and communication skills.', 'color' => '#9fd609'],
                'b2' => ['title' => 'PEO 2 (Continuous Self-Development)', 'desc' => 'My degree encouraged lifelong learning, higher studies, professional training, and adaptability.', 'color' => 'yellow'],
                'b3' => ['title' => 'PEO 3 (Sustainable Development)', 'desc' => 'My degree increased my awareness of societal/environmental issues and sustainable development.', 'color' => '#ff9933'],
            ];
        @endphp

        @foreach($peos as $key => $peo)
        <div class="col-12 col-md-8 mx-auto">
            <div class="card shadow-sm mb-4" style="background-color: {{ $peo['color'] }}; color: black;">
                <div class="card-header fw-bold"><h3>{{ $peo['title'] }}</h3></div>
                <div class="card-body">
                    <p>{{ $peo['desc'] }}</p>
                    <p class="fw-bold">Percentage of responses ≥ Threshold value: {{ $threshold }}%</p>
                    <h2 style="color: #1e1e1e; font-weight: bold;">
                        {{ $percentages[$key] ?? 0 }}%
                    </h2>
                </div>
            </div>
        </div>
        @endforeach

    </div>

    <!-- COMMENTS SECTION -->
    <div class="row mt-5">
        <!-- C1 Comments -->
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background-color: #f5f5f5;">
                <div class="card-header fw-bold text-dark">
                    <h3>Strengths of the program in supporting your professional career</h3>
                </div>
                <div class="card-body">
                    <ol class="text-dark">
                        @foreach($c1Comments as $comment)
                            <li>{{ $loop->iteration }}. {{ $comment->c1 }}</li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>

        <!-- C2 Comments -->
        <div class="col-12 mt-4">
            <div class="card border-0 shadow-sm" style="background-color: #f5f5f5;">
                <div class="card-header fw-bold text-dark">
                    <h3>Areas of the program that could be improved</h3>
                </div>
                <div class="card-body">
                    <ol class="text-dark">
                        @foreach($c2Comments as $comment)
                            <li>{{ $loop->iteration }}. {{ $comment->c2 }}</li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>

</div>
@endif
@endsection
