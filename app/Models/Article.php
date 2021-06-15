<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Recon\Helpers\SchemaDefinition;
use Recon\Models\ReconItem;

class Article extends Model
{
    use HasFactory;
    use ReconItem;

    protected $guarded = [];

    protected function define(SchemaDefinition $definition)
    {
        $definition->category('content_type');
        $definition->string('title');
        $definition->string('text');
    }
}
