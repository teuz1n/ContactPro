<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'telephone',
        'category',
    ];

    /**
     * Define o nome da tabela correspondente ao modelo.
     *
     * @var string
     */
    protected $table = 'contacts';
}
