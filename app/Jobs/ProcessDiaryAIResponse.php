<?php

namespace App\Jobs;

use App\Models\Diary;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class ProcessDiaryAIResponse implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $diary;

    public function __construct(Diary $diary)
    {
        $this->diary = $diary;
    }

    public function handle()
{
   try {
       $diary = $this->diary->fresh(['user']);
       
       $prompt = "Kamu adalah seorang psikolog muda yang fun, hangat dan memahami anak muda. Kamu sedang ngobrol santai dengan seseorang yang lagi curhat.";

       if ($diary->user) {
           $age = \Carbon\Carbon::parse($diary->user->birth_date)->age;
           $gender = $diary->user->gender == 'male' ? 'laki-laki' : 'perempuan';
           $prompt .= "\n\nInfo tentang yang curhat:
- Nama: {$diary->user->name}
- Umur: {$age} tahun
- Jenis kelamin: {$gender}";
       }

       $prompt .= "\n\nRespon mencakup:
       1. Gimana perasaan yang lagi mereka rasain (tunjukkan bahwa kamu paham dan care)
       2. Apa aja yang mungkin terjadi kedepannya dari perasaan itu (positif atau negatif)
       3. Saran dan dukungan yang bisa membantu mereka ngelewatin ini semua
       
       Curhatannya: {$this->diary->content}
       
       BERIKAN RESPON DALAM FORMAT JSON:
       {
           \"emotion\": \"[pilih satu: sukacita/sedih/marah/takut/cinta/jijik/kagum/bingung]\",
           \"suggestions_ai\": \"[cakupan respon 3 hal tadi]\",
           \"quote\": \"[quote inspiratif yang relevan]\",
           \"stress_level\": [level stress 0-100]
       }
       
Berikan respon dalam Bahasa Indonesia yang friendly dan santai tapi tetap profesional dan sopan (jangan gunakan gue/lo). Gunakan bahasa sehari-hari yang biasa dipakai anak muda (tapi tetap sopan), seolah-olah lagi ngobrol langsung sama teman dekat.";

       $response = OpenAI::chat()->create([
           'model' => 'gpt-4',
           'messages' => [
               ['role' => 'system', 'content' => 'Kamu harus memberikan response dalam format JSON yang valid sesuai struktur yang diminta.'],
               ['role' => 'user', 'content' => $prompt]
           ]
       ]);

       $responseContent = $response->choices[0]->message->content;
       $aiResponse = json_decode($responseContent, true);

       if (json_last_error() !== JSON_ERROR_NONE) {
           Log::error('Failed to parse AI response as JSON: ' . $responseContent);
           throw new \Exception('Invalid JSON response from AI');
       }

       if (!isset($aiResponse['emotion']) || !isset($aiResponse['suggestions_ai']) || 
           !isset($aiResponse['quote']) || !isset($aiResponse['stress_level'])) {
           throw new \Exception('Incomplete JSON response from AI');
       }

       $this->diary->update([
           'emotion' => $aiResponse['emotion'],
           'suggestions_ai' => $aiResponse['suggestions_ai'],
           'quote' => $aiResponse['quote'],
           'stress_level' => $aiResponse['stress_level'],
           'is_processed' => true
       ]);

   } catch (\Exception $e) {
       Log::error('ProcessDiaryAIResponse error: ' . $e->getMessage());
       $this->diary->update([
           'is_processed' => true,
           'emotion' => 'bingung',
           'suggestions_ai' => 'Maaf, terjadi kesalahan saat memproses curhatanmu. Tapi tetap semangat ya!',
           'quote' => 'Every setback is a setup for a comeback.',
           'stress_level' => 50
       ]);
   }
}
}
