<?php

declare(strict_types=1);

namespace Pst\Tokenizer;


interface IRegexTokenFactory extends ITokenFactory {
    public function getPatterns(): array;
}