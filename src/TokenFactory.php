<?php

declare(strict_types=1);

namespace Pst\Tokenizer;

use Pst\Core\CoreObject;

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

    public static function ParenthesisOpenToCloseTokenFactory(?string $termination = null, int $priority = 0): ITokenFactory {
        return new RegexTokenFactory('ParenthesisOpenToClose', ['\((?:[^()\'"`]+|\'[^\']*\'|`[^`]*`|\((?:[^()\'"`]+|\'[^\']*\'|`[^`]*`)*\))*\)'], $termination, $priority);
    }
}