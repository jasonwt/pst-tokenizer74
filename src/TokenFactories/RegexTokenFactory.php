<?php

declare(strict_types=1);

namespace Pst\Tokenizer\TokenFactories;

use Pst\Tokenizer\Tokens\Token;
use Pst\Tokenizer\Tokens\IToken;

class RegexTokenFactory extends TokenFactory implements IRegexTokenFactory {
    private array $regexPatterns = [];
    private string $termination;

    public function __construct(string $tokenName, array $regexPatterns, ?string $termination = null, ?int $priority = null) {
        parent::__construct($tokenName, $priority);

        $this->termination = $termination ?? "\s+|$";
        $this->regexPatterns = $regexPatterns;
    }

    public function getPatterns(): array {
        return $this->regexPatterns;
    }

    public function tryTokenize(string $input): ?IToken {
        $pattern = "(" . implode("|", $this->regexPatterns) . ")";

        if (!empty($termination = trim($this->termination))) {
            $termination = "(?:{$termination})";
        }

        if (preg_match("/^{$pattern}$termination/i", $input, $matches)) {
            var_dump($matches);
            
            return new Token(strlen($matches[0]), $this->getName(), $matches[1]);
        }

        return null;
    }
}