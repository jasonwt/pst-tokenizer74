<?php

declare(strict_types=1);

namespace Pst\Tokenizer\TokenFactories;


interface IRegexTokenFactory extends ITokenFactory {
    public function getPatterns(): array;
    public function getTermination(): string;
    public function setTermination(string $termination): void;
}