<?php

namespace App\GraphQL\Shop\Builders;

use App\Models\Shop;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\Builder;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class ShopBuilder
{
    public function withStock($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): Builder
    {
        $builder = Shop::query();

        return $builder->whereHas('products');
    }

    public function withOutStock($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): Builder
    {
        $builder = Shop::query();

        return $builder->whereDoesntHave('products');
    }

}
