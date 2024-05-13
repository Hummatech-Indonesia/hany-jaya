<?php

namespace App\Enums;

enum UploadDiskEnum: string
{
    case PROFILE = 'profile';
    case PERMISSION = 'permission';
    case TASK = 'task';
    case ANSWER = 'answer';
    case MODUL = 'modul';
    case PROOFTREATMENT = 'prooftreatment';
    case LETTERHEAD = 'letterhead';
    case SIGNATURE = 'signature';
    case NEWS = 'news';
    case CONTENT = 'content';
    case PROOFVIOLATION = 'proofviolation';
    case PROOFBALANCERECORD = 'proofbalancerecord';
}
