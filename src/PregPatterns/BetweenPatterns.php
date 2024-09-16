<?php

declare(strict_types=1);

namespace Pst\Tokenizer\PregPatterns;

class BetweenPatterns {
    private string $startingPattern;
    private string $endingPattern;

    public function __construct(string $startingPattern, ?string $endingPattern = null) {
        if (empty($this->startingPattern = $startingPattern)) {
            throw new \InvalidArgumentException('Starting pattern cannot be empty.');
        }

        if (empty($this->endingPattern = ($endingPattern ?? $startingPattern))) {
            throw new \InvalidArgumentException('Ending pattern cannot be empty.');
        }
    }

    public function getStartingPattern(bool $noCapture = true): string {
        //return $this->startingPattern;
        return $noCapture ? "(?:{$this->startingPattern})" : $this->startingPattern;
    }

    public function getEndingPattern(bool $noCapture = true): string {
        //return $this->endingPattern;
        return $noCapture ? "(?:{$this->endingPattern})" : $this->endingPattern;
    }
}