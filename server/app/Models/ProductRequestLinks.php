<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRequestLinks extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'link',
        'updated_at'
    ];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_requests_link';
}
