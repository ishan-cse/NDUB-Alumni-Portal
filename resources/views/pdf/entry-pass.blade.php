@php

use App\Models\GraduateList;
use App\Models\User;
use App\Models\Batch;
use App\Models\Program;
use App\Models\Department;
        
foreach($allData as $datas){
 // For PDF
            $data = GraduateList::where('id', $datas->id)
            ->with(['programInfo', 'batchInfo', 'secondProgramInfo'])
            ->first();
            $data1 = GraduateList::where('id', $datas->second_program_grad_list_id)
            ->with(['programInfo', 'batchInfo', 'secondProgramInfo'])
            ->first();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" rel="stylesheet">
        <style>
         /* Watermark Image Styling */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-image: url('data:image/png;base64,<?= base64_encode(file_get_contents(public_path('contents/admin/assets/img/convocation-logo.png'))) ?>');
            background-repeat: no-repeat;
            background-size: 100%; /* Adjust the size of the watermark image */
            opacity: 0.1; /* Lower opacity for a faint watermark */
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none;
        }
        
        /* Basic styling */
        html {
            background-color: white; /* Set background color to yellow */
            color: #1044b5; /* Set the text color to white */
            height: 100%;
            width: 100%;
            font-family: Arial, sans-serif;
            position: relative;
        }
        
        body {
            position: relative; /* Set relative positioning for the pseudo-element */
            color: #1044b5; /* Set the text color to white */
            height: 100%;
            width: 100%;
            font-family: Arial, sans-serif;
            padding: 0;
            margin: 0;
            position: relative;
        }

        .container {
            width: 100%;
            max-width: 1200px; /* Adjust as needed */
            margin: 0 auto;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px; /* Adjust padding as needed */
        }

        .col-3,
        .col-6 {
            padding: 0 15px; /* Adjust padding as needed */
        }

        img {
            width: 60px;
            height: 60px;
        }
        #img1 {
            width: 120px;
            height: 120px;
        }
        #img2 {
            width: 120px;
            height: 120px;
        }
        #img3 {
            width: 80px;
            height: 80px;
        }
        #signature {
            width: 300px;
            height: 80px;
        }
        /* .image-container {
            display: flex;
            align-items: center;
        }
        
        .image-container img {
            width: 70px;
            height: 70px;
            margin-right: 10px;
        } 
        */
        h3 {
            font-size: 1.25rem;
            font-weight: bold;
            margin: 0;
        }

        h4 {
            font-size: 1.10rem;
            font-weight: normal; 
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px; /* Adjust margin as needed */
        }

        table td {
            /* border: 1px solid #1044b5; */
            border: none;
            padding: 2px;
        }

        /* First page signature css */
        .signature-grid-container {
            display: grid;
            grid-template-columns: auto auto auto auto;
            padding: 4px;
        }

        .signature-grid-item {
            padding: 4px;
            font-size: 11px;
            font-weight: bold;
        }

        /* Page break */
        .page-break {
            page-break-after: always;
        }

        li {
            padding-bottom: 10px; /* Adjust the value based on your preference */
        }

        .no-page-break {
            page-break-inside: avoid;
        }
    </style>
</head>

<body style="padding-top: 40px;">
<!-- <button onclick="window.print()">Print</button> -->
<div class="watermark" style="margin-top: 127px;" ></div>
<div class="no-page-break" style="padding-top: 8px;">
    <div class="container">
        <div class="row mt-2">
            <div class="image-container">
                    <div style="">
                        <p style="text-align: center;">
                            <span style="font-weight: bold; font-size: 19px;">NOTRE DAME UNIVERSITY BANGLADESH</span><br>
                            <span style="font-size: 16px; font-weight: bold">2nd CONVOCATION ENTRY PASS</span><br>
                            <span style="font-size: 12px; font-weight: bold">GPO BOX-7, 2/A, Arambagh, Motijheel, Dhaka 1000, Bangladesh</span><br>
                        </p>
                    </div>
                </div>
            </div>
        </div style="margin-top: 20px;">

        <div class="row">
            <div class="col-12 mt-2">
            
            </div>
        </div>
        
        <div class="row">
            <div class="col-12 mt-2">
                <div class="table-responsive">
                @if($data->student_program_choice==1)
                <p style="font-size: 14px; font-weight: bold">Graduate's Information (Single Program)</p>
                @elseif($data->student_program_choice==3)
                <p style="font-size: 14px; font-weight: bold">Graduate's Information (Double Program)</p>
                @endif
                    <table class="table table-bordered">
                        <tr>
                            <td colspan="1">
                            @php
                            $filePath = public_path('uploads/student/'.$data->student_photo);
                            if (is_file($filePath)) {
                                echo '<img id="img1" style="float:center;" src="data:image/png;base64,' . base64_encode(file_get_contents($filePath)) . '" alt="">';
                            } else {
                                echo '<p>No valid image found.</p>';  // Handle case where file is not found or is a directory
                            }
                            @endphp
                            </td>
                            <td colspan="3">
                                <span class="text-left" style="font-size: 12px; font-weight: bold">
                                Name: {{ $data->name ? strtoupper($data->name) : ''}}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1"></td>
                            <td colspan="3">
                                <span class="text-left" style="font-size: 12px; font-weight: bold">
                                Phone No.: {{$data->phone ? $data->phone : ''}}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1"></td>
                            <td colspan="3">
                                <span class="text-left" style="font-size: 12px; font-weight: bold">
                                ID: {{$data->student_id ? $data->student_id : ''}}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1"></td>
                            <td colspan="3">
                                <span class="text-left" style="font-size: 12px; font-weight: bold">
                                Program: {{ $data->programInfo->program_name == 'Bachelor of Science in Computer Science & Engineering' 
    ? 'B.Sc. in Computer Science & Engineering' 
    : ($data->programInfo->program_name ?? '') }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1"></td>
                            <td colspan="3">
                                <span class="text-left" style="font-size: 12px; font-weight: bold">
                                Batch: {{$data->batchInfo->batch_name ? $data->batchInfo->batch_name : ''}}
                                </span>
                            </td>
                        </tr>
                        @if($data->student_program_choice==1)
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <br><br><br>
                            </td>
                        </tr>
                        @elseif($data->student_program_choice==3)
                        <tr>
                            <td colspan="1"></td>
                            <td colspan="3">
                                <span class="text-left" style="font-size: 12px; font-weight: bold">
                                ID: {{$data1->student_id ?? ''}}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1"></td>
                            <td colspan="3">
                                <span class="text-left" style="font-size: 12px; font-weight: bold">
                                Program: {{$data1->programInfo->program_name ? $data1->programInfo->program_name : ''}}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1"></td>
                            <td colspan="3">
                                <span class="text-left" style="font-size: 12px; font-weight: bold">
                                Batch: {{$data1->batchInfo->batch_name ?? ''}}
                                </span>
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    
    <div class="row">
            <div class="col-12 mt-2">
                <div class="table-responsive">
                <p style="font-size: 11px; font-weight: normal">
                <b style="font-size: 14px; font-weight: bold">Guest Details</b><br>
                </p>
                    <table class="table table-bordered">
                        <tr>
                        </tr>
                        <tr>
                            <td colspan="1">
                                @if($data->guest1_photo!='')
                                    <img id="img1" style="" src="data:image/png;base64,<?=  base64_encode(file_get_contents(public_path('uploads/guest/'.$data->guest1_photo))) ?>" alt="">
                                @else
                                @endif
                            </td>
                            <td colspan="1">
                                @if($data->guest2_photo!='')
                                    <img id="img1" style="" src="data:image/png;base64,<?=  base64_encode(file_get_contents(public_path('uploads/guest/'.$data->guest2_photo))) ?>" alt="">
                                @else
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                <span class="text-left" style="font-size: 12px; font-weight: bold">
                                {{$data->guest1_name ? $data->guest1_name : ''}}
                                </span>
                            </td>
                            <td colspan="1">
                                <span class="text-left" style="font-size: 12px; font-weight: bold">
                                {{$data->guest2_name ? $data->guest2_name : ''}}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                <span class="text-left" style="font-size: 12px; font-weight: bold">
                                {{$data->guest1_relationship ? $data->guest1_relationship : ''}}
                                </span>
                            </td>
                            <td colspan="1">
                                <span class="text-left" style="font-size: 12px; font-weight: bold">
                                {{$data->guest2_relationship ? $data->guest2_relationship : ''}}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                <span class="text-left" style="font-size: 12px; font-weight: bold">
                                {{$data->guest1_nid_or_birth_cert ? $data->guest1_nid_or_birth_cert : ''}}
                                </span>
                            </td>
                            <td colspan="1">
                                <span class="text-left" style="font-size: 12px; font-weight: bold">
                                {{$data->guest2_nid_or_birth_cert ? $data->guest2_nid_or_birth_cert : ''}}
                                </span>
                            </td>
                        </tr>
                    </table>
            </div>
        </div>
    </div>
        
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>
@php
}
@endphp