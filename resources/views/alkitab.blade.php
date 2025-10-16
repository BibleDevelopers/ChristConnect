<x-app class="alkitab-background">

    <div class="alkitab-container">
        
        <div class="controls-wrapper">
            <select id="version-select">
                <option value="tb">Indonesia (TB)</option>
                <option value="kjv">English (KJV)</option>
            </select>
            <select id="book-select">
                <option value="">Pilih Kitab</option>
                @foreach ($books as $book)
                    <option value="{{ $book['id'] }}" data-chapters="{{ $book['chapters'] }}">{{ $book['name'] }}</option>
                @endforeach
            </select>
            <select id="chapter-select" disabled><option value="">Pilih Pasal</option></select>
            <select id="verse-select" disabled><option value="">Pilih Ayat</option></select>
            <input type="search" id="search-input" placeholder="Cari ayat...">
            <button id="search-button">Cari</button>
        </div>

        <div id="loading-indicator">Loading...</div>

        <div id="search-results" class="search-results"></div>
        <div id="content-area" class="content-area"></div>

    </div>

</x-app>
