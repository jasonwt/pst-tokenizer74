<?php

declare(strict_types=1);

namespace Pst\Tokenizer\Tokens;

use Pst\Core\CoreObject;
use Pst\Tokenizer\ITokenizer;

class RetokenizeValueToken extends CoreObject implements IRetokenizeValueToken {
    private IToken $token;
    private ?ITokenizer $tokenizer;

    public function __construct(IToken $token, ?ITokenizer $tokenizer = null) {
        $this->token = $token;
        $this->tokenizer = $tokenizer;
    }

    public function getName(): string {
        return $this->token->getName();
    }

    public function getValue(): string {
        return $this->token->getValue();
    }

    public function getCharactersConsumed(): int {
        return $this->token->getCharactersConsumed();
    }

    public function getTokenizer(): ?ITokenizer {
        return $this->tokenizer;
    }
}