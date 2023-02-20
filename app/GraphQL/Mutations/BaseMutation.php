<?php

namespace App\GraphQL\Mutations;

use BadMethodCallException;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Nuwave\Lighthouse\Exceptions\AuthorizationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Throwable;

abstract class BaseMutation
{
    use HandlesAuthorization;

    public function __construct(protected Gate $gate)
    {
    }

    public function __invoke(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): array
    {
        if (! method_exists($this, 'handle')) {
            throw new BadMethodCallException('Missing public method "handle".');
        }

        /** @var Response $response */
        $response = call_user_func_array([$this, 'authorized'], [$args, $context]);

        if ($response->denied()) {
            throw new AuthorizationException(
                $response->message() ?? "Access denied for $resolveInfo->fieldName field.",
            );
        }

        $userErrors = $this->validate($args, $context);

        // This return maybe does no work for every request
        // so, we have to re-think it in the future.
        if ($userErrors) {
            return [
                'userErrors' => $userErrors,
            ];
        }

        DB::beginTransaction();

        try {
            $response = $this->handle($root, $args, $context, $resolveInfo);

            DB::commit();

            return $response;
        } catch (Throwable $e) {
            DB::rollBack();


            throw new Error('Oops, Something went terrible wrong!');
        }
    }

    public function authorized(array $args, GraphQLContext $context): Response
    {
        return $this->allow();
    }

    protected function validate(array $args, GraphQLContext $context): ?array
    {
        if (! method_exists($this, 'rules')) {
            throw new BadMethodCallException('Missing public method "rules".');
        }

        $customAttributes = [];

        if (method_exists($this, 'customAttributes')) {
            /** @var array $customAttributes */
            $customAttributes = call_user_func_array([$this, 'customAttributes'], [$args, $context]);
        }

        $messages = [];

        if (method_exists($this, 'messages')) {
            /** @var array $messages */
            $messages = call_user_func_array([$this, 'messages'], [$args, $context]);
        }

        /** @var array $rules */
        $rules = call_user_func_array([$this, 'rules'], [$args, $context]);

        $validator = Validator::make(
            $this->getDataToValidate($args),
            $rules,
            $messages,
            $customAttributes
        );

        if (method_exists($this, 'withValidator')) {
            call_user_func_array([$this, 'withValidator'], [$validator, $args, $context]);
        }

        if ($validator->fails()) {
            return $this->buildErrorsFromValidator($validator);
        }

        return null;
    }

    protected function getDataToValidate(array $args): array
    {
        return $args['input'] ?? [];
    }

    protected function buildError(string $field, array $messages): array
    {
        $field = collect(explode('.', $field))
            ->map(fn (string $part) => Str::camel($part))
            ->all();

        return [
            'field' => $field,
            'message' => $messages[0],
        ];
    }

    protected function buildErrorsFromValidator(\Illuminate\Validation\Validator $validator): array
    {
        return collect($validator->messages()->getMessages())->map(
            fn (array $messages, string $field) => $this->buildError($field, $messages)
        )->all();
    }
}
