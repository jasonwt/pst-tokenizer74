<?php

declare(strict_types=1);

namespace Pst\Tokenizer\Tokens;

use Pst\Core\CoreObject;

class Token extends CoreObject implements IToken {
    private int $indexOffset;
    private string $name;
    private string $value;

    public function __construct(int $indexOffset, string $name, string $value) {
        if (($this->indexOffset = $indexOffset) < 0) {
            throw new \InvalidArgumentException('Index offset must be greater than or equal to 0');
        }

        if (empty($this->name = trim($name))) {
            throw new \InvalidArgumentException('Name cannot be empty');
        }

        $this->value = $value;
    }

    public function getIndexOffset(): int {
        return $this->indexOffset;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getValue(): string {
        return $this->value;
    }
}