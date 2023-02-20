<?php

namespace App\GraphQL\Product\Mutations;

use App\GraphQL\Mutations\BaseMutation;
use App\Models\Product;
use Illuminate\Validation\Rule;

class DeleteProductMutation extends BaseMutation
{
    public function handle(mixed $root, array $args): array
    {
        /** @var Product $product */
        $product = Product::query()->find($args['input']['id']);

        $product->delete();

        return [
            'deletedProductId' => $product->node_id,
            'userErrors' => [],
        ];
    }


    protected function rules(): array
    {
        return [
            'id' => ['required', Rule::exists('products')],
        ];
    }

    protected function messages(): array
    {
        return [
            'id.exists' => 'Product does not exist.',
        ];
    }
}

