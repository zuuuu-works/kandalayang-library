<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EResource;
use App\Models\Author;
use App\Models\Publisher;

class EResourceSeeder extends Seeder
{
    public function run(): void
    {
        // ── Fetch Publishers ──────────────────────────────────
        $gutenberg = Publisher::where('name', 'Project Gutenberg')->first();
        $arxiv     = Publisher::where('name', 'arXiv')->first();
        $librivox  = Publisher::where('name', 'LibriVox')->first();
        $archive   = Publisher::where('name', 'Internet Archive')->first();
        $openstax  = Publisher::where('name', 'OpenStax')->first();
        $plos      = Publisher::where('name', 'Public Library of Science (PLOS)')->first();
        $mit       = Publisher::where('name', 'MIT OpenCourseWare')->first();

        // ── Fetch Authors ─────────────────────────────────────
        $austen      = Author::where('last_name', 'Austen')->first();
        $twain       = Author::where('last_name', 'Twain')->first();
        $darwin      = Author::where('last_name', 'Darwin')->first();
        $einstein    = Author::where('last_name', 'Einstein')->first();
        $lovelace    = Author::where('last_name', 'Lovelace')->first();
        $tesla       = Author::where('last_name', 'Tesla')->first();
        $poe         = Author::where('last_name', 'Allan Poe')->first();
        $shelley     = Author::where('last_name', 'Shelley')->first();
        $shakespeare = Author::where('last_name', 'Shakespeare')->first();
        $newton      = Author::where('last_name', 'Newton')->first();
        $freud       = Author::where('last_name', 'Freud')->first();
        $sunTzu      = Author::where('last_name', 'Tzu')->first();
        $nietzsche   = Author::where('last_name', 'Nietzsche')->first();
        $torvalds    = Author::where('last_name', 'Torvalds')->first();
        $hawking     = Author::where('last_name', 'Hawking')->first();

        $resources = [

            // ── E-BOOKS (Category ID: 1) ──────────────────────
            [
                'title'            => 'Pride and Prejudice',
                'description'      => 'A romantic novel of manners by Jane Austen that follows Elizabeth Bennet as she navigates issues of marriage, morality, and social class in early 19th-century England.',
                'isbn'             => null,
                'publication_year' => 1813,
                'file_url'         => 'https://www.gutenberg.org/ebooks/1342',
                'file_path'        => null,
                'file_type'        => 'EPUB',
                'category_id'      => 1,
                'author_id'        => $austen->id,
                'publisher_id'     => $gutenberg->id,
            ],
            [
                'title'            => 'Adventures of Huckleberry Finn',
                'description'      => 'Mark Twain\'s beloved novel following Huckleberry Finn\'s adventures along the Mississippi River with a runaway slave named Jim, exploring themes of race, freedom, and identity.',
                'isbn'             => null,
                'publication_year' => 1884,
                'file_url'         => 'https://www.gutenberg.org/ebooks/76',
                'file_path'        => null,
                'file_type'        => 'EPUB',
                'category_id'      => 1,
                'author_id'        => $twain->id,
                'publisher_id'     => $gutenberg->id,
            ],
            [
                'title'            => 'On the Origin of Species',
                'description'      => 'Charles Darwin\'s landmark scientific work introducing the theory of evolution through natural selection, transforming biology and our understanding of life on Earth.',
                'isbn'             => null,
                'publication_year' => 1859,
                'file_url'         => 'https://www.gutenberg.org/ebooks/1228',
                'file_path'        => null,
                'file_type'        => 'EPUB',
                'category_id'      => 1,
                'author_id'        => $darwin->id,
                'publisher_id'     => $gutenberg->id,
            ],
            [
                'title'            => 'The Complete Works of William Shakespeare',
                'description'      => 'A comprehensive collection of all 37 plays, 154 sonnets, and poems by William Shakespeare — the greatest playwright and poet in the English language.',
                'isbn'             => null,
                'publication_year' => 1623,
                'file_url'         => 'https://www.gutenberg.org/ebooks/100',
                'file_path'        => null,
                'file_type'        => 'EPUB',
                'category_id'      => 1,
                'author_id'        => $shakespeare->id,
                'publisher_id'     => $gutenberg->id,
            ],
            [
                'title'            => 'Frankenstein; or, The Modern Prometheus',
                'description'      => 'Mary Shelley\'s groundbreaking Gothic science fiction novel about Victor Frankenstein who creates a living creature, exploring themes of creation, responsibility, and humanity.',
                'isbn'             => null,
                'publication_year' => 1818,
                'file_url'         => 'https://www.gutenberg.org/ebooks/84',
                'file_path'        => null,
                'file_type'        => 'EPUB',
                'category_id'      => 1,
                'author_id'        => $shelley->id,
                'publisher_id'     => $gutenberg->id,
            ],
            [
                'title'            => 'The Art of War',
                'description'      => 'An ancient Chinese military treatise attributed to Sun Tzu, consisting of 13 chapters on warfare strategy. It remains highly influential in military science, business, and beyond.',
                'isbn'             => null,
                'publication_year' => 500,
                'file_url'         => 'https://www.gutenberg.org/ebooks/132',
                'file_path'        => null,
                'file_type'        => 'EPUB',
                'category_id'      => 1,
                'author_id'        => $sunTzu->id,
                'publisher_id'     => $gutenberg->id,
            ],
            [
                'title'            => 'Thus Spoke Zarathustra',
                'description'      => 'Friedrich Nietzsche\'s philosophical novel introducing his concept of the Übermensch, the will to power, and the eternal recurrence, written in a distinctive lyrical style.',
                'isbn'             => null,
                'publication_year' => 1883,
                'file_url'         => 'https://www.gutenberg.org/ebooks/1998',
                'file_path'        => null,
                'file_type'        => 'EPUB',
                'category_id'      => 1,
                'author_id'        => $nietzsche->id,
                'publisher_id'     => $gutenberg->id,
            ],

            // ── RESEARCH PAPERS (Category ID: 4) ─────────────
            [
                'title'            => 'Does the Inertia of a Body Depend Upon Its Energy Content?',
                'description'      => 'Einstein\'s landmark 1905 paper introducing the mass-energy equivalence formula E=mc², one of the most famous and consequential equations in the history of physics.',
                'isbn'             => null,
                'publication_year' => 1905,
                'file_url'         => 'https://arxiv.org/abs/physics/0505009',
                'file_path'        => null,
                'file_type'        => 'PDF',
                'category_id'      => 4,
                'author_id'        => $einstein->id,
                'publisher_id'     => $arxiv->id,
            ],
            [
                'title'            => 'An Introduction to the Linux Kernel',
                'description'      => 'An overview of the Linux kernel architecture, subsystems, and the open-source development model that powers servers, smartphones, and embedded systems worldwide.',
                'isbn'             => null,
                'publication_year' => 2003,
                'file_url'         => 'https://arxiv.org/abs/cs/0306090',
                'file_path'        => null,
                'file_type'        => 'PDF',
                'category_id'      => 4,
                'author_id'        => $torvalds->id,
                'publisher_id'     => $arxiv->id,
            ],
            [
                'title'            => 'Black Holes and Entropy',
                'description'      => 'Stephen Hawking\'s seminal paper discussing the thermodynamic properties of black holes, introducing the concept that black holes emit thermal radiation (Hawking radiation).',
                'isbn'             => null,
                'publication_year' => 1975,
                'file_url'         => 'https://arxiv.org/abs/hep-th/9409195',
                'file_path'        => null,
                'file_type'        => 'PDF',
                'category_id'      => 4,
                'author_id'        => $hawking->id,
                'publisher_id'     => $arxiv->id,
            ],
            [
                'title'            => 'Principia Mathematica — Laws of Motion',
                'description'      => 'Isaac Newton\'s foundational work presenting the three laws of motion and the law of universal gravitation, forming the foundation of classical mechanics.',
                'isbn'             => null,
                'publication_year' => 1687,
                'file_url'         => 'https://archive.org/details/newtonspmathema00newt',
                'file_path'        => null,
                'file_type'        => 'PDF',
                'category_id'      => 4,
                'author_id'        => $newton->id,
                'publisher_id'     => $archive->id,
            ],

            // ── AUDIO BOOKS (Category ID: 6) ──────────────────
            [
                'title'            => 'The Tell-Tale Heart (Audio)',
                'description'      => 'LibriVox free public domain audiobook of Edgar Allan Poe\'s chilling short story about a murderer haunted by the imagined sound of his victim\'s beating heart.',
                'isbn'             => null,
                'publication_year' => 1843,
                'file_url'         => 'https://librivox.org/the-tell-tale-heart-by-edgar-allan-poe/',
                'file_path'        => null,
                'file_type'        => 'MP3',
                'category_id'      => 6,
                'author_id'        => $poe->id,
                'publisher_id'     => $librivox->id,
            ],
            [
                'title'            => 'Frankenstein (Audio)',
                'description'      => 'Free LibriVox audiobook recording of Mary Shelley\'s classic Gothic novel Frankenstein, narrated by community volunteers in a dramatic reading.',
                'isbn'             => null,
                'publication_year' => 1818,
                'file_url'         => 'https://librivox.org/frankenstein-or-the-modern-prometheus-by-mary-wollstonecraft-godwin-shelley/',
                'file_path'        => null,
                'file_type'        => 'MP3',
                'category_id'      => 6,
                'author_id'        => $shelley->id,
                'publisher_id'     => $librivox->id,
            ],
            [
                'title'            => 'Pride and Prejudice (Audio)',
                'description'      => 'A free LibriVox audiobook of Jane Austen\'s beloved novel, read by Karen Savage in a clear and engaging narration.',
                'isbn'             => null,
                'publication_year' => 1813,
                'file_url'         => 'https://librivox.org/pride-and-prejudice-by-jane-austen/',
                'file_path'        => null,
                'file_type'        => 'MP3',
                'category_id'      => 6,
                'author_id'        => $austen->id,
                'publisher_id'     => $librivox->id,
            ],

            // ── THESES & DISSERTATIONS (Category ID: 3) ───────
            [
                'title'            => 'My Inventions: The Autobiography of Nikola Tesla',
                'description'      => 'Nikola Tesla\'s personal memoir describing his early life in Serbia, his immigration to America, and his most important inventions including the AC motor and the Tesla coil.',
                'isbn'             => null,
                'publication_year' => 1919,
                'file_url'         => 'https://archive.org/details/MyInventionsTheAutobiographyOfNikolaTesla',
                'file_path'        => null,
                'file_type'        => 'PDF',
                'category_id'      => 3,
                'author_id'        => $tesla->id,
                'publisher_id'     => $archive->id,
            ],
            [
                'title'            => 'Sketch of The Analytical Engine by Charles Babbage',
                'description'      => 'Ada Lovelace\'s extensive annotated translation of Luigi Menabrea\'s article on Babbage\'s Analytical Engine, containing the first published computer algorithm in history.',
                'isbn'             => null,
                'publication_year' => 1843,
                'file_url'         => 'https://archive.org/details/SketchOfTheAnalyticalEngineInventedByCharlesBabbage',
                'file_path'        => null,
                'file_type'        => 'PDF',
                'category_id'      => 3,
                'author_id'        => $lovelace->id,
                'publisher_id'     => $archive->id,
            ],
            [
                'title'            => 'The Interpretation of Dreams',
                'description'      => 'Sigmund Freud\'s groundbreaking work introducing his theory of the unconscious mind through dream analysis, establishing the foundation of psychoanalytic theory.',
                'isbn'             => null,
                'publication_year' => 1899,
                'file_url'         => 'https://archive.org/details/interpretationof00freu',
                'file_path'        => null,
                'file_type'        => 'PDF',
                'category_id'      => 3,
                'author_id'        => $freud->id,
                'publisher_id'     => $archive->id,
            ],

            // ── ACADEMIC JOURNALS (Category ID: 2) ────────────
            [
                'title'            => 'Introduction to Sociology 3e (OpenStax)',
                'description'      => 'A free, peer-reviewed, openly licensed sociology textbook covering culture, socialization, deviance, stratification, and social institutions — ideal for undergraduate courses.',
                'isbn'             => '978-1-947172-11-1',
                'publication_year' => 2021,
                'file_url'         => 'https://openstax.org/details/books/introduction-sociology-3e',
                'file_path'        => null,
                'file_type'        => 'PDF',
                'category_id'      => 2,
                'author_id'        => $darwin->id,
                'publisher_id'     => $openstax->id,
            ],
            [
                'title'            => 'University Physics Volume 1 (OpenStax)',
                'description'      => 'A comprehensive open-access university physics textbook covering mechanics, thermodynamics, and waves, designed for calculus-based introductory physics courses.',
                'isbn'             => '978-1-947172-20-3',
                'publication_year' => 2016,
                'file_url'         => 'https://openstax.org/details/books/university-physics-volume-1',
                'file_path'        => null,
                'file_type'        => 'PDF',
                'category_id'      => 2,
                'author_id'        => $einstein->id,
                'publisher_id'     => $openstax->id,
            ],
            [
                'title'            => 'Calculus Volume 1 (OpenStax)',
                'description'      => 'A free, open-source calculus textbook covering limits, derivatives, integrals, and the fundamental theorem of calculus for first-year university students.',
                'isbn'             => '978-1-947172-13-5',
                'publication_year' => 2016,
                'file_url'         => 'https://openstax.org/details/books/calculus-volume-1',
                'file_path'        => null,
                'file_type'        => 'PDF',
                'category_id'      => 2,
                'author_id'        => $newton->id,
                'publisher_id'     => $openstax->id,
            ],
        ];

        foreach ($resources as $resource) {
            EResource::firstOrCreate(
                ['title' => $resource['title']],
                $resource
            );
        }
    }
}