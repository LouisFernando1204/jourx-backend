<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Article;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Mengenal Pentingnya Kesehatan Mental',
                'slug' => Str::slug('Mengenal Pentingnya Kesehatan Mental'),
                'content' => 'Kesehatan mental adalah aspek penting dalam kehidupan kita yang seringkali terabaikan. Ini mencakup bagaimana kita berpikir, merasa, dan berperilaku dalam kehidupan sehari-hari. Ketika kesehatan mental terganggu, hal ini dapat memengaruhi hubungan, pekerjaan, dan kualitas hidup secara keseluruhan. Artikel ini mengupas tanda-tanda kesehatan mental yang buruk, cara menjaga keseimbangan emosi, serta pentingnya mencari bantuan profesional saat dibutuhkan.',
                'image' => 'mental_health_importance.jpg',
                'image_url' => 'https://example.com/images/mental_health_importance.jpg',
                'is_published' => true,
                'views_count' => 0,
            ],
            [
                'title' => 'Manfaat Meditasi untuk Mengurangi Stres',
                'slug' => Str::slug('Manfaat Meditasi untuk Mengurangi Stres'),
                'content' => 'Meditasi telah terbukti secara ilmiah dapat membantu mengurangi stres, meningkatkan konsentrasi, dan memperbaiki suasana hati. Dalam artikel ini, Anda akan belajar tentang berbagai teknik meditasi, seperti meditasi mindfulness dan meditasi pernapasan. Kami juga membahas bagaimana memulai meditasi bagi pemula dan mengintegrasikan kebiasaan ini ke dalam rutinitas harian Anda untuk menjaga kesehatan mental.',
                'image' => 'meditation_benefits.jpg',
                'image_url' => 'https://example.com/images/meditation_benefits.jpg',
                'is_published' => true,
                'views_count' => 0,
            ],
            [
                'title' => 'Mengelola Emosi dalam Kehidupan Sehari-hari',
                'slug' => Str::slug('Mengelola Emosi dalam Kehidupan Sehari-hari'),
                'content' => 'Emosi adalah bagian alami dari kehidupan manusia. Namun, kemampuan untuk mengelola emosi dengan bijak adalah keterampilan yang perlu diasah. Artikel ini membahas cara mengenali dan memahami emosi, seperti kemarahan, kesedihan, atau kegembiraan. Kami juga memberikan strategi untuk mengendalikan emosi agar tidak berdampak negatif pada hubungan atau produktivitas Anda.',
                'image' => 'managing_emotions.jpg',
                'image_url' => 'https://example.com/images/managing_emotions.jpg',
                'is_published' => true,
                'views_count' => 0,
            ],
            [
                'title' => 'Dampak Media Sosial pada Kesehatan Mental',
                'slug' => Str::slug('Dampak Media Sosial pada Kesehatan Mental'),
                'content' => 'Media sosial telah menjadi bagian tak terpisahkan dari kehidupan kita, tetapi dampaknya pada kesehatan mental sering kali tidak disadari. Artikel ini mengulas bagaimana penggunaan media sosial dapat memicu kecemasan, FOMO (Fear of Missing Out), dan rasa tidak percaya diri. Kami juga memberikan tips untuk menggunakan media sosial secara sehat, seperti menetapkan batasan waktu dan mengikuti akun yang memberikan energi positif.',
                'image' => 'social_media_impact.jpg',
                'image_url' => 'https://example.com/images/social_media_impact.jpg',
                'is_published' => true,
                'views_count' => 0,
            ],
            [
                'title' => 'Peran Olahraga dalam Menjaga Kesehatan Mental',
                'slug' => Str::slug('Peran Olahraga dalam Menjaga Kesehatan Mental'),
                'content' => 'Olahraga bukan hanya baik untuk kesehatan fisik, tetapi juga memiliki dampak besar pada kesehatan mental. Aktivitas fisik seperti berlari, yoga, atau bahkan berjalan kaki dapat membantu mengurangi stres, meningkatkan suasana hati, dan melawan gejala depresi. Artikel ini membahas jenis olahraga yang paling efektif untuk kesehatan mental dan bagaimana memulai rutinitas olahraga sederhana.',
                'image' => 'exercise_mental_health.jpg',
                'image_url' => 'https://example.com/images/exercise_mental_health.jpg',
                'is_published' => true,
                'views_count' => 0,
            ],
            [
                'title' => 'Cara Menemukan Dukungan di Saat Sulit',
                'slug' => Str::slug('Cara Menemukan Dukungan di Saat Sulit'),
                'content' => 'Dalam hidup, kita semua akan menghadapi masa-masa sulit. Memiliki sistem dukungan yang kuat dapat membuat perbedaan besar. Artikel ini membahas pentingnya berbicara dengan orang yang dapat dipercaya, bergabung dengan kelompok pendukung, atau mencari bimbingan dari konselor profesional. Kami juga memberikan tips untuk membangun jaringan dukungan emosional yang solid.',
                'image' => 'finding_support.jpg',
                'image_url' => 'https://example.com/images/finding_support.jpg',
                'is_published' => true,
                'views_count' => 0,
            ],
            [
                'title' => 'Pentingnya Tidur untuk Kesehatan Mental',
                'slug' => Str::slug('Pentingnya Tidur untuk Kesehatan Mental'),
                'content' => 'Tidur adalah kebutuhan dasar manusia yang sering diabaikan. Kurang tidur dapat memengaruhi suasana hati, konsentrasi, dan bahkan memicu gangguan kecemasan atau depresi. Artikel ini menjelaskan hubungan antara tidur yang cukup dan kesehatan mental. Anda juga akan menemukan tips untuk meningkatkan kualitas tidur, seperti menciptakan rutinitas tidur yang konsisten dan menghindari penggunaan gadget sebelum tidur.',
                'image' => 'importance_of_sleep.jpg',
                'image_url' => 'https://example.com/images/importance_of_sleep.jpg',
                'is_published' => true,
                'views_count' => 0,
            ],
            [
                'title' => 'Cara Menghadapi Burnout',
                'slug' => Str::slug('Cara Menghadapi Burnout'),
                'content' => 'Burnout adalah kondisi kelelahan emosional, mental, dan fisik akibat stres berkepanjangan. Ini sering dialami oleh mereka yang memiliki tanggung jawab besar, seperti mahasiswa, pekerja, atau orang tua. Artikel ini memberikan panduan langkah demi langkah untuk mengenali tanda-tanda burnout, mengelolanya, dan mencegahnya terjadi di masa depan.',
                'image' => 'dealing_with_burnout.jpg',
                'image_url' => 'https://example.com/images/dealing_with_burnout.jpg',
                'is_published' => true,
                'views_count' => 0,
            ],
            [
                'title' => 'Efek Positif Gratitude pada Kesehatan Mental',
                'slug' => Str::slug('Efek Positif Gratitude pada Kesehatan Mental'),
                'content' => 'Bersyukur adalah kebiasaan sederhana yang memiliki efek luar biasa pada kesehatan mental. Menulis hal-hal yang Anda syukuri setiap hari dapat meningkatkan kebahagiaan, mengurangi stres, dan memperbaiki kualitas hidup. Artikel ini mengupas cara mempraktikkan gratitude secara efektif dan manfaatnya bagi kesejahteraan Anda.',
                'image' => 'gratitude_mental_health.jpg',
                'image_url' => 'https://example.com/images/gratitude_mental_health.jpg',
                'is_published' => true,
                'views_count' => 0,
            ],
            [
                'title' => 'Meningkatkan Rasa Percaya Diri dengan Langkah Kecil',
                'slug' => Str::slug('Meningkatkan Rasa Percaya Diri dengan Langkah Kecil'),
                'content' => 'Percaya diri adalah kualitas yang penting untuk menjalani hidup dengan penuh keberanian dan kebahagiaan. Namun, membangun kepercayaan diri membutuhkan waktu dan usaha. Artikel ini memberikan langkah-langkah praktis untuk meningkatkan rasa percaya diri, seperti menetapkan tujuan kecil yang dapat dicapai, mengenali kekuatan diri, dan merayakan pencapaian Anda.',
                'image' => 'boosting_self_confidence.jpg',
                'image_url' => 'https://example.com/images/boosting_self_confidence.jpg',
                'is_published' => true,
                'views_count' => 0,
            ],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }
    }
}
