<?php

declare(strict_types=1);

namespace Pst\Tokenizer;

use Pst\Core\CoreObject;

class Tokenizer extends CoreObject implements ITokenizer {
    private array $registeredTokens = [];


    public function registerToken(IToken $token, ?int $priority = null): void {
        $this->registeredTokens[] = $token;
    }
}