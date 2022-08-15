<?php

namespace App\Enums;

enum StatusEnum: string{
    case new = 'new';
    case progress = 'progress';
    case solved = 'solved';
}