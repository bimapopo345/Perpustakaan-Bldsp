<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book->judul }} - Baca Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-background {
            background: linear-gradient(120deg, #4F46E5, #7C3AED, #F472B6);
            background-size: 200% 200%;
            animation: gradient 15s ease infinite;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        #pdf-viewer {
            width: 100%;
            height: calc(100vh - 64px);
            border: none;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <div class="gradient-background">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-bold text-white truncate">{{ $book->judul }}</h1>
                <a href="{{ url()->previous() }}" 
                   class="px-4 py-2 rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors duration-300">
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- PDF Viewer -->
    <div id="pdf-container">
        <iframe id="pdf-viewer" 
                src="{{ route('books.view-pdf', $book->id) }}#toolbar=0&navpanes=0&scrollbar=0" 
                frameborder="0" 
                webkitallowfullscreen=""
                mozallowfullscreen=""
                allowfullscreen="">
            <!-- Fallback untuk browser yang tidak support iframe -->
            <object data="{{ route('books.view-pdf', $book->id) }}#toolbar=0&navpanes=0&scrollbar=0"
                    type="application/pdf"
                    width="100%"
                    height="100%">
                <embed src="{{ route('books.view-pdf', $book->id) }}#toolbar=0&navpanes=0&scrollbar=0"
                       type="application/pdf"
                       width="100%"
                       height="100%">
                    <p>Browser Anda tidak mendukung tampilan PDF secara langsung. 
                       <a href="{{ route('books.view-pdf', $book->id) }}" target="_blank">Klik di sini</a> 
                       untuk membuka PDF di tab baru.</p>
                </embed>
            </object>
        </iframe>
    </div>

    <!-- Anti-Copy Script -->
    <script>
        // Disable context menu
        document.addEventListener('contextmenu', event => event.preventDefault());

        // Disable keyboard shortcuts
        document.addEventListener('keydown', function(event) {
            if (event.ctrlKey && 
                (event.key === 'p' || 
                 event.key === 's' || 
                 event.key === 'u' ||
                 event.key === 'c' ||
                 event.key === 'v')) {
                event.preventDefault();
            }
        });

        // Disable text selection
        document.addEventListener('selectstart', event => event.preventDefault());

        // Disable drag and drop
        document.addEventListener('dragstart', event => event.preventDefault());
    </script>
</body>
</html>
