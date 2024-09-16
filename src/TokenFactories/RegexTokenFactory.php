<?php

declare(strict_types=1);

namespace Pst\Tokenizer\TokenFactories;

use Pst\Tokenizer\Tokens\IToken;
use Pst\Tokenizer\Tokens\Token;
use Pst\Tokenizer\Tokens\ITokenizedTokens;
use Pst\Tokenizer\Tokens\TokenizedTokens;

class RegexTokenFactory extends TokenFactory implements IRegexTokenFactory {
    private array $regexPatterns = [];
    private string $termination = "\s+|$";

    public function __construct(string $tokenName, string ...$regexPatterns) {
        parent::__construct($tokenName);

        $this->regexPatterns = $regexPatterns;
    }

    public function getPatterns(): array {
        return $this->regexPatterns;
    }

    public function getTermination(): string {
        return $this->termination != "" ? "(?:" . $this->termination . ")" : "";
    }

    public function setTermination(string $termination): void {
        $this->termination = trim($termination);
    }

    public function tryTokenize(string $input): ?IToken {
        $pattern = "(" . implode("|", $this->regexPatterns) . ")" . $this->getTermination();

        if (preg_match("/^" . $pattern . "/i", $input, $matches)) {
            return new Token($this->getName(), $matches[2] ?? $matches[1], strlen($matches[0]));
        }

        return null;
    }
}