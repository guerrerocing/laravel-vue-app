<?php

namespace App\GraphQL\Shop\Mutations;

use App\GraphQL\Mutations\BaseMutation;
use App\Models\Shop;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;


class UpdateShopMutation extends BaseMutation
{
    public function handle(mixed $root, array $args): array
    {
        /** @var Shop $shop */
        $shop = Shop::query()->find($args['input']['id']);

        $shop->update(
            Arr::only($args['input'], [
                'name',
                'description',
                'address',
                'opening_at',
                'closing_at'
            ]));

        return [
            'shop' => $shop->fresh(),
            'userErrors' => [],
        ];
    }


    protected function rules(): array
    {
        return [
            'id' => ['required', Rule::exists('shops')],
            'address' => ['sometimes', 'required', 'string', 'min:1'],
            'name' => ['sometimes', 'required', 'string', 'min:1'],
            'description' => ['sometimes', 'required', 'string', 'min:1'],
            'closing_at' => ['sometimes', 'required', 'string', 'min:1'],
            'opening_at' => ['sometimes', 'required', 'string', 'min:1'],
        ];
    }
}
