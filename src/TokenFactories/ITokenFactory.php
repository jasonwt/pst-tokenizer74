<?php

declare(strict_types=1);

namespace Pst\Tokenizer\TokenFactories;

use Pst\Core\ICoreObject;

use Pst\Tokenizer\Tokens\IToken;

interface ITokenFactory extends ICoreObject {
    public function getPriority(): int;
    public function getName(): string;
    public function tryTokenize(string $input): ?IToken;
}