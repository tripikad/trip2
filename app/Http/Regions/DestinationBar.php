<?php

namespace App\Http\Regions;

use App\Destination;

class DestinationBar
{
    public function render($destination, $is = '')
    {
        //dd($destination->getAncestors()->onlyLast(2));
        $parent_destinations = app('db')->select('select
        `d1`.`id` as `d1_id`, `d1`.`parent_id` as `d1_parent_id`, `d1`.`name` as `d1_name`, `d1`.`slug` as `d1_slug`,
        `d2`.`id` as `d2_id`, `d2`.`parent_id` as `d2_parent_id`, `d2`.`name` as `d2_name`, `d2`.`slug` as `d2_slug` from `destinations` `d1` LEFT JOIN `destinations` `d2` ON `d2`.`id` = `d1`.`parent_id` where `d1`.`id` = '.(int) $destination->parent_id);

        if ($parent_destinations && count($parent_destinations)) {
            $parent_destinations = $parent_destinations[0];
        }

        $parentLength = mb_strlen($parent_destinations->d1_name.' '.($parent_destinations->d2_name ?? ''));
        $parentDestinations = collect([]);

        for ($i = 2; $i >= 1; --$i) {
            if ($i == 1 && $parentLength > 25) {
                break;
            } else {
                if ($parent_destinations->{'d'.$i.'_id'}) {
                    $new_destination = new Destination;
                    $new_destination->id = $parent_destinations->{'d'.$i.'_id'};
                    $new_destination->parent_id = $parent_destinations->{'d'.$i.'_parent_id'};
                    $new_destination->name = $parent_destinations->{'d'.$i.'_name'};
                    $new_destination->slug = $parent_destinations->{'d'.$i.'_slug'};

                    $parentDestinations = $parentDestinations->merge([$new_destination]);
                }
            }
        }

        //dd($parentDestinations);

        return component('DestinationBar')
            ->is($is)
            ->with('title', $destination->vars()->shortName)
            ->with('route', route('destination.show', [$destination]))
            ->with('parents', region(
                'DestinationParents',
                $parentDestinations,
                $short = true
            )
        );
    }
}
