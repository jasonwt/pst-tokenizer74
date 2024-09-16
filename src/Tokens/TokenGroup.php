<?php

declare(strict_types=1);

namespace Pst\Tokenizer\Tokens;

use Pst\Core\Types\Type;
use Pst\Core\Types\ITypeHint;
use Pst\Core\Collections\Enumerator;
use Pst\Core\Collections\IEnumerable;
use Pst\Core\Collections\Traits\LinqTrait;

use Closure;
use Traversable;
use ArrayIterator;


class TokenGroup extends Token implements ITokenGroup {
    use LinqTrait {
        count as private linqCount;
    }
    
    public function __construct(string $name, int $charactersConsumed, IToken ...$tokens) {
        if (count($tokens) === 0) {
            throw new \InvalidArgumentException("TokenGroup must contain at least one token.");
        }

        parent::__construct($name, $tokens, $charactersConsumed);
    }
    
    public function getTokens(): IEnumerable {
        return Enumerator::new($this->getValue(), Type::interface(IToken::class));
    }

    public function T(): ITypeHint {
        return Type::interface(IToken::class);
    }

    public function count(?Closure $predicate = null): int {
        return $predicate === null ? count($this->getValue()) : $this->linqCount($predicate);
    }

    public function getIterator(): Traversable {
        return new ArrayIterator($this->getValue());
    }    
}