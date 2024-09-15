<?php

declare(strict_types=1);

namespace Pst\Tokenizer;

use Pst\Core\ICoreObject;


interface IToken extends ICoreObject {
    public function getIndexOffset(): int;
    public function getName(): string;
    public function getValue(): string;
}