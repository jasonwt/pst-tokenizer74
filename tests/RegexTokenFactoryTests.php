<?php

declare(strict_types=1);

use Pst\Tokenizer\OpenCloseTerm;
use Pst\Tokenizer\TokenFactory;

require_once(__DIR__ . '/../vendor/autoload.php');



// print_r(TokenFactory::SingleQuotedStringTokenFactory()->tryTokenize("' this is a test '"));
// print_r(TokenFactory::DoubleQuotedStringTokenFactory()->tryTokenize('" this is a test "'));
// print_r(TokenFactory::QuotedStringTokenFactory()->tryTokenize("' this is a test '"));
// print_r(TokenFactory::QuotedStringTokenFactory()->tryTokenize('" this is a test "'));
// print_r(TokenFactory::IntegerTokenFactory()->tryTokenize("123"));
// print_r(TokenFactory::FloatTokenFactory()->tryTokenize("123.456"));
// print_r(TokenFactory::NumericTokenFactory()->tryTokenize("123"));
// print_r(TokenFactory::NumericTokenFactory()->tryTokenize("123.456"));
// print_r(TokenFactory::ParenthesisOpenToCloseTokenFactory()->tryTokenize("( this is ( a test and ) i hope it ) works"));
// print_r(TokenFactory::ParenthesisOpenToCloseTokenFactory()->tryTokenize("( this is ( a test')' and ) i hope it ) works"));
// print_r(TokenFactory::ParenthesisOpenToCloseTokenFactory()->tryTokenize("( this is ( \"(\" a test and ) i hope it ) works")); // null



//print_r(TokenFactory::ParenthesisOpenToCloseTokenFactory()->tryTokenize("A 1 A YAY 2 B ZAZ 3 B 4")); // null
print_r(TokenFactory::ParenthesisBlockTokenFactory([OpenCloseTerm::new("'"), OpenCloseTerm::new('"'), OpenCloseTerm::new('`')])->tryTokenize("( 1 ( '(' 2 ) \"(\" 3 ) 4")); // null
//print_r(TokenFactory::ParenthesisOpenToCloseTokenFactory()->tryTokenize("A 1 A 'A' 2 A 'B' 3 B 4")); // null
//print_r(TokenFactory::ParenthesisOpenToCloseTokenFactory()->tryTokenize("A this is A YAY ZAZ a test and B i hope it B works")); // null