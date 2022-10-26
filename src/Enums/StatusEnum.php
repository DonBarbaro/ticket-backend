<?php

namespace App\Enums;

enum StatusEnum: string
{
    case New = 'New';
    case Progress = 'Progress';
    case WaitingForReply = 'WaitingForReply';
    case Solved = 'Solved';
}