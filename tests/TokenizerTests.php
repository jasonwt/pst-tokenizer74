<?php

declare(strict_types=1);

use Pst\Tokenizer\Tokenizer;
use Pst\Tokenizer\PregPatterns\BetweenTerms;
use Pst\Tokenizer\PregPatterns\PregPatterns;
use Pst\Tokenizer\TokenFactories\RegexTermsTokenFactory;
use Pst\Tokenizer\TokenFactories\RegexTokenFactory;

require_once(__DIR__ . '/../vendor/autoload.php');

$input = "(((1+(2*3))-4)/4) + 1";

class MathEquationTokenizer extends Tokenizer {
    public function __construct(string $input) {
        parent::__construct($input,
            new RegexTokenFactory("Parenthesis", PregPatterns::betweenPattern(new BetweenTerms("(", ")"), new BetweenTerms("'"))),
            new RegexTermsTokenFactory("Operators", "=", "+", "-", "*", "/"),
            new RegexTokenFactory("NumericLiterals", PregPatterns::numericPattern()),
        );
    }
}

$mathEquationTokenizer = new MathEquationTokenizer($input);

print_r($mathEquationTokenizer);