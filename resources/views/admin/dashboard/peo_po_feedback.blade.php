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
                        Total PEO + PO Form Responses
                    </h5>
                    <i class="fa-solid fa-clipboard-list" style="font-size: 2.5rem; color: #9fd609;"></i>
                    <div style="font-size: 3rem; font-weight: bold; color: #9fd609; margin-top: 10px;">
                        {{ $peoPoSubmissionCount }}
                    </div>
                    <p class="card-text mt-2" style="font-size: 1rem; color: #ccc;">
                        Total number of responses submitted so far
                    </p>
                </div>
            </div>
        </div>

        <!-- PEO & PO CARDS -->
        @php
            $peopoItems = [
                // --- PEOs ---
                'b1' => ['title' => 'PEO 1 (Professionalism)', 'desc' => 'My degree helped me develop professionalism including problem-solving, teamwork, ethics, leadership, and communication skills.', 'color' => '#9fd609'],
                'b2' => ['title' => 'PEO 2 (Continuous Self-Development)', 'desc' => 'My degree encouraged lifelong learning, higher studies, professional training, and adaptability.', 'color' => 'yellow'],
                'b3' => ['title' => 'PEO 3 (Sustainable Development)', 'desc' => 'My degree increased my awareness of societal/environmental issues and sustainable development.', 'color' => '#ff9933'],

                // --- POs ---
                'c1' => ['title' => 'PO 1: Apply engineering knowledge in practice', 'desc' => 'Feedback on Program Outcomes (POs)', 'color' => '#b3e6ff'],
                'c2' => ['title' => 'PO 2: Problem analysis and critical thinking', 'desc' => 'Feedback on Program Outcomes (POs)', 'color' => '#b3e6ff'],
                'c3' => ['title' => 'PO 3: Design and development of solutions', 'desc' => 'Feedback on Program Outcomes (POs)', 'color' => '#b3e6ff'],
                'c4' => ['title' => 'PO 4: Use of modern tools and technology', 'desc' => 'Feedback on Program Outcomes (POs)', 'color' => '#b3e6ff'],
                'c5' => ['title' => 'PO 5: Communication skills (oral and written)', 'desc' => 'Feedback on Program Outcomes (POs)', 'color' => '#b3e6ff'],
                'c6' => ['title' => 'PO 6: Teamwork and leadership ability', 'desc' => 'Feedback on Program Outcomes (POs)', 'color' => '#b3e6ff'],
                'c7' => ['title' => 'PO 7: Lifelong learning and adaptability', 'desc' => 'Feedback on Program Outcomes (POs)', 'color' => '#b3e6ff'],
                'c8' => ['title' => 'PO 8: Professional ethics and responsibility', 'desc' => 'Feedback on Program Outcomes (POs)', 'color' => '#b3e6ff'],
                'c9' => ['title' => 'PO 9: Knowledge of contemporary issues and societal impact', 'desc' => 'Feedback on Program Outcomes (POs)', 'color' => '#b3e6ff'],
            ];
        @endphp

        @foreach($peopoItems as $key => $item)
        <div class="col-12 col-md-8 mx-auto">
            <div class="card shadow-sm mb-4" style="background-color: {{ $item['color'] }}; color: black;">
                <div class="card-header fw-bold">
                    <h3>{{ $item['title'] }}</h3>
                </div>
                <div class="card-body">
                    <p>{{ $item['desc'] }}</p>
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
        <!-- D1 Comments -->
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background-color: #f5f5f5;">
                <div class="card-header fw-bold text-dark">
                    <h3>Which POs and PEOs are being achieved effectively in your career?</h3>
                </div>
                <div class="card-body">
                    <ol class="text-dark">
                        @foreach($d1Comments as $comment)
                            @if(!empty($comment->d1))
                                <li>{{ $loop->iteration }}. {{ $comment->d1 }}</li>
                            @endif
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>

        <!-- D2 Comments -->
        <div class="col-12 mt-4">
            <div class="card border-0 shadow-sm" style="background-color: #f5f5f5;">
                <div class="card-header fw-bold text-dark">
                    <h3>Which areas need further emphasis in the program?</h3>
                </div>
                <div class="card-body">
                    <ol class="text-dark">
                        @foreach($d2Comments as $comment)
                            @if(!empty($comment->d2))
                                <li>{{ $loop->iteration }}. {{ $comment->d2 }}</li>
                            @endif
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>

</div>
@endif
@endsection
