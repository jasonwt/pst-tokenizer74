<?php

declare(strict_types=1);

namespace Pst\Tokenizer;


interface IRegexTermsTokenFactory extends IRegexTokenFactory {
    public function getTerms(): array;
}