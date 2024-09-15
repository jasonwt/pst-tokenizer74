<?php

declare(strict_types=1);

namespace Pst\Tokenizer\TokenFactories;

use Pst\Core\CoreObject;

use Pst\Tokenizer\OpenCloseTerm;

use InvalidArgumentException;

abstract class TokenFactory extends CoreObject implements ITokenFactory {
    private string $name;
    private int $priority;

    protected function __construct(string $name, ?int $priority = null) {
        if (empty($this->name = trim($name))) {
            throw new InvalidArgumentException('Name cannot be empty');
        }

        $this->priority = $priority ?? 0;
    }

    public function getPriority(): int {
        return $this->priority;
    }

    public function getName(): string {
        return $this->name;
    }

    public static function WhitespaceTokenFactory(?string $termination = null, int $priority = 0): ITokenFactory {
        return new RegexTokenFactory('Whitespace', ['\s+'], $termination, $priority);
    }

    public static function WordTokenFactory(?string $termination = null, int $priority = 0): ITokenFactory {
        return new RegexTokenFactory('Word', ['[a-zA-Z_][a-zA-Z0-9_]*'], $termination, $priority);
    }

    public static function SingleQuotedStringTokenFactory(?string $termination = null, int $priority = 0): ITokenFactory {
        return new RegexTokenFactory('SingleQuotedString', ["'(?:(?:[^'\\\\]|\\\\.)*)'"], $termination, $priority);
    }

    public static function DoubleQuotedStringTokenFactory(?string $termination = null, int $priority = 0): ITokenFactory {
        return new RegexTokenFactory('DoubleQuotedString', ['"(?:(?:[^"\\\\]|\\\\.)*)"'], $termination, $priority);
    }

    public static function QuotedStringTokenFactory(?string $termination = null, int $priority = 0): ITokenFactory {
        return new RegexTokenFactory('QuotedString', ["'(?:(?:[^'\\\\]|\\\\.)*)'", '"(?:(?:[^"\\\\]|\\\\.)*)"'], $termination, $priority);
    }

    public static function IntegerTokenFactory(?string $termination = null, int $priority = 0): ITokenFactory {
        return new RegexTokenFactory('Numeric', ['(?:(?:\-)?\d+)'], $termination, $priority);
    }

    public static function FloatTokenFactory(?string $termination = null, int $priority = 0): ITokenFactory {
        return new RegexTokenFactory('Numeric', ['(?:(?:\-)?\d+\.\d+)'], $termination, $priority);
    }

    public static function NumericTokenFactory(?string $termination = null, int $priority = 0): ITokenFactory {
        return new RegexTokenFactory('Numeric', ['(?:(?:\-)?\d+)', '(?:(?:\-)?\d+\.\d+)'], $termination, $priority);
    }

    public static function BlockTokenFactory(OpenCloseTerm $openCloseTerm, array $ignoreOpenCloseTerms = [], ?string $termination = null, int $priority = 0) {
        $open = $openCloseTerm->getOpenPattern();
        $close = $openCloseTerm->getClosePattern();

        $openClose = $open . $close;

        $quotedIgnore = implode("", array_map(function(OpenCloseTerm $openCloseTerm) {
            $openPattern = $openCloseTerm->getOpenPattern();
            $closePattern = $openCloseTerm->getClosePattern();

            return $openPattern === $closePattern ? $openPattern : $openPattern . $closePattern;
        }, $ignoreOpenCloseTerms));

        $quotedIgnore = str_replace("'", "\'", $quotedIgnore);

        $combined = $openClose . $quotedIgnore;

        $pattern = "{$open}(?:[^{$combined}]+|[{$quotedIgnore}][^{$quotedIgnore}]*[{$quotedIgnore}]|{$open}(?:[^{$combined}]+|[{$quotedIgnore}][^{$quotedIgnore}]*[{$quotedIgnore}])*{$close})*{$close}";
        
        //echo "\n\n" . $pattern . "\n\n";

        return new RegexTokenFactory('ParenthesisOpenToClose', [$pattern], $termination, $priority);
    }

    // function for open ( and closing )
    public static function ParenthesisBlockTokenFactory(array $ignoreOpenCloseTerms = [], ?string $termination = null, int $priority = 0): ITokenFactory {
        return static::BlockTokenFactory(OpenCloseTerm::new('(', ')'), $ignoreOpenCloseTerms, $termination, $priority);
    }

    // function for open [ and closing ]
    public static function SquareBracketBlockTokenFactory(array $ignoreOpenCloseTerms = [], ?string $termination = null, int $priority = 0): ITokenFactory {
        return static::BlockTokenFactory(OpenCloseTerm::new('[', ']'), $ignoreOpenCloseTerms, $termination, $priority);
    }

    // function for open { and closing }
    public static function CurlyBracketBlockTokenFactory(array $ignoreOpenCloseTerms = [], ?string $termination = null, int $priority = 0): ITokenFactory {
        return static::BlockTokenFactory(OpenCloseTerm::new('{', '}'), $ignoreOpenCloseTerms, $termination, $priority);
    }

    public static function SymbolsTokenFactory(?string $termination = null, int $priority = 0): ITokenFactory {
        $symbols = ['(', ')', '[', ']', '{', '}', ',', '.', ';', ':', '?', '!', '+', '-', '*', '/', '%', '&', '|', '^', '~', '=', '<', '>', '@', '#', '$', '_', '\\', '/', '"', '\'', '`'];
        return new RegexTokenFactory('Symbols', array_map(fn($symbol) => preg_quote($symbol, '/'), $symbols), $termination, $priority);
    }
}