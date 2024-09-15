<?php

declare(strict_types=1);

namespace Pst\Tokenizer\Tokens;

use Pst\Core\Types\Type;
use Pst\Core\Types\ITypeHint;

use Pst\Core\Collections\Traits\LinqTrait;

abstract class EnumerableToken extends Token implements IEnumerableToken {
    use LinqTrait;

    public function T(): ITypeHint {
        return Type::interface(IToken::class);
    }
    
}