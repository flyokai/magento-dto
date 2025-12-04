<?php

namespace Flyokai\MagentoDto\Category\Attribute;

use Flyokai\DataMate\Helper\DtoTrait;

class OptionContainer
{
    use DtoTrait;

    /**
     * @var array<string|int, Option>
     */
    private array $byValue = [];
    /**
     * @var array<string, Option>
     */
    private array $byText = [];

    /**
     * @param Option[] $options
     */
    public function __construct(
        private array $options,
        public readonly bool $caseSensitiveOptions,
    )
    {
        $this->initialize();
    }

    private function initialize(): void
    {
        $this->byValue = $this->byText = [];
        foreach ($this->options as $option) {
            $value = $option->value;
            $this->byValue[$value] = $option;
            $text = trim($option->label);
            if (!$this->caseSensitiveOptions) {
                $text = strtolower($text);
            }
            $this->byText[$text] = $option;
        }
    }

    /**
     * @param Option[] $options
     * @return void
     */
    public function addOptions(array $options): void
    {
        foreach ($options as $option) {
            $this->options[] = $option;
        }
        $this->initialize();
    }

    public function __wakeup(): void
    {
        $this->initialize();
    }

    public function getById(int|string $value): ?Option
    {
        return $this->get($value, false);
    }

    public function getByText(int|string $value): ?Option
    {
        return $this->get($value, true);
    }

    public function get(int|string $value, bool $byText): ?Option
    {
        $value = (string)$value;
        if ($byText) {
            $value = trim($value);
            if (!$this->caseSensitiveOptions) {
                $value = strtolower($value);
            }
            return $this->byText[$value]??null;
        }
        return $this->byValue[$value]??null;
    }

    /**
     * @var array<string|int, Option>
     */
    public function byValue(): array
    {
        return $this->byValue;
    }

    /**
     * @var array<string, Option>
     */
    public function byText(): array
    {
        return $this->byText;
    }

    /**
     * @return Option[]
     */
    public function options(): array
    {
        return $this->options;
    }
}
