<?php

namespace App\GraphQL\Concerns;

use Nuwave\Lighthouse\Support\Contracts\GlobalId;

/**
 * @property string $node_id
 */
trait GraphQLModel
{
    public function getNodeIdAttribute(): string
    {
        return resolve(GlobalId::class)->encode(
            class_basename(static::class),
            $this->getKey()
        );
    }
}
