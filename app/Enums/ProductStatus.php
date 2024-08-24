<?php

namespace App\Enums;

enum ProductStatus :string
{
    case Draft = 'draft';
    case Trash = 'trash';
    case Published = 'published';
    public static function forSelectName(): array
    {
      return array_combine(
          array_column(self::cases(), 'name'),
          array_column(self::cases(), 'value'),
      );
    }
}
