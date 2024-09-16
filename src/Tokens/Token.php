<?php

declare(strict_types=1);

namespace Pst\Tokenizer\Tokens;

use Pst\Core\CoreObject;

class Token extends CoreObject implements IToken {
    private int $charactersConsumed;

    private string $name;
    private $value;

    public function __construct(string $name, $value, int $charactersConsumed) {
        if (empty($this->name = trim($name))) {
            throw new \InvalidArgumentException('Name cannot be empty');
        }

        if (($this->charactersConsumed = $charactersConsumed) < 1) {
            throw new \InvalidArgumentException('Characters consumed must be greater than 1');
        }

        $this->value = $value;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getValue() {
        return $this->value;
    }

    public function getCharactersConsumed(): int {
        return $this->charactersConsumed;
    }
}