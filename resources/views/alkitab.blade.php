<x-app class="alkitab-background">

    <div class="alkitab-container">
        
        <div class="controls-wrapper">
            <select id="version-select">
                <option value="tb">Indonesia (TB)</option>
                <option value="kjv">English (KJV)</option>
            </select>
            <select id="book-select">
                <option value="">Select Book</option>
                @foreach ($books as $book)
                    <option value="{{ $book['id'] }}" data-chapters="{{ $book['chapters'] }}">{{ $book['name'] }}</option>
                @endforeach
            </select>
            <select id="chapter-select" disabled><option value="">Pilih Pasal</option></select>
            <select id="verse-select" disabled><option value="">Pilih Ayat</option></select>
            <input type="search" id="search-input" placeholder="Search verse...">
            <button id="search-button">Search</button>
        </div>

        <div id="loading-indicator">Loading...</div>

        <div id="search-results" class="search-results"></div>
        <div id="content-area" class="content-area"></div>

    </div>

</x-app>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const versionSelect = document.getElementById('version-select');
    const bookSelect = document.getElementById('book-select');
    const chapterSelect = document.getElementById('chapter-select');
    const verseSelect = document.getElementById('verse-select');
    const searchInput = document.getElementById('search-input');
    const searchButton = document.getElementById('search-button');
    const contentArea = document.getElementById('content-area');
    const loading = document.getElementById('loading-indicator');

    loading.style.display = 'none';

    function showLoading(show) { loading.style.display = show ? '' : 'none'; }

    
    bookSelect.addEventListener('change', function () {
        const chapters = parseInt(bookSelect.selectedOptions[0]?.dataset.chapters || 0, 10);
        chapterSelect.innerHTML = '';
        verseSelect.innerHTML = '';
        if (!chapters) {
            chapterSelect.disabled = true;
            verseSelect.disabled = true;
            return;
        }
        chapterSelect.disabled = false;
        let opts = ['<option value="">Select Chapter</option>'];
        for (let i=1;i<=chapters;i++) opts.push(`<option value="${i}">${i}</option>`);
        chapterSelect.innerHTML = opts.join('');
        verseSelect.disabled = true;
    });

    
    chapterSelect.addEventListener('change', function () {
        const version = versionSelect.value;
        const book = bookSelect.value;
        const chapter = chapterSelect.value;
        if (!version || !book || !chapter) return;
        showLoading(true);
        fetch(`/api/alkitab/${encodeURIComponent(version)}/${encodeURIComponent(book)}/${encodeURIComponent(chapter)}`)
            .then(r => r.json())
            .then(json => {
                showLoading(false);
                renderVerses(json);
            }).catch(e => { showLoading(false); contentArea.innerHTML = '<div style="color:red">Unable to load chapter.</div>'; });
    });

    searchButton.addEventListener('click', function (e) {
        e.preventDefault();
        const q = searchInput.value.trim();
        if (!q) return;
        const version = versionSelect.value;
        const book = bookSelect.value;
        const chapter = chapterSelect.value;
        showLoading(true);
        const params = new URLSearchParams({ q });
        if (book) params.set('book', book);
        if (chapter) params.set('chapter', chapter);
        fetch(`/api/alkitab/search/${encodeURIComponent(version)}?${params.toString()}`)
            .then(r => r.json())
            .then(json => {
                showLoading(false);
                renderSearchResults(json);
            }).catch(e => { showLoading(false); contentArea.innerHTML = '<div style="color:red">Search failed.</div>'; });
    });

    function renderVerses(verses) {
        if (!verses || verses.length === 0) {
            contentArea.innerHTML = '<p>No verses found.</p>';
            return;
        }
        let html = '<div class="verse-list">';
        verses.forEach(v => {
            const text = v.text ?? v.verse_text ?? v.content ?? JSON.stringify(v);
            const number = v.verse ?? v.verse_number ?? v.verse_no ?? '';
            html += `<div class="verse"><strong class="number">${number}</strong> ${escapeHtml(text)}</div>`;
        });
        html += '</div>';
        contentArea.innerHTML = html;
    }

    function renderSearchResults(rows) {
        if (!rows || rows.length === 0) {
            contentArea.innerHTML = '<p>No results.</p>';
            return;
        }
        let html = '<div class="search-list">';
        rows.forEach(r => {
            const book = r.book ?? r.book_name ?? '';
            const chapter = r.chapter ?? r.chapter_no ?? '';
            const verse = r.verse ?? r.verse_number ?? '';
            const text = r.text ?? r.verse_text ?? r.content ?? JSON.stringify(r);
            html += `<div style="margin-bottom:1rem;"><div style="font-weight:600">${escapeHtml(book)} ${chapter}:${verse}</div><div>${escapeHtml(text)}</div></div>`;
        });
        html += '</div>';
        contentArea.innerHTML = html;
    }

    function escapeHtml(unsafe) {
        return String(unsafe).replace(/[&<>\"']/g, function(m){return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m];});
    }
});
</script>
