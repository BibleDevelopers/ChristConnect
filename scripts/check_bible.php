<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$count = \DB::table('bible_verses')->count();
echo "total rows: $count\n";
$kjv = \DB::table('bible_verses')->where('version','kjv')->count();
echo "kjv rows: $kjv\n";
$sample = \DB::select("select id, version, book, chapter, verse from bible_verses order by id desc limit 20");
foreach ($sample as $r) {
    echo "{$r->id} | {$r->version} | {$r->book} | {$r->chapter} | {$r->verse}\n";
}
