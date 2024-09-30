<?php

declare(strict_types=1);

namespace Pst\Tokenizer\Tokens;

use Pst\Core\Interfaces\ICoreObject;

interface IToken extends ICoreObject {
    public function getName(): string;
    public function getValue();
    public function getCharactersConsumed(): int;
}