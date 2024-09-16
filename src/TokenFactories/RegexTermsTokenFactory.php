<?php

declare(strict_types=1);

namespace Pst\Tokenizer\TokenFactories;

class RegexTermsTokenFactory extends RegexTokenFactory implements IRegexTermsTokenFactory {
    public function __construct(string $tokenName, string ...$terms) {
        if (count($terms) === 0) {
            throw new \InvalidArgumentException('At least one term must be provided');
        }

        uasort($terms, function($a, $b) {
            return strlen($b) - strlen($a);
        });

        $regexPatterns = array_map(function($term) {
            if ($term === '') {
                throw new \InvalidArgumentException('Empty term provided');
            }

            return preg_quote($term, '/');
        }, $terms);

        

        // sort by length longest to shortest
        

        parent::__construct($tokenName, ...$regexPatterns);
    }

    public function getTerms(): array {
        return array_keys($this->getPatterns());
    }
}