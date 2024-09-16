<?php

declare(strict_types=1);

namespace Pst\Tokenizer;

use Pst\Core\ICoreObject;
use Pst\Core\Collections\IEnumerable;

use Pst\Tokenizer\TokenFactories\ITokenFactory;

interface ITokenizer extends ICoreObject, IEnumerable {
    public function getInput(): string;
    public function getParsedTokens(): IEnumerable;
    public function getRegisteredTokenFactories(): IEnumerable;

    public function setInput(string $inpt): ITokenizer;
    public function tokenizeInput(string $input): IEnumerable;
    public function registerTokenFactories(ITokenFactory ...$factories): ITokenizer;
}