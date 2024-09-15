<?php

declare(strict_types=1);

namespace Pst\Tokenizer\TokenFactories;

use Pst\Core\CoreObject;

use Pst\Tokenizer\Tokens\IToken;

class IEnumerableTokenFactory extends CoreObject implements ITokenFactory {
    private ITokenFactory $factory;

    public function __construct(ITokenFactory $factory) {
        $this->factory = $factory;
    }

    public function getPriority(): int {
        return $this->factory->getPriority();
    }

    public function getName(): string {
        return $this->factory->getName();
    }

    public function tryTokenize(string $input): ?IToken {
        return $this->factory->tryTokenize($input);
    }
}