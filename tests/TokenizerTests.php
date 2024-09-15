<?php

declare(strict_types=1);

use Pst\Tokenizer\OpenCloseTerm;
use Pst\Tokenizer\TokenFactories\RegexTermsTokenFactory;
use Pst\Tokenizer\TokenFactories\TokenFactory;
use Pst\Tokenizer\Tokenizer;

require_once(__DIR__ . '/../vendor/autoload.php');

$input = "a = 1 + (2 * 3) - 4";

echo "\n\n$input\n\n";

$tokenizer = new Tokenizer($input, 
    new RegexTermsTokenFactory("Operators", ["=", "+", "-", "*", "/"]),
    TokenFactory::WordTokenFactory(),
    TokenFactory::ParenthesisBlockTokenFactory([OpenCloseTerm::new("'"), OpenCloseTerm::new('"')]),
    TokenFactory::NumericTokenFactory(),
    TokenFactory::WhitespaceTokenFactory(),
);

print_r($tokenizer);


// $input = "SELECT * FROM table WHERE column = 'value'";

// $mysqlTokenizer = new Tokenizer($input, 
//     new RegexTermsTokenFactory("Keywords", ["SELECT", "FROM", "WHERE"]),
//     TokenFactory::SymbolsTokenFactory(),
// );

// print_r($mysqlTokenizer);
// print_r($mysqlTokenizer->toArray());
// print_r($mysqlTokenizer);