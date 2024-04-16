<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    protected $primaryKey = 'pageid';
    protected $fillable = [
        'pageid',
        'header',
        'contents',
        'url',
        'word_count',
    ];

    public $timestamps = false;

    /**
     * Разбить текст на слова-атомы с подсчётом вхождений каждого
     * @return int количество слов
     * @throws \Exception
     */
    private function splitIntoWords(): int
    {
        // Разбивка по пробелам и знакам препинания
        $words = preg_split('/[\s=\/,.()]/', mb_strtolower($this->contents), 0, PREG_SPLIT_NO_EMPTY);
        $count = count($words); // посчитать количество всех слов
        $words = array_unique($words); // избавиться от повторов слов
        $bulk = [];

        foreach ($words as $word) {
            if (preg_match('/^[A-zА-я0-9]+$/u', $word)) {
                $word_id = Word::firstOrCreate(['word' => $word])->id;

                $bulk[] = [
                    'word_id' => $word_id,
                    // точный подсчёт кол-ва вхождений слова (без окончаний падежей и склонений)
                    'count' => preg_match_all("/" . mb_strtolower($word) . "\b/u", mb_strtolower($this->contents)),
                ];
            }
        }

        // пакетная вставка через транзакцию
        DB::transaction(function() use ($bulk) {
            $this->words()->attach($bulk);
        });

        return $count;
    }

    public function countWords(): void
    {
        $this->word_count = $this->splitIntoWords();
        $this->save();
    }

    public function words(): BelongsToMany
    {
        return $this->belongsToMany(Word::class, 'article_word', 'article_id', 'word_id', 'pageid', 'id')
            ->withPivot('count');
    }

    /**
     * Поиск вхождений переданного слова в статье
     * @param string $word
     * @return Collection|null
     */
    public static function searchByWord(string $word): ?Collection
    {
        return Word::firstWhere(['word' => $word])?->articles;
    }
}
