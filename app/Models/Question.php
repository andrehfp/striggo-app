<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = [
        'numero',
        'enunciado',
        'opcao_a',
        'opcao_b',
        'opcao_c',
        'opcao_d',
        'resposta_correta',
        'explicacao',
        'categoria',
        'prova_tipo',
    ];

    public function answers(): HasMany
    {
        return $this->hasMany(UserAnswer::class);
    }

    public function getOptionsAttribute(): array
    {
        return [
            'A' => $this->opcao_a,
            'B' => $this->opcao_b,
            'C' => $this->opcao_c,
            'D' => $this->opcao_d,
        ];
    }

    public static function randomQuestion(): self
    {
        return self::inRandomOrder()->first();
    }

    public static function byCategory(string $category)
    {
        return self::where('categoria', $category);
    }

    public static function categories()
    {
        return self::distinct('categoria')->pluck('categoria');
    }
}
