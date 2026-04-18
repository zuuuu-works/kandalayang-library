<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $authors = [
            [
                'first_name' => 'Jane',
                'last_name'  => 'Austen',
                'email'      => 'info@gutenberg.org',
                'bio'        => 'English novelist known for Pride and Prejudice and Sense and Sensibility, celebrated for her wit and social commentary on 19th-century British society.',
            ],
            [
                'first_name' => 'Mark',
                'last_name'  => 'Twain',
                'email'      => 'contact@gutenberg.org',
                'bio'        => 'American author and humorist, best known for The Adventures of Tom Sawyer and Adventures of Huckleberry Finn.',
            ],
            [
                'first_name' => 'Charles',
                'last_name'  => 'Darwin',
                'email'      => 'collections@gutenberg.org',
                'bio'        => 'English naturalist renowned for his theory of evolution by natural selection, published in On the Origin of Species (1859).',
            ],
            [
                'first_name' => 'Albert',
                'last_name'  => 'Einstein',
                'email'      => 'info@arxiv.org',
                'bio'        => 'Theoretical physicist who developed the theory of relativity and made foundational contributions to quantum mechanics and modern physics.',
            ],
            [
                'first_name' => 'Ada',
                'last_name'  => 'Lovelace',
                'email'      => 'info@archive.org',
                'bio'        => 'English mathematician regarded as the first computer programmer for her work on Charles Babbage\'s Analytical Engine in the 1840s.',
            ],
            [
                'first_name' => 'Nikola',
                'last_name'  => 'Tesla',
                'email'      => 'collections@archive.org',
                'bio'        => 'Inventor and electrical engineer known for designing the modern alternating current (AC) electricity supply system.',
            ],
            [
                'first_name' => 'Edgar',
                'last_name'  => 'Allan Poe',
                'email'      => 'info@librivox.org',
                'bio'        => 'American writer of poetry and short stories, particularly famous for tales of mystery and the macabre such as The Tell-Tale Heart.',
            ],
            [
                'first_name' => 'Mary',
                'last_name'  => 'Shelley',
                'email'      => 'contact@librivox.org',
                'bio'        => 'English novelist best known for Frankenstein (1818), widely considered one of the earliest works of science fiction.',
            ],
            [
                'first_name' => 'William',
                'last_name'  => 'Shakespeare',
                'email'      => 'works@gutenberg.org',
                'bio'        => 'English playwright, poet, and actor widely regarded as the greatest writer in the English language and the world\'s pre-eminent dramatist.',
            ],
            [
                'first_name' => 'Isaac',
                'last_name'  => 'Newton',
                'email'      => 'science@archive.org',
                'bio'        => 'English mathematician and physicist who formulated the laws of motion and universal gravitation, and invented calculus.',
            ],
            [
                'first_name' => 'Sigmund',
                'last_name'  => 'Freud',
                'email'      => 'psychology@archive.org',
                'bio'        => 'Austrian neurologist and founder of psychoanalysis, known for his theories on the unconscious mind and dream interpretation.',
            ],
            [
                'first_name' => 'Sun',
                'last_name'  => 'Tzu',
                'email'      => 'classics@gutenberg.org',
                'bio'        => 'Ancient Chinese military strategist and philosopher, author of The Art of War — one of the most influential treatises on military strategy.',
            ],
            [
                'first_name' => 'Friedrich',
                'last_name'  => 'Nietzsche',
                'email'      => 'philosophy@gutenberg.org',
                'bio'        => 'German philosopher, cultural critic, and poet who challenged the foundations of Christianity and traditional morality.',
            ],
            [
                'first_name' => 'Linus',
                'last_name'  => 'Torvalds',
                'email'      => 'open@arxiv.org',
                'bio'        => 'Finnish-American software engineer who created the Linux kernel and the distributed version control system Git.',
            ],
            [
                'first_name' => 'Stephen',
                'last_name'  => 'Hawking',
                'email'      => 'physics@arxiv.org',
                'bio'        => 'English theoretical physicist and cosmologist, known for his work on black holes, Hawking radiation, and A Brief History of Time.',
            ],
        ];

        foreach ($authors as $author) {
            Author::firstOrCreate(
                ['first_name' => $author['first_name'], 'last_name' => $author['last_name']],
                $author
            );
        }
    }
}