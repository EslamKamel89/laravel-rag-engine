<?php

namespace App\Services\Document;

use Exception;
use Smalot\PdfParser\Parser;

class PdfParserService {
    public function __construct(protected Parser $parser) {
    }

    public function extractText(string $filePath): string {
        try {
            $pdf = $this->parser->parseFile($filePath);
            return $pdf->getText();
        } catch (\Exception $e) {
            throw new Exception(
                'failed to extract text from file at: ' . $filePath . '. Error message: ' . $e->getMessage(),
                $e->getCode(),
                $e->getPrevious()
            );
        }
    }
}
