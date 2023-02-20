<?php

namespace App\Models;

use App\GraphQL\Concerns\GraphQLModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shop extends Model
{
    use GraphQLModel;
    use HasFactory;

    public function products(): HasMany
    {
        return $this->hasMany(Product::Class);
    }
}
