<?php

if (!function_exists('chunkText')) {
    function chunkText(string $content, int $maxCharacters = 1000): array {
        $paragraphs = preg_split('/\R{2,}/', trim($content));

        $chunks = [];
        $currentChunk = '';

        foreach ($paragraphs as $paragraph) {
            $paragraph = trim($paragraph);

            if ($paragraph === '') {
                continue;
            }

            $sentences = preg_split(
                '/(?<=[.!?])\s+/',
                $paragraph,
                -1,
                PREG_SPLIT_NO_EMPTY
            );

            foreach ($sentences as $sentence) {
                $sentence = trim($sentence);

                $candidate = $currentChunk === ''
                    ? $sentence
                    : $currentChunk . ' ' . $sentence;

                if (strlen($candidate) <= $maxCharacters) {
                    $currentChunk = $candidate;
                    continue;
                }

                if ($currentChunk !== '') {
                    $chunks[] = $currentChunk;
                }

                $currentChunk = $sentence;
            }
        }

        if ($currentChunk !== '') {
            $chunks[] = $currentChunk;
        }

        return $chunks;
    }
}
