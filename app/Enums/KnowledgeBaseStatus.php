<?php 


namespace App\Enums;

enum KnowledgeBaseStatus :string{
    case PENDING = 'pending';
    case GENERATING = 'generating';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
}