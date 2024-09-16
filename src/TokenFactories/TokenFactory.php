<?php

declare(strict_types=1);

namespace Pst\Tokenizer\TokenFactories;

use Pst\Core\CoreObject;

use Pst\Tokenizer\ITokenizer;
use Pst\Tokenizer\OpenCloseTerm;

use InvalidArgumentException;
use Pst\Tokenizer\PregPatterns\BetweenTerms;
use Pst\Tokenizer\PregPatterns\PregPatterns;

abstract class TokenFactory extends CoreObject implements ITokenFactory {
    private string $name;
    private int $priority = 0;

    protected function __construct(string $name, ?int $priority = null) {
        if (empty($this->name = trim($name))) {
            throw new InvalidArgumentException('Name cannot be empty');
        }

        $this->priority = $priority ?? 0;
    }

    public function getPriority(): int {
        return $this->priority;
    }

    public function setPriority(int $priority): void {
        $this->priority = $priority;
    }

    public function getName(): string {
        return $this->name;
    }

    // public static function WhitespaceTokenFactory(?string $termination = null, int $priority = 0): ITokenFactory {
    //     return new RegexTokenFactory('Whitespace', ['\s+'], $termination, $priority);
    // }

    // public static function WordTokenFactory(?string $termination = null, int $priority = 0): ITokenFactory {
    //     return new RegexTokenFactory('Word', ['[a-zA-Z_][a-zA-Z0-9_]*'], $termination, $priority);
    // }

    // public static function SingleQuotedStringTokenFactory(?string $termination = null, int $priority = 0): ITokenFactory {
    //     return new RegexTokenFactory('SingleQuotedString', ["'(?:(?:[^'\\\\]|\\\\.)*)'"], $termination, $priority);
    // }

    // public static function DoubleQuotedStringTokenFactory(?string $termination = null, int $priority = 0): ITokenFactory {
    //     return new RegexTokenFactory('DoubleQuotedString', ['"(?:(?:[^"\\\\]|\\\\.)*)"'], $termination, $priority);
    // }

    // public static function QuotedStringTokenFactory(?string $termination = null, int $priority = 0): ITokenFactory {
    //     //return new RegexTokenFactory('QuotedString', ["'(?:(?:[^'\\\\]|\\\\.)*)'", '"(?:(?:[^"\\\\]|\\\\.)*)"'], $termination, $priority);
    //     return new RegexTokenFactory('QuotedString', [PregPatterns::betweenSingleQuotesPattern(), PregPatterns::betweenDoubleQuotesPattern()], $termination, $priority);
    // }

    // public static function IntegerTokenFactory(?string $termination = null, int $priority = 0): ITokenFactory {
    //     return new RegexTokenFactory('Numeric', [PregPatterns::integerPattern()], $termination, $priority);
    // }

    // public static function FloatTokenFactory(?string $termination = null, int $priority = 0): ITokenFactory {
    //     return new RegexTokenFactory('Numeric', [PregPatterns::floatPattern()], $termination, $priority);
    // }

    // public static function NumericTokenFactory(?string $termination = null, int $priority = 0): ITokenFactory {
    //     return new RegexTokenFactory('Numeric', [PregPatterns::numericPattern()], $termination, $priority);
    // }

    public static function BetweenTokenFactory(string $name, BetweenTerms $betweenTerms, BetweenTerms ...$ignoreBetweenTerms): ITokenFactory {
        return new RegexTokenFactory($name, PregPatterns::betweenPattern($betweenTerms, ...$ignoreBetweenTerms));
    }

    public static function TokenizeBetweenTokenFactory(string $name, BetweenTerms $betweenTerms, ?ITokenizer $tokenizer = null, BetweenTerms ...$ignoreBetweenTerms): ITokenFactory {
        throw new InvalidArgumentException('Not implemented');
    }

    // public static function BlockTokenFactory(OpenCloseTerm $openCloseTerm, ?ITokenizer $tokenizer = null, array $ignoreOpenCloseTerms = [], ?string $termination = null, int $priority = 0): ITokenFactory {
    //     return new BlockTokenFactory('ParenthesisOpenToClose', $openCloseTerm, $tokenizer, $ignoreOpenCloseTerms, $termination, $priority);
    // }

    // // function for open ( and closing )
    // public static function ParenthesisBlockTokenFactory(?ITokenizer $tokenizer = null, array $ignoreOpenCloseTerms = [], ?string $termination = null, int $priority = 0): ITokenFactory {
    //     return static::BlockTokenFactory(OpenCloseTerm::new('(', ')'), $tokenizer, $ignoreOpenCloseTerms, $termination, $priority);
    // }

    // // function for open [ and closing ]
    // public static function SquareBracketBlockTokenFactory(?ITokenizer $tokenizer = null, array $ignoreOpenCloseTerms = [], ?string $termination = null, int $priority = 0): ITokenFactory {
    //     return static::BlockTokenFactory(OpenCloseTerm::new('[', ']'), $tokenizer, $ignoreOpenCloseTerms, $termination, $priority);
    // }

    // // function for open { and closing }
    // public static function CurlyBracketBlockTokenFactory(?ITokenizer $tokenizer = null, array $ignoreOpenCloseTerms = [], ?string $termination = null, int $priority = 0): ITokenFactory {
    //     return static::BlockTokenFactory(OpenCloseTerm::new('{', '}'), $tokenizer, $ignoreOpenCloseTerms, $termination, $priority);
    // }

    // public static function SymbolsTokenFactory(?string $termination = null, int $priority = 0): ITokenFactory {
    //     $symbols = ['(', ')', '[', ']', '{', '}', ',', '.', ';', ':', '?', '!', '+', '-', '*', '/', '%', '&', '|', '^', '~', '=', '<', '>', '@', '#', '$', '_', '\\', '/', '"', '\'', '`'];
    //     return new RegexTokenFactory('Symbols', array_map(fn($symbol) => preg_quote($symbol, '/'), $symbols), $termination, $priority);
    // }
}