<?php

declare(strict_types=1);

namespace Pst\Tokenizer;

use Pst\Core\CoreObject;
use Pst\Core\ICoreObject;

final class OpenCloseTerm extends CoreObject implements ICoreObject {
    private string $delimiter;
    private string $openTerm;
    private string $closeTerm;

    public function __construct(string $openTerm, ?string $closeTerm = null, string $delimiter = "/") {
        if (($this->delimiter = $delimiter) === "") {
            throw new \InvalidArgumentException("Delimiter cannot be empty");
        }

        $this->openTerm = $openTerm;
        $this->closeTerm = $closeTerm ?? $openTerm;
    }

    public function getOpenTerm(): string {
        return $this->openTerm;
    }

    public function getOpenPattern(): string {
        return "(?:" . preg_quote($this->openTerm, $this->delimiter) . ")";
    }

    public function getCloseTerm(): string {
        return $this->closeTerm;
    }

    public function getClosePattern(): string {
        return "(?:" . preg_quote($this->closeTerm, $this->delimiter) . ")";
    }

    public function getDelimiter(): string {
        return $this->delimiter;
    }

    public static function new(string $openTerm, ?string $closeTerm = null, string $delimiter = "/"): OpenCloseTerm {
        return new OpenCloseTerm($openTerm, $closeTerm, $delimiter);
    }

    public static function SingleQuotes(string $delimiter = "/"): OpenCloseTerm {
        return new OpenCloseTerm("'", "'", $delimiter);
    }
}