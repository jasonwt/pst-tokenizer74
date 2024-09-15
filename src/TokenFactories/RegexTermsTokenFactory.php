<?php

declare(strict_types=1);

namespace Pst\Tokenizer\TokenFactories;

class RegexTermsTokenFactory extends RegexTokenFactory implements IRegexTermsTokenFactory {
    public function __construct(string $tokenName, array $terms, ?string $termination = null, ?int $priority = null) {
        $regexPatterns = array_reduce($terms, function($carry, $term) {
            $value = preg_quote($term, '/');
            $carry[$term] ??= $value;
            return $carry;
        }, []);

        // sort by length longest to shortest
        uasort($terms, function($a, $b) {
            return strlen($b) - strlen($a);
        });

        parent::__construct($tokenName, $regexPatterns, $termination, $priority ?? 0);
    }

    public function getTerms(): array {
        return array_keys($this->getPatterns());
    }
}