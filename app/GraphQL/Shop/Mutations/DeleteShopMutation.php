<?php

namespace App\GraphQL\Shop\Mutations;

use App\GraphQL\Mutations\BaseMutation;
use App\Models\Shop;
use Illuminate\Validation\Rule;

class DeleteShopMutation extends BaseMutation
{
    public function handle(mixed $root, array $args): array
    {
        /** @var Shop $shop */
        $shop = Shop::query()->find($args['input']['id']);

        $shop->delete();

        return [
            'deletedShopId' => $shop->node_id,
            'userErrors' => [],
        ];
    }


    protected function rules(): array
    {
        return [
            'id' => ['required', Rule::exists('shops')],
        ];
    }

    protected function messages(): array
    {
        return [
            'id.exists' => 'Shop does not exist.',
        ];
    }
}

