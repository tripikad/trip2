<?php

namespace App\Console\Commands;

use App\Destination;

class ConvertTerms extends ConvertBase
{
    protected $signature = 'convert:terms';

    public function getDestinationRoots()
    {
        return \DB::connection($this->connection)
            ->table('term_data')
            ->join('term_hierarchy', 'term_data.tid', '=', 'term_hierarchy.tid')
            ->where('term_data.vid', 6)
            ->where('term_hierarchy.parent', 0)
            ->select('term_data.tid')
            ->pluck('term_data.tid', null);
    }

    public function getDestinationChildrens($parents)
    {
        return \DB::connection($this->connection)
            ->table('term_data')
            ->join('term_hierarchy', 'term_data.tid', '=', 'term_hierarchy.tid')
            ->where('term_data.vid', 6)
            ->whereIn('term_hierarchy.parent', $parents)
            ->select('term_data.tid')
            ->pluck('term_data.tid', null);
    }

    public function createDestination($term)
    {
        if (! Destination::find($term->tid)) {
            $model = new Destination;

            $model->id = $term->tid;
            $model->name = $this->cleanAll($term->name);

            $model->save();

            if ($term->parent) {
                $parent = Destination::find($term->parent);
                $model->makeChildOf($parent);
            }

            $this->convertTermAlias($term->tid, 'destination');
        }
    }

    public function convertDestinations()
    {
        $terms = $this->getTerms(6)->get(); // Sihtkohad

        $this->info('Converting destinations');
        $this->output->progressStart(count($terms));

        $roots = $this->getDestinationRoots();

        foreach ($roots as $root) {
            $term = $this->getTermById($root);
            $this->createDestination($term);

            $this->output->progressAdvance();
        }

        $firstChildrens = $this->getDestinationChildrens($roots);

        foreach ($firstChildrens as $firstChildren) {
            $term = $this->getTermById($firstChildren);
            $this->createDestination($term);

            $this->output->progressAdvance();
        }

        $secondChildrens = $this->getDestinationChildrens($firstChildrens);

        foreach ($secondChildrens as $secondChildren) {
            $term = $this->getTermById($secondChildren);
            $this->createDestination($term);

            $this->output->progressAdvance();
        }

        $thirdChildrens = $this->getDestinationChildrens($secondChildrens);

        foreach ($thirdChildrens as $thirdChildren) {
            $term = $this->getTermById($thirdChildren);
            $this->createDestination($term);

            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
    }

    public function convertTopics()
    {
        $terms = $this->getTerms([5, 9, 25])->get(); // Reisistiilid, Rubriigid, Kategooria

        $this->info('Converting topics');
        $this->output->progressStart(count($terms));

        foreach ($terms as $term) {
            if ($term = $this->processTopic($term)) {
                $this->createTerm($term, '\App\Topic');
                $this->convertTermAlias($term->tid, 'topic');
            }

            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
    }

    public function addTopics()
    {
        $terms = $this->getNewTopics();

        $this->info('Adding new tags');
        $this->output->progressStart(count($terms));

        foreach ($terms as $term) {
            $this->createTerm((object) $term, '\App\Topic');

            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
    }

    public function convertCarriers()
    {
        $terms = $this->getTerms(23)->get(); // Lennufirma

        $this->info('Converting carriers');
        $this->output->progressStart(count($terms));

        foreach ($terms as $term) {
            $this->createTerm($term, '\App\Carrier');
            $this->convertTermAlias($term->tid, 'carrier');

            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
    }

    public function handle()
    {
        $this->convertDestinations();
        $this->convertTopics();
        $this->addTopics();
        $this->convertCarriers();

        $aliases = \DB::table('aliases')->get();
    }
}
