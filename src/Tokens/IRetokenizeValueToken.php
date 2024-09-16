<?php

declare(strict_types=1);

namespace Pst\Tokenizer\Tokens;

use Pst\Tokenizer\ITokenizer;

interface IRetokenizeValueToken extends IToken {
    public function getTokenizer(): ?ITokenizer;
}