<?php

namespace App\GraphQL\Product\Mutations;

use App\GraphQL\Mutations\BaseMutation;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class UpdateProductMutation extends BaseMutation
{
    public function handle(mixed $root, array $args): array
    {
        /** @var Product $product */
        $product = Product::query()->find($args['input']['id']);

        $product->update(
            Arr::only($args['input'], [
                'name',
                'description',
                'price',
                'discount',
                'shop_id'
            ]));

        return [
            'product' => $product->fresh(),
            'userErrors' => [],
        ];
    }


    protected function rules(): array
    {
        return [
            'id' => ['required', Rule::exists('products')],
            'name' => ['required', 'string', 'min:1'],
            'description' => ['required', 'numeric', 'min:1'],
            'price' => ['required', 'numeric'],
            'discount' => ['required', 'numeric'],
            'shop_id' => ['required', Rule::exists('shops', 'id')],
        ];
    }
}
