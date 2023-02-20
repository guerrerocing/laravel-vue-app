<?php

namespace App\GraphQL\Shop\Mutations;

use App\GraphQL\Mutations\BaseMutation;
use App\Models\Shop;
use Illuminate\Support\Arr;

class CreateShopMutation extends BaseMutation
{
    public function handle(mixed $root, array $args): array
    {
        $shop = Shop::create(

                Arr::only($args['input'], [
                    'name',
                    'description',
                    'address',
                    'opening_at',
                    'closing_at'
                ]));

        return [
            'shopEdge' => [
                'cursor' => Shop::count(),
                'node' => $shop->fresh(),
            ],
            'userErrors' => [],
        ];
    }

    protected function rules(): array
    {
        return [
            'address' => ['required', 'string', 'min:1'],
            'name' => ['required', 'string', 'min:1'],
            'description' => ['required', 'string', 'min:1'],
            'closing_at' => ['required', 'string', 'min:1'],
            'opening_at' => ['required', 'string', 'min:1'],
        ];
    }

}
