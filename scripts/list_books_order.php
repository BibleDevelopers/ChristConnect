<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$bookOrder = [
    'genesis','exodus','leviticus','numbers','deuteronomy','joshua','judges','ruth',
    'samuel','kings','chronicles','ezra','nehemiah','esther','job','psalms','proverbs',
    'ecclesiastes','song_of_songs','isaiah','jeremiah','lamentations','ezekiel','daniel',
    'hosea','joel','amos','obadiah','jonah','micah','nahum','habakkuk','zephaniah','haggai',
    'zechariah','malachi','matthew','mark','luke','john','acts','romans','corinthians',
    'galatians','ephesians','philippians','colossians','thessalonians','timothy','titus',
    'philemon','hebrews','james','peter','jude','revelation'
];

$rows = \DB::table('bible_verses')
    ->select('book', \DB::raw('MAX(chapter) as chapters'))
    ->groupBy('book')
    ->get()
    ->map(function ($r) { return ['book' => $r->book, 'chapters' => (int)$r->chapters]; })
    ->toArray();

usort($rows, function ($a, $b) use ($bookOrder) {
    $ia = array_search($a['book'], $bookOrder, true);
    $ib = array_search($b['book'], $bookOrder, true);
    if ($ia === false && $ib === false) return strcmp($a['book'], $b['book']);
    if ($ia === false) return 1;
    if ($ib === false) return -1;
    return $ia <=> $ib;
});

foreach ($rows as $r) {
    echo sprintf("%s (%d)\n", $r['book'], $r['chapters']);
}
