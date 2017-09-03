<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollField extends Model
{
    protected $table = 'poll_fields';

    protected $primaryKey = 'field_id';

    protected $fillable = ['type', 'options'];

    public $timestamps = false;

    public function poll()
    {
        return $this->belongsTo('App\Poll', 'poll_id', 'id');
    }

    public function poll_results()
    {
        return $this->hasMany('App\PollResult', 'field_id', 'field_id');
    }

    public function getParsedResults()
    {
        if ($this->type == 'text') {
            return $this->getParsedTextResults();
        }

        return $this->getParsedSelectResults();
    }

    protected function getParsedSelectResults()
    {
        $poll_field = $this->fresh(['poll_results']);
        $poll_results = $poll_field->relations['poll_results'];

        if ($poll_results->isEmpty()) {
            return [];
        }

        $options = json_decode($poll_field->options, true);
        $options = array_flip($options['options']);
        $results = array_fill_keys(array_keys($options), 0);
        $total_results = 0;

        foreach ($poll_results->getIterator() as $result) {
            $answer_opts = json_decode($result->result, true);
            foreach ($answer_opts as $single_opt) {
                if (isset($results[$single_opt])) {
                    $results[$single_opt]++;
                    $total_results++;
                }
            }
        }

        $total_percent = 0;
        $last_not_zero = null;

        foreach ($results as $key => $res) {
            $new_res = round((floatval($res) / floatval($total_results)) * 100);
            $results[$key] = $new_res;
            $total_percent += $new_res;

            if ($new_res != 0) {
                $last_not_zero = $key;
            }
        }

        //To avoid that rounded values to not add up to 100%
        if ($last_not_zero && $total_percent > 100) {
            $results[$last_not_zero] -= ($total_percent - 100);
        } else if ($last_not_zero && $total_percent < 100) {
            $results[$last_not_zero] += (100 - $total_percent);
        }

        $results = array_map(function ($k, $v) {
            return ['title' => $k, 'value' => $v];
        }, array_keys($results), $results);

        return $results;
    }

    protected function getParsedTextResults()
    {
        //
    }
}
