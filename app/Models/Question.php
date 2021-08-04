<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';
    protected $fillable = [
        'toefl_id',
        'sub_section_id',
        'section_id',
        'passage_id',
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'key_answer',
    ];

    // banyak soal, yakni pada section 3, mengacu pada satu passage
    public function passage()
    {
        return $this->belongsTo(Passage::class);
    }

    /**relasi many to one ke model sub_section */
    public function subSection()
    {
        return $this->belongsTo(SubSection::class);
    }

    /**relasi many to one ke model section */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    /**relasi many to one ke model toefl */
    public function toefl()
    {
        return $this->belongsTo(Toefl::class);
    }
}