import './bootstrap';

// Alkitab Page Script
document.addEventListener('DOMContentLoaded', function () {
    const alkitabContainer = document.querySelector('.alkitab-container');
    if (!alkitabContainer) return;

    const versionSelect = document.getElementById('version-select');
    const bookSelect = document.getElementById('book-select');
    const chapterSelect = document.getElementById('chapter-select');
    const verseSelect = document.getElementById('verse-select');
    const contentArea = document.getElementById('content-area');
    const searchInput = document.getElementById('search-input');
    const searchButton = document.getElementById('search-button');
    const searchResultsArea = document.getElementById('search-results');
    const loading = document.getElementById('loading-indicator');

    bookSelect.addEventListener('change', populateChapters);
    chapterSelect.addEventListener('change', fetchChapterContent);
    verseSelect.addEventListener('change', scrollToVerse);
    searchButton.addEventListener('click', executeSearch);
    searchInput.addEventListener('keyup', e => e.key === 'Enter' && executeSearch());
    versionSelect.addEventListener('change', () => { clearAll(true); });

    function populateChapters() {
        const selectedOption = bookSelect.options[bookSelect.selectedIndex];
        const chapters = parseInt(selectedOption.getAttribute('data-chapters'), 10);
        clearAll(false);
        if (!chapters) return;

        for (let i = 1; i <= chapters; i++) chapterSelect.add(new Option(i, i));
        chapterSelect.disabled = false;
    }

    function fetchChapterContent() {
        const chapter = chapterSelect.value;
        clearAll(false);
        if (!chapter) return;

        const version = versionSelect.value;
        const book = bookSelect.value;
        loading.style.display = 'block';
        fetch(`/api/alkitab/${version}/${book}/${chapter}`)
            .then(res => res.json())
            .then(verses => {
                loading.style.display = 'none';
                renderContent(book, chapter, verses);
                populateVerses(verses);
            });
    }

    function populateVerses(verses) {
        verseSelect.innerHTML = '<option value="">Pilih Ayat</option>';
        if (!verses || verses.length === 0) {
            verseSelect.disabled = true;
            return;
        }
        verses.forEach(v => verseSelect.add(new Option(v.verse, v.verse)));
        verseSelect.disabled = false;
    }

    function scrollToVerse() {
        const verseNum = verseSelect.value;
        if (!verseNum) return;
        const verseEl = document.getElementById(`verse-${verseNum}`);
        if (verseEl) {
            document.querySelectorAll('.verse').forEach(v => v.classList.remove('highlight'));
            verseEl.classList.add('highlight');
            verseEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    function executeSearch() {
        const version = versionSelect.value;
        const book = bookSelect.value;
        const chapter = chapterSelect.value;
        const query = searchInput.value;
        clearAll(false);
        if (!query) return;

        loading.style.display = 'block';
        let url = `/api/alkitab/search/${version}?q=${encodeURIComponent(query)}`;
        if (book) url += `&book=${book}`;
        if (chapter) url += `&chapter=${chapter}`;

        fetch(url)
            .then(res => res.json())
            .then(results => {
                loading.style.display = 'none';
                renderSearchResults(results);
            });
    }

    function renderContent(book, chapter, verses) {
        let html = `<h2>${bookSelect.options[bookSelect.selectedIndex].text} - Pasal ${chapter}</h2>`;
        if (verses.length === 0) {
            html += '<p>Data untuk pasal ini tidak tersedia dalam database sampel. Silakan coba Kejadian (Genesis) pasal 1 atau 2.</p>';
        } else {
            verses.forEach(v => {
                html += `<div class="verse" id="verse-${v.verse}"><span class="number">${v.verse} </span>${v.text}</div>`;
            });
        }
        contentArea.innerHTML = html;
    }

    function renderSearchResults(results) {
        let html = '<h2>Hasil Pencarian</h2>';
        if (results.length === 0) {
            html += '<p>Tidak ada hasil ditemukan.</p>';
        } else {
            results.forEach(r => {
                const bookName = document.querySelector(`#book-select option[value='${r.book}']`).textContent;
                html += `
                    <div class="search-result-item">
                        <small>${bookName} ${r.chapter}:${r.verse} (${r.version.toUpperCase()})</small>
                        <p>${r.text.replace(new RegExp(searchInput.value, "ig"), (match) => `<strong>${match}</strong>`)}</p>
                    </div>
                `;
            });
        }
        searchResultsArea.innerHTML = html;
    }

    function clearAll(clearBookAndVesion) {
        contentArea.innerHTML = '';
        searchResultsArea.innerHTML = '';
        verseSelect.innerHTML = '<option value="">Pilih Ayat</option>';
        verseSelect.disabled = true;
        if (clearBookAndVesion) {
            bookSelect.value = '';
            chapterSelect.innerHTML = '<option value="">Pilih Pasal</option>';
            chapterSelect.disabled = true;
        }
    }
});