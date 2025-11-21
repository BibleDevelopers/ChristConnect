<?php
// Simple TB plaintext -> JSON converter.
// Usage: php scripts/tb_text_to_json.php /path/to/tb.txt > database/seeders/data/tb.json
// The converter expects lines that include verse markers like: "Genesis 1:1 In the beginning..."
// It will try to normalize book names to lowercase underscores like 'genesis', 'song_of_songs'.

if ($argc < 2) {
    fwrite(STDERR, "Usage: php tb_text_to_json.php /path/to/tb.txt\n");
    exit(1);
}
$in = $argv[1];
if (!file_exists($in)) {
    fwrite(STDERR, "File not found: $in\n");
    exit(1);
}
$text = file_get_contents($in);
$text = str_replace("\r\n", "\n", $text);
$lines = preg_split('/\n/', $text);

$entries = [];
$currentBook = null;
foreach ($lines as $raw) {
    $line = trim($raw);
    if ($line === '') continue;

    // Try to match patterns like: "Genesis 1:1 ..." or "1:1 ..." when book context set
    if (preg_match('/^([A-Za-z\s]+)\s+(\d+):(\d+)\s+(.*)$/u', $line, $m)) {
        $book = trim($m[1]);
        $chapter = (int)$m[2];
        $verse = (int)$m[3];
        $text = trim($m[4]);
        $bookKey = strtolower(str_replace(' ', '_', $book));
        $entries[] = [
            'book' => $bookKey,
            'chapter' => $chapter,
            'verse' => $verse,
            'text' => $text,
        ];
        $currentBook = $bookKey;
        continue;
    }

    // Try to match when book already known: "1:1 ..."
    if (preg_match('/^(\d+):(\d+)\s+(.*)$/', $line, $m) && $currentBook) {
        $chapter = (int)$m[1];
        $verse = (int)$m[2];
        $text = trim($m[3]);
        $entries[] = [
            'book' => $currentBook,
            'chapter' => $chapter,
            'verse' => $verse,
            'text' => $text,
        ];
        continue;
    }

    // If none of the above, treat as continuation of previous verse
    if (!empty($entries)) {
        $last = array_pop($entries);
        $last['text'] = $last['text'] . ' ' . $line;
        $entries[] = $last;
        continue;
    }
}

// Output JSON array
echo json_encode($entries, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
