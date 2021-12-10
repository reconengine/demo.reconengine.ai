<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Recon\Helpers\SchemaDefinition;
use Recon\Models\ReconItem;

class Movie extends Model
{
    use HasFactory;
    use ReconItem;

    protected $guarded = [];

    protected $casts = [
        'belongs_to_collection' => 'json',
        'genres' => 'json',
        'production_companies' => 'json',
    ];

    protected function define(SchemaDefinition $definition)
    {
        throw new \Exception('TODO define this asdf');
//        $definition->category('content_type');
//        $definition->string('title');
//        $definition->string('text');
    }
}
