<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Confirmation</title>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f8fb;
            margin: 0;
            padding: 0;
        }

        /* Container */
        .container {
            max-width: 600px;
            margin: 2rem auto;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Title */
        .title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #0284C7;
            text-align: center;
        }

        /* Greeting and Message Text */
        .greeting,
        .message {
            color: #374151;
            font-size: 1rem;
            margin: 1.5rem 0;
            line-height: 1.6;
        }

        /* Button */
        .button {
            display: inline-block;
            text-align: center;
            background-color: #0284C7;
            color: #ffffff !important;
            font-weight: bold;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            margin: 1.5rem auto;
            display: block;
            width: fit-content;
        }

        .button:hover {
            background-color: #0284C7;
        }

        /* Footer */
        .footer {
            text-align: center;
            color: #6b7280;
            font-size: 0.875rem;
            margin-top: 2rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="title">Selamat Datang di JourX!</h1>

        <p class="greeting">Halo, {{ $username }}</p>

        <p class="message">Terima kasih telah bergabung dengan <strong>JourX</strong>, ruang pribadi Anda untuk
            berbagi pikiran, merefleksikan hari Anda, dan mendapatkan wawasan yang bermakna. Kami senang menyambut Anda
            sebagai bagian dari komunitas kami di mana kesejahteraan mental dan ekspresi diri sangat dihargai.</p>

        <p class="message">Akun Anda telah berhasil dibuat, dan Anda sekarang siap menggunakan JourX. Baik itu
            menuangkan perasaan Anda dalam catatan jurnal atau mencari saran dari AI, kami di sini untuk mendukung
            perjalanan kesehatan mental Anda.</p>

        <p class="message">Klik tombol di bawah ini untuk kembali ke aplikasi dan mulai membuat catatan jurnal
            pertama Anda:</p>

        <a href="https://jourxredirect.dickyyyy.site/success?username={{ $username }}" class="button">Kembali ke
            JourX</a>

        <p class="message">Jika Anda memiliki pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi tim
            dukungan kami. Bersama-sama, kita akan membuat setiap momen menjadi berarti.</p>

        <div class="footer">
            <p>&copy; 2024 JourX. Cerita Anda, suara Anda, kedamaian Anda.</p>
        </div>
    </div>
</body>

</html>
