<?php

declare(strict_types=1);

namespace Pst\Tokenizer\PregPatterns;

class BetweenTerms extends BetweenPatterns{
    private string $startingTerm;
    private string $endingTerm;
    private string $delimiter;

    public function __construct(string $startingTerm, ?string $endingTerm = null, ?string $delimiter = null) {
        if (($this->startingTerm = $startingTerm) === "") {
            throw new \InvalidArgumentException('Starting term cannot be empty.');
        } else if (strlen($this->startingTerm) > 1) {
            throw new \InvalidArgumentException('Starting term must be a single character.');
        }

        if (($this->endingTerm = ($endingTerm ?? $startingTerm)) === "") {
            throw new \InvalidArgumentException('Ending term cannot be empty.');
        } else if (strlen($this->endingTerm) > 1) {
            throw new \InvalidArgumentException('Ending term must be a single character.');
        }

        if (($this->delimiter = ($delimiter ?? "/")) === "") {
            throw new \InvalidArgumentException('Delimiter cannot be empty.');
        }

        parent::__construct(preg_quote($this->startingTerm, $this->delimiter), preg_quote($this->endingTerm, $this->delimiter));
    }

    public function getDelimiter(): string {
        return $this->delimiter;
    }

    public function getStartingTerm(): string {
        return $this->startingTerm;
    }

    public function getEndingTerm(): string {
        return $this->endingTerm;
    }
}