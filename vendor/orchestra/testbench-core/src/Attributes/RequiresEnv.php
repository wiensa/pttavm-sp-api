<?php

namespace Orchestra\Testbench\Attributes;

use Attribute;
use Closure;
use Orchestra\Testbench\Contracts\Attributes\Actionable as ActionableContract;
use Orchestra\Testbench\Foundation\Env;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class RequiresEnv implements ActionableContract
{
    /**
     * Construct a new attribute.
     *
     * @param  string  $key
     * @param  string|null  $message
     */
    public function __construct(
        public string $key,
        public ?string $message = null
    ) {}

    /**
     * Handle the attribute.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @param  \Closure(string, array<int, mixed>):void  $action
     * @return void
     */
    public function handle($app, Closure $action): void
    {
        $message = $this->message ?? "Missing required environment variable `{$this->key}`";

        if (Env::has($this->key) === false) {
            \call_user_func($action, 'markTestSkipped', [$message]);
        }
    }
}
