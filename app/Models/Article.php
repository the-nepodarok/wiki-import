<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
     * Разбить текст на слова
     * @return int количество слов
     */
    private function splitIntoWords(): int
    {
        // Разбивка по пробелам и знакам препинания
        $words = preg_split('/[\s=\/,.()]/', mb_strtolower($this->contents), 0, PREG_SPLIT_NO_EMPTY);
        $count = count($words);
        $words = array_unique($words);

        foreach ($words as $word) {
            if (preg_match('/^[A-zА-я0-9]+$/u', $word)) {
                $word = Word::firstOrCreate(['word' => $word]);

                // Получение кол-ва вхождений слова в статье
                $this->words()->attach($word, ['count' => substr_count(mb_strtolower($this->contents), $word->word)]);
            }
        }

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
