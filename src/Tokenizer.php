<?php

declare(strict_types=1);

namespace Pst\Tokenizer;

use Pst\Core\CoreObject;
use Pst\Core\Types\Type;
use Pst\Core\Types\ITypeHint;
use Pst\Core\Enumerable\Enumerable;
use Pst\Core\Enumerable\IEnumerable;
use Pst\Core\Enumerable\ImmutableEnumerableLinqTrait;

use Pst\Tokenizer\Tokens\IToken;
use Pst\Tokenizer\TokenFactories\ITokenFactory;
use Pst\Tokenizer\TokenFactories\IEnumerableTokenFactory;

use Pst\Tokenizer\Exceptions\TokenizerException;
use Pst\Core\Exceptions\NotImplementedException;

use Closure;
use Traversable;
use ArrayIterator;
use Pst\Tokenizer\Tokens\IRetokenizeValueToken;
use Pst\Tokenizer\Tokens\TokenGroup;

class Tokenizer extends CoreObject implements ITokenizer {
    use ImmutableEnumerableLinqTrait {
        count as public linqCount;
    }

    private string $input = "";
    private array $registeredTokenFactories = [];
    private array $parsedTokens = [];

    public function __construct(string $input, ITokenFactory ...$factories) {
        $this->registerTokenFactories(...$factories);

        $this->setInput($input);
    }

    public function getIterator(): Traversable {
        return new ArrayIterator($this->parsedTokens);
    }

    public function T(): ITypeHint {
        return Type::interface(IToken::class);
    }

    public function count(?Closure $predicate = null): int {
        return $predicate === null ? count($this->parsedTokens) : $this->linqCount($predicate);
    }

    public function getParsedTokens(): IEnumerable {
        return Enumerable::create($this->parsedTokens, Type::interface(IToken::class));
    }

    public function tokenizeInput(string $input): IEnumerable {
        echo "Tokenizing input: $input\n";
        if (count($this->registeredTokenFactories) === 0) {
            throw new TokenizerException('No token factories registered');
        }

        $inputOffset = 0;
        $inputLength = strlen($input);
        $parsedTokens = [];

        while ($inputOffset < $inputLength) {
            $offsetedInput = substr($input, $inputOffset);

            foreach ($this->registeredTokenFactories as $factory) {
                if (($token = $factory->tryTokenize($offsetedInput)) !== null) {
                    $inputOffset += $token->getCharactersConsumed();
                    
                    if ($token instanceof IRetokenizeValueToken) {
                        $token = new TokenGroup(
                            $token->getName(),
                            $token->getCharactersConsumed(),
                            ...$token->getTokenizer()->tokenizeInput($token->getValue())->toArray()
                        );
                    }

                    $parsedTokens[] = $token;

                    continue 2;
                }
            }

            throw new TokenizerException("No token factory could tokenize '" . (strlen($offsetedInput) > 20 ? substr($offsetedInput, 0, 20) . " ..." : $offsetedInput ). "'.");
        }

        return Enumerable::create($parsedTokens, Type::interface(IToken::class));
    }

    public function registerTokenFactories(ITokenFactory ...$factories): ITokenizer {
        if (count($factories) === 0) {
            throw new \InvalidArgumentException('At least one token factory must be registered');
        }

        foreach ($factories as $factory) {
            if (isset($this->registeredTokenFactories[$factory->getName()])) {
                throw new \InvalidArgumentException('Token factory with name ' . $factory->getName() . ' already registered');
            }

            $this->registeredTokenFactories[$factory->getName()] = $factory;
        }

        if ($this->input !== "") {
            $this->parsedTokens = $this->tokenizeInput($this->input)->toArray();
        }

        return $this;
    }

    public function getInput(): string {
        return $this->input;
    }

    public function setInput(string $input): ITokenizer {
        if ($this->input !== $input) {
            $this->input = $input;
            $this->parsedTokens = $this->tokenizeInput($input)->toArray();
        }

        return $this;
    }

    public function getRegisteredTokenFactories(): IEnumerable {
        return Enumerable::create($this->registeredTokenFactories, Type::interface(ITokenFactory::class));
    }
}