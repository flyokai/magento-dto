<?php

namespace Flyokai\MagentoDto;

use Flyokai\DataMate\Helper\DtoTrait;

class CategoryContainer
{
    use DtoTrait;

    const ROOT_NAME = '[ROOT]';
    const GRAND_ROOT_NAME = '[__ROOT__]';

    const BY_ROW_ID = 0;
    const BY_SEQ_ID = 1;
    const BY_URL_PATH = 2;
    const BY_NAME_PATH = 3;

    /**
     * @var array<int, Category>
     */
    private array $byRowId = [];
    /**
     * @var array<int, Category>
     */
    private array $bySeqId = [];
    /**
     * @var array<string, Category>
     */
    private array $byUrlPath = [];
    /**
     * @var array<string, Category>
     */
    private array $byNamePath = [];

    /**
     * @var array<int, Category>
     */
    private array $rootByRowId = [];
    /**
     * @var array<int, Category>
     */
    private array $rootBySeqId = [];
    /**
     * @var array<string, Category>
     */
    private array $rootByName = [];

    /**
     * @param Category[] $rootCategories
     * @param Category[] $categories
     */
    public function __construct(
        private array $rootCategories,
        private array $categories,
        public readonly bool  $urlPathPrependRoot,
        public readonly string $delimiter,
        public readonly ?string $suffix,
        public readonly string $systemDelimiter = '>',
    )
    {
        $this->initialize();
    }

    private function initialize(): void
    {
        foreach ($this->categories as $category) {
            $entityId = $category->entity_id;
            $rowId = $category->row_id;
            $this->byRowId[$rowId] = $category;
            $this->bySeqId[$entityId] = $category;
            if ($category->name_path) {
                foreach ([$this->delimiter, $this->systemDelimiter] as $delimiter) {
                    $namePath = implode($delimiter, array_map(
                        fn ($name) => strtolower(trim((string)$name)),
                        $category->name_path
                    ));
                    $this->byNamePath[$namePath] = $category;
                }
            }
            if (($urlPath = $category->url_path)) {
                if (($suffix = $this->suffix)) {
                    $suffixLen = strlen((string)$suffix);
                    $additionalKey = substr($urlPath, -$suffixLen) === $suffix
                        ? substr($urlPath, 0, strlen($urlPath) - $suffixLen)
                        : $urlPath . $suffix;
                    $this->byUrlPath[$additionalKey] = $category;
                }
                $this->byUrlPath[$urlPath] = $category;
            }
        }

        foreach ($this->rootCategories as $category) {
            $entityId = $category->entity_id;
            $rowId = $category->row_id;
            $name = $category->name;
            $this->rootByRowId[$rowId] = $category;
            $this->rootBySeqId[$entityId] = $category;
            $this->rootByName[$name] = $category;
        }
    }

    private array $refreshUrlRewriteIds = [];
    public function resetRefreshUrlRewriteIds(): void
    {
        $this->refreshUrlRewriteIds = [];
    }
    public function addRefreshUrlRewriteRowIds(array $rowIds): void
    {
        foreach ($rowIds as $rowId) {
            $this->refreshUrlRewriteIds[$rowId] = $this->getByRowId($rowId)->entity_id;
        }
    }
    public function getRefreshUrlRewriteIds(): array
    {
        return $this->refreshUrlRewriteIds;
    }

    /**
     * @param Category[] $categories
     * @return void
     */
    public function addCategories(array $categories): void
    {
        foreach ($categories as $category) {
            $this->categories[] = $category;
        }
        $this->initialize();
    }

    public function __wakeup(): void
    {
        $this->initialize();
    }

    public function get(int|string $key, int $by): ?Category
    {
        return match ($by) {
            self::BY_ROW_ID => $this->getByRowId($key),
            self::BY_SEQ_ID => $this->getBySeqId($key),
            self::BY_URL_PATH => $this->getByUrlPath($key),
            self::BY_NAME_PATH => $this->getByNamePath($key ),
            default => throw new \ValueError(sprintf(
                "Unknown 'by' parameter; expected one of %s given %s",
                implode(',', [self::BY_ROW_ID, self::BY_SEQ_ID, self::BY_URL_PATH, self::BY_NAME_PATH]),
                $by
            )),
        };
    }

    public function getByRowId(int $key): ?Category
    {
        return $this->byRowId[$key]??null;
    }

    public function getBySeqId(int $key): ?Category
    {
        return $this->bySeqId[$key]??null;
    }

    public function getByUrlPath(string $key): ?Category
    {
        return $this->byUrlPath[$key]??null;
    }

    public function getByNamePath(string $key): ?Category
    {
        return $this->byNamePath[strtolower($key)]??null;
    }

    public function namePath(int|string $key, int $by): ?string
    {
        return $this->get($key, $by)?->namePath($this->delimiter);
    }

    /**
     * @return array<int, Category>
     */
    public function byRowId(): array
    {
        return $this->byRowId;
    }

    /**
     * @return array<int, Category>
     */
    public function bySeqId(): array
    {
        return $this->bySeqId;
    }

    /**
     * @return array<string, Category>
     */
    public function byUrlPath(): array
    {
        return $this->byUrlPath;
    }

    /**
     * @return array<string, Category>
     */
    public function byNamePath(): array
    {
        return $this->byNamePath;
    }

    /**
     * @return Category[]
     */
    public function categories(): array
    {
        return $this->categories;
    }

    /**
     * @return Category[]
     */
    public function rootCategories(): array
    {
        return $this->rootCategories;
    }

    public function rootByRowId(int $key): ?Category
    {
        return $this->rootByRowId[$key]??null;
    }

    public function rootBySeqId(int $key): ?Category
    {
        return $this->rootBySeqId[$key]??null;
    }

    public function rootByName(string $key): ?Category
    {
        return $this->rootByName[$key]??null;
    }

}
