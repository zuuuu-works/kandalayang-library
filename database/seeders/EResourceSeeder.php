<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EResource;
use App\Models\Author;
use App\Models\Publisher;

class EResourceSeeder extends Seeder
{
    // 🔹 Helper functions (clean + reusable)
    private function getAuthor($first, $last)
    {
        return Author::firstOrCreate([
            'first_name' => $first,
            'last_name'  => $last
        ]);
    }

    private function getPublisher($name)
    {
        return Publisher::firstOrCreate([
            'name' => $name
        ]);
    }

    public function run(): void
    {
        // ── Publishers ─────────────────────────────
        $gutenberg = $this->getPublisher('Project Gutenberg');
        $arxiv     = $this->getPublisher('arXiv');
        $librivox  = $this->getPublisher('LibriVox');
        $archive   = $this->getPublisher('Internet Archive');
        $openstax  = $this->getPublisher('OpenStax');

        // ── Authors ────────────────────────────────
        $austen      = $this->getAuthor('Jane', 'Austen');
        $twain       = $this->getAuthor('Mark', 'Twain');
        $darwin      = $this->getAuthor('Charles', 'Darwin');
        $einstein    = $this->getAuthor('Albert', 'Einstein');
        $lovelace    = $this->getAuthor('Ada', 'Lovelace');
        $tesla       = $this->getAuthor('Nikola', 'Tesla');
        $poe         = $this->getAuthor('Edgar', 'Allan Poe');
        $shelley     = $this->getAuthor('Mary', 'Shelley');
        $shakespeare = $this->getAuthor('William', 'Shakespeare');
        $newton      = $this->getAuthor('Isaac', 'Newton');
        $freud       = $this->getAuthor('Sigmund', 'Freud');
        $sunTzu      = $this->getAuthor('Sun', 'Tzu');
        $nietzsche   = $this->getAuthor('Friedrich', 'Nietzsche');
        $torvalds    = $this->getAuthor('Linus', 'Torvalds');
        $hawking     = $this->getAuthor('Stephen', 'Hawking');

        // ── Data ───────────────────────────────────
        $resources = [

            // 📚 E-BOOKS
            [
                'title' => 'Pride and Prejudice',
                'description' => 'A romantic novel of manners...',
                'publication_year' => 1813,
                'file_url' => 'https://www.gutenberg.org/ebooks/1342',
                'file_type' => 'EPUB',
                'category_id' => 1,
                'author_id' => $austen->id,
                'publisher_id' => $gutenberg->id,
            ],
            [
                'title' => 'Adventures of Huckleberry Finn',
                'description' => 'Mark Twain\'s classic...',
                'publication_year' => 1884,
                'file_url' => 'https://www.gutenberg.org/ebooks/76',
                'file_type' => 'EPUB',
                'category_id' => 1,
                'author_id' => $twain->id,
                'publisher_id' => $gutenberg->id,
            ],
            [
                'title' => 'On the Origin of Species',
                'description' => 'Darwin\'s evolution theory...',
                'publication_year' => 1859,
                'file_url' => 'https://www.gutenberg.org/ebooks/1228',
                'file_type' => 'EPUB',
                'category_id' => 1,
                'author_id' => $darwin->id,
                'publisher_id' => $gutenberg->id,
            ],

            // 📄 RESEARCH
            [
                'title' => 'Does the Inertia of a Body Depend Upon Its Energy Content?',
                'description' => 'Einstein paper...',
                'publication_year' => 1905,
                'file_url' => 'https://arxiv.org/abs/physics/0505009',
                'file_type' => 'PDF',
                'category_id' => 4,
                'author_id' => $einstein->id,
                'publisher_id' => $arxiv->id,
            ],
            [
                'title' => 'Black Holes and Entropy',
                'description' => 'Hawking radiation...',
                'publication_year' => 1975,
                'file_url' => 'https://arxiv.org/abs/hep-th/9409195',
                'file_type' => 'PDF',
                'category_id' => 4,
                'author_id' => $hawking->id,
                'publisher_id' => $arxiv->id,
            ],

            // 🔊 AUDIO
            [
                'title' => 'The Tell-Tale Heart (Audio)',
                'description' => 'Edgar Allan Poe audiobook...',
                'publication_year' => 1843,
                'file_url' => 'https://librivox.org/the-tell-tale-heart-by-edgar-allan-poe/',
                'file_type' => 'MP3',
                'category_id' => 6,
                'author_id' => $poe->id,
                'publisher_id' => $librivox->id,
            ],

            // 🎓 THESIS
            [
                'title' => 'My Inventions: The Autobiography of Nikola Tesla',
                'description' => 'Tesla memoir...',
                'publication_year' => 1919,
                'file_url' => 'https://archive.org/details/MyInventionsTheAutobiographyOfNikolaTesla',
                'file_type' => 'PDF',
                'category_id' => 3,
                'author_id' => $tesla->id,
                'publisher_id' => $archive->id,
            ],

            // 📘 JOURNAL
            [
                'title' => 'Introduction to Sociology 3e (OpenStax)',
                'description' => 'Open textbook...',
                'publication_year' => 2021,
                'file_url' => 'https://openstax.org/details/books/introduction-sociology-3e',
                'file_type' => 'PDF',
                'category_id' => 2,
                'author_id' => $darwin->id,
                'publisher_id' => $openstax->id,
            ],
        ];

        // ── Insert ────────────────────────────────
        foreach ($resources as $resource) {
            EResource::firstOrCreate(
                ['title' => $resource['title']],
                $resource
            );
        }

        $this->command->info('✅ E-Resources seeded successfully!');
    }
}