<?php

namespace Katyusha\Framework\Spreadsheets\Csv;

use ParseCsv\Csv as ParseCsv;

class CsvDocument
{
    public array $data = [];

    public function __construct(protected string $path, protected string $separator)
    {
        $this->parse();
    }

    protected function parse(): self
    {
        $parser = new ParseCsv();
        $parser->parseFile($this->path);
        $this->data = $parser->data;

        return $this;
    }
}
