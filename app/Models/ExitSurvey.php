<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExitSurvey extends Model
{
    use HasFactory;

    protected $fillable = [
        // Governance
        'a1','a2','a3','a4','a5','a6','a7','a8','a9','a10',

        // Curriculum
        'b1','b2','b3','b4',

        // Structures & Facilities
        'c1','c2','c3','c4','c5','c6','c7',

        // Teaching-Learning
        'd1','d2','d3','d4','d5',

        // Learning Assessment
        'e1','e2','e3','e4',

        // Student Support Services
        'f1','f2','f3','f4','f5',

        // PLOs
        'g1','g2','g3','g4','g5','g6',
        'g7','g8','g9','g10','g11','g12',

        // Feedback (Text)
        'h1','h2','h3','h4',

        //Logged User
        'created_by',
        'created_at',
    ];
}
