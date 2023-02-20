<?php

namespace App\GraphQL\Product\Mutations;

use App\GraphQL\Mutations\BaseMutation;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class CreateProductMutation extends BaseMutation
{
    public function handle(mixed $root, array $args): array
    {
        $product = Product::create(

            Arr::only($args['input'], [
                'name',
                'description',
                'price',
                'discount',
                'shop_id'
            ]));

        return [
            'productEdge' => [
                'cursor' => Product::count(),
                'node' => $product->fresh(),
            ],
            'userErrors' => [],
        ];
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:1'],
            'description' => ['required', 'string', 'min:1'],
            'price' => ['required', 'numeric'],
            'discount' => ['required', 'numeric'],
            'shop_id' => ['required', Rule::exists('shops', 'id')],
        ];
    }

}
