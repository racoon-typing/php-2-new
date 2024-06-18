<?php

namespace Taskforce\logic\convert;

use SplFileObject;
use Taskforce\exceptions\FileException;

class ImportCsv
{
    private $filename;
    private $tableName;
    private $fileObject;

    private $result;

    /**
     * ContactsImporter constructor.
     * @param $filename
     */
    public function __construct(string $filename, string $tableName)
    {
        $this->filename = $filename;
        $this->tableName = $tableName;
    }

    public function convert(): void
    {
        try {
            $this->fileObject = new SplFileObject($this->filename);
        } catch (FileException $err) {
            throw new FileException("Не удалось открыть файл на чтение: $err");
        }

        $headerData = $this->getHeaderData();
        $headerData = array_map(function($column) {
            return "`" . $column . "`";
        }, $headerData);

        $sql = "INSERT INTO `$this->tableName` (". implode(", ", $headerData) .") VALUES\n";
        $values = [];
        
        foreach($this->getNextLine() as $line) {
            $quotedValues = array_map(function($value) {
                return "'" . addslashes($value) . "'";
            }, $line);
            $values[] = "(" . implode(", ", $quotedValues) . ")";
        }

        $this->result = $sql . implode(",\n", $values) . ";";
    }

    public function getData():string {
        return $this->result;
    }

    private function getHeaderData(): ?array {
        $this->fileObject->rewind();
        $data = $this->fileObject->fgetcsv();

        return $data;
    }

    private function getNextLine(): ?iterable {
        $result = null;

        while(!$this->fileObject->eof()) {
            yield $this->fileObject->fgetcsv();
        }

        return $result;
    }
}
