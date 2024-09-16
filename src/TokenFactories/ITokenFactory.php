<?php

declare(strict_types=1);

namespace Pst\Tokenizer\TokenFactories;

use Pst\Core\ICoreObject;
use Pst\Tokenizer\Tokens\IToken;

interface ITokenFactory extends ICoreObject {
    public function getName(): string;
    public function getPriority(): int;
    public function setPriority(int $priority): void;
    public function tryTokenize(string $input): ?IToken;
}