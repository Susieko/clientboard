<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case Design = 'design';
    case Development = 'development';
    case Feedback = 'feedback';
    case Done = 'done';

    public function label(): string
    {
        return match ($this) {
            self::Design => 'Design',
            self::Development => 'Development',
            self::Feedback => 'Waiting for feedback',
            self::Done => 'Done',
        };
    }

    public static function workflowColumns(): array
    {
        return array_map(
            fn (self $status) => [
                'key' => $status->value,
                'label' => $status->label(),
            ],
            self::cases()
        );
    }
}
