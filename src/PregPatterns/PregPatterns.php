<?php

declare(strict_types=1);

namespace Pst\Tokenizer\PregPatterns;

class PregPatterns {
    private static int $maxBetweenPatternDepth = 21;
    private function __construct() {}

    public static function betweenPattern(BetweenTerms $betweenTerms, BetweenTerms ...$ignoreBetweenTerms): string {
        $start = $betweenTerms->getStartingPattern();
        $end = $betweenTerms->getEndingPattern();

        print_r($betweenTerms);

        if (count($ignoreBetweenTerms) === 0) {
            return "{$start}.*?{$end}";
        }

        $startEnd = $start . $end;

        $ignoreBetweenPatterns = implode("", array_map(function(BetweenTerms $terms) {
            $startIgnore = $terms->getStartingPattern();
            $endIgnore = $terms->getEndingPattern();

            return $startIgnore == $endIgnore ? $startIgnore : $startIgnore . $endIgnore;
        }, $ignoreBetweenTerms));

        $quotedIgnore = str_replace("'", "\\'", $ignoreBetweenPatterns);

        $combined = $startEnd . $quotedIgnore;

        return
            "(?:{$start})((?:[^{$combined}]+|[{$quotedIgnore}][^{$quotedIgnore}]*[{$quotedIgnore}]|" .
            implode("|", array_fill(0, self::$maxBetweenPatternDepth - 1, "(?:{$start})(?:[^{$combined}]+|[{$quotedIgnore}][^{$quotedIgnore}]*[{$quotedIgnore}]")) . 
            implode("", array_fill(0, self::$maxBetweenPatternDepth - 1, ")*(?:{$end})")) .
            ")*)(?:{$end})";
    }

    public static function betweenSingleQuotesPattern(bool $ignoreEscaped = true): string {
        return $ignoreEscaped ? static::betweenPattern(new BetweenTerms("'"), new BetweenTerms("\\'")) : static::betweenPattern(new BetweenTerms("'"));
    }

    public static function betweenDoubleQuotesPattern(bool $ignoreEscaped = false): string {
        return $ignoreEscaped ? static::betweenPattern(new BetweenTerms('"'), new BetweenTerms('\\"')) : static::betweenPattern(new BetweenTerms('"'));
    }

    public static function betweenBackticksPattern(bool $ignoreEscaped = false): string {
        return $ignoreEscaped ? static::betweenPattern(new BetweenTerms('`'), new BetweenTerms('\\`')) : static::betweenPattern(new BetweenTerms('`'));
    }

    public static function betweenParenthesesPattern(BetweenTerms ...$ignoreBetweenTerms): string {
        return static::betweenPattern(new BetweenTerms('(', ')'), ...$ignoreBetweenTerms);
    }

    public static function betweenCurlyBracesPattern(BetweenTerms ...$ignoreBetweenTerms): string {
        return static::betweenPattern(new BetweenTerms('{', '}'), ...$ignoreBetweenTerms);
    }

    public static function betweenSquareBracketsPattern(BetweenTerms ...$ignoreBetweenTerms): string {
        return static::betweenPattern(new BetweenTerms('[', ']'), ...$ignoreBetweenTerms);
    }

    public static function integerPattern(): string {
        return '(?:-)?\d+';
    }

    public static function floatPattern(): string {
        return '(?:-)?\d+\.\d+';
    }

    public static function numericPattern(): string {
        return '(?:-)?\d+(?:\.\d+)?';
    }

    public static function symbolsPattern(): string {
        return '[^\p{L}\p{N}_]+';
    }

    public static function emailPattern(): string {
        return '[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}';
    }

    public static function domainNamePattern(): string {
        return '[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}';
    }
}