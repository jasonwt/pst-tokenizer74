<?php

declare(strict_types=1);

use Pst\Tokenizer\TokenFactory;

require_once(__DIR__ . '/../vendor/autoload.php');

$input = "    this is a test";

print_r(TokenFactory::SingleQuotedStringTokenFactory()->tryTokenize("' this is a test '"));
print_r(TokenFactory::DoubleQuotedStringTokenFactory()->tryTokenize('" this is a test "'));
print_r(TokenFactory::QuotedStringTokenFactory()->tryTokenize("' this is a test '"));
print_r(TokenFactory::QuotedStringTokenFactory()->tryTokenize('" this is a test "'));
print_r(TokenFactory::IntegerTokenFactory()->tryTokenize("123"));
print_r(TokenFactory::FloatTokenFactory()->tryTokenize("123.456"));
print_r(TokenFactory::NumericTokenFactory()->tryTokenize("123"));
print_r(TokenFactory::NumericTokenFactory()->tryTokenize("123.456"));
print_r(TokenFactory::ParenthesisOpenToCloseTokenFactory()->tryTokenize("( this is ( a test and ) i hope it ) works"));
print_r(TokenFactory::ParenthesisOpenToCloseTokenFactory()->tryTokenize("( this is ( a test')' and ) i hope it ) works"));
print_r(TokenFactory::ParenthesisOpenToCloseTokenFactory()->tryTokenize("( this is ( \"(\" a test and ) i hope it ) works")); // null