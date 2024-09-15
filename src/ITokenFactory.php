<?php

declare(strict_types=1);

namespace Pst\Tokenizer;

use Pst\Core\ICoreObject;


interface ITokenFactory extends ICoreObject {
    public function getPriority(): int;
    public function tryTokenize(string $input): ?IToken;
}