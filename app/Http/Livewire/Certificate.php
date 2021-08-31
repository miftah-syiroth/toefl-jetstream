<?php

namespace App\Http\Livewire;

use App\Models\Conversion;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Certificate extends Component
{
    public $score;

    public function getAnsweredQuestions($section_id)
    {
        $answers =  Auth::user()->questions()->get();
        return $answers->where('section_id', $section_id);
    }

    public function getCorrectAnswers($questionAnswered)
    {
        $amount = 0;
        foreach ($questionAnswered as $answer) {
            if ($answer->pivot->score == 1) {
                $amount += 1;
            }
        }

        return $amount;
    }

    public function getSectionScores($questionCorrect, $section)
    {
        return Conversion::where('correct_amount', $questionCorrect)->value($section);
    }

    public function getFinalScore($section1_score, $section2_score, $section3_score)
    {
        return ($section1_score + $section2_score + $section3_score) * 10 / 3;
    }

    public function mount()
    {
        # cek jika sudah punya score maka tampilkan aja, jika belum input baru
        $score = Auth::user()->score;
        if ($score) { // kalau udah ada kolom score
            $this->score = $score;
        } else { // input
            $scores = [];
            // ambil total soal yang dijawab pada tiap section
            $scores['section1_answered'] = $this->getAnsweredQuestions(1)->count();
            $scores['section2_answered'] = $this->getAnsweredQuestions(2)->count();
            $scores['section3_answered'] = $this->getAnsweredQuestions(3)->count();
            
            // ambil jumlah jawaban yg benar pada soal yg dijawan di tiap section
            $scores['section1_correct'] = $this->getCorrectAnswers($this->getAnsweredQuestions(1));
            $scores['section2_correct'] = $this->getCorrectAnswers($this->getAnsweredQuestions(2));
            $scores['section3_correct'] = $this->getCorrectAnswers($this->getAnsweredQuestions(3));

            // ambil total nilai tiap section
            $scores['section1_score'] = $this->getSectionScores($scores['section1_correct'], 'section_1');
            $scores['section2_score'] = $this->getSectionScores($scores['section2_correct'], 'section_2');
            $scores['section3_score'] = $this->getSectionScores($scores['section3_correct'], 'section_3');

            $scores['final_score'] = $this->getFinalScore($scores['section1_score'], $scores['section2_score'], $scores['section3_score']);

            $this->score = Auth::user()->score()->create($scores);
        }
        
    }

    public function render()
    {
        return view('livewire.certificate');
    }
}
