<?php

declare(strict_types=1);

use Pst\Tokenizer\RegexTermsTokenFactory;

require_once(__DIR__ . '/../vendor/autoload.php');

$keyWords = [
    "th",
    "this",
    "is",
    "a"
];

print_r((new RegexTermsTokenFactory("keywords", $keyWords))->tryTokenize("this is a test"));
print_r((new RegexTermsTokenFactory("keywords", $keyWords))->tryTokenize("cart"));
print_r((new RegexTermsTokenFactory("keywords", $keyWords))->tryTokenize("is a test"));
print_r((new RegexTermsTokenFactory("keywords", $keyWords))->tryTokenize("a test"));
print_r((new RegexTermsTokenFactory("keywords", $keyWords))->tryTokenize("th"));


