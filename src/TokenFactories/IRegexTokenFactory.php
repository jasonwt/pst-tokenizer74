<?php

declare(strict_types=1);

namespace Pst\Tokenizer\TokenFactories;


interface IRegexTokenFactory extends ITokenFactory {
    public function getPatterns(): array;
}