<?php

declare(strict_types=1);

namespace Pst\Tokenizer\TokenFactories;

use Pst\Tokenizer\PregPatterns\BetweenTerms;
use Pst\Tokenizer\PregPatterns\PregPatterns;

class BetweenTokenFactory extends RegexTokenFactory implements IBetweenTokenFactory {
    public function __construct(string $name, BetweenTerms $betweenTerms, BetweenTerms ...$ignoreBetweenTerms) {
        parent::__construct($name, PregPatterns::betweenPattern($betweenTerms, ...$ignoreBetweenTerms));
    }
}