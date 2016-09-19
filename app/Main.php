<?php

namespace App;

use Carbon\Carbon;

class Main
{
    public static function getBodyFilteredAttribute($object)
    {
        $filteredBody = $object->body;

        // Modified version of http://stackoverflow.com/a/5289151 and http://stackoverflow.com/a/12590772
        // string to url
        $urlPattern = "/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))(?![^<>]*>)/i";

        if ($processedBody = preg_replace($urlPattern, '<a href="$1">$1</a>', $filteredBody)) {
            $filteredBody = $processedBody;
        }

        //add _blank if not trip.ee
        if ($processedBody = preg_replace('/(<a href="(http|https):(?!\/\/(?:www\.)?trip\.ee)[^"]+")>/is', '\\1 target="_blank">', $filteredBody)) {
            $filteredBody = $processedBody;
        }

        $imagePattern = '/\[\[([0-9]+)\]\]/';

        if (preg_match_all($imagePattern, $filteredBody, $matches)) {
            foreach ($matches[1] as $match) {
                if ($image = Image::find($match)) {
                    $filteredBody = str_replace("[[$image->id]]", '<img src="'.$image->preset('large').'" style="width: 100%"/>', $filteredBody);
                }
            }
        }

        return str_replace(["\n", "\t", "\r"], '', nl2br($filteredBody));
    }

    public static function getExpireData($type, $withField = 1)
    {
        $names = ['daysFrom', 'daysTo'];
        $data = null;

        if (config("content_$type.index.expire.field")) {
            if ($withField == 1) {
                $data['field'] = config("content_$type.index.expire.field");
            }

            if (config("content_$type.index.expire.type") == 'date') {
                $format = 'Y-m-d';
            } else {
                $format = 'Y-m-d H:i:s';
            }

            foreach ($names as $name) {
                if (config("content_$type.index.expire.$name") && ! is_numeric(config("content_$type.index.expire.$name"))) {
                    $data[$name] = config("content_$type.index.expire.field");
                } elseif (config("content_$type.index.expire.$name")) {
                    $data[$name] = Carbon::now()->addDays(config("content_$type.index.expire.$name"))->format($format);
                } else {
                    $data[$name] = Carbon::now()->format($format);
                }
            }
        }

        return $data;
    }

    public static function sqlToArray($collection, $parent_id = 0)
    {
        $tree = [];

        foreach ($collection as $item) {
            if ($item['parent_id'] == $parent_id) {
                $children = self::sqlToArray($collection, $item['id']);
                if ($children) {
                    $item['children'] = $children;
                }
                $tree[] = $item;
            }
        }

        return collect($tree);
    }

    public static function collectionAsSelect($tree, $indent = '', $eloquentCollection = [], $parameters = ['name' => 'name'], $saved = '', $level = 1)
    {
        if (count($eloquentCollection) && count($tree) == 0) {
            return self::collectionAsSelect(
                self::sqlToarray($eloquentCollection),
                $indent
            );
        } else {
            $items = [];

            if (count($tree)) {
                foreach ($tree as $item) {
                    $items[$item->id] = $saved.$item->{$parameters['name']};

                    if (isset($item->children) && count($item->children)) {
                        $items = $items +
                            self::collectionAsSelect(
                                $item->children,
                                $indent,
                                [],
                                $parameters,
                                $items[$item->id].$indent,
                                round((int) $level + 1)
                            );
                    }
                }
            }

            return $items;
        }
    }

    public static function getContentCollections($types)
    {
        $content_query = null;
        $i = 0;
        $viewVariables = [];

        foreach ($types as $key => $type) {
            ++$i;

            $query = null;

            if (isset($type['id'])) {
                $query = Content::where('id', $type['id'])->whereStatus($type['status']);
            } else {
                $query = Content::whereIn('type', $type['type'])->whereStatus($type['status']);

                if (isset($type['whereBetween']) && ! empty($type['whereBetween'])) {
                    if (! isset($type['whereBetween']['only'])) {
                        $expireData = [
                            $type['whereBetween']['daysFrom'],
                            $type['whereBetween']['daysTo'],
                        ];

                        if (in_array($type['whereBetween']['field'], $expireData)) {
                            if (($datakey = array_search($type['whereBetween']['field'], $expireData)) !== false) {
                                unset($expireData[$datakey]);
                            }

                            $query = $query->whereRaw('`'.$type['whereBetween']['field'].'` >= ?', [
                                array_values($expireData)[0],
                            ]);
                        } else {
                            $query = $query->whereBetween($type['whereBetween']['field'], [
                                $type['whereBetween']['daysFrom'],
                                $type['whereBetween']['daysTo'],
                            ]);
                        }
                    } else {
                        $query = $query->whereRaw('IF(`type` = ?, ?, ?) BETWEEN ? AND ?', [
                            $type['whereBetween']['only'],
                            $type['whereBetween']['field'],
                            $type['whereBetween']['daysTo'],
                            $type['whereBetween']['daysFrom'],
                            $type['whereBetween']['daysTo'],
                        ]);
                    }
                }

                if (isset($type['notId']) && count($type['notId'])) {
                    $query = $query->whereNotIn('id', $type['notId']);
                }

                if (isset($type['with']) && $type['with'] !== null) {
                    $query = $query->with($type['with']);
                }

                if (isset($type['latest']) && $type['latest'] !== null) {
                    $query = $query->latest($type['latest']);
                }

                if (isset($type['skip']) && $type['skip'] !== null) {
                    $query = $query->skip($type['skip']);
                }

                if (isset($type['take']) && $type['take'] !== null) {
                    $query = $query->take($type['take']);
                }
            }

            /*if ($i == 1) {
                $content_query = $query;
            } else {
                $content_query = $content_query->unionAll($query);
            }*/
            $$key = $query->with('images')->get();
            $viewVariables[$key] = $$key;
        }

        return $viewVariables;
    }

    public static function getParentDestinations(array $collectionString, $viewVariables, $isDestination = null)
    {
        foreach ($collectionString as $type) {
            if (isset($viewVariables[$type])) {
                foreach ($viewVariables[$type] as $key => $element) {
                    if ($isDestination) {
                        $viewVariables[$type][$key]['destination'] = $element;
                    } else {
                        $viewVariables[$type][$key]['destination'] = $element->destinations->first();
                    }

                    $viewVariables[$type][$key]['parent_destination'] = $element->getDestinationParent();
                }
            }
        }

        return $viewVariables;
    }

    public static function listRelationIds($collection, $relationName)
    {
        $relationCollection = collect();

        foreach ($collection as $item) {
            if (isset($item->$relationName) && count($item->$relationName)) {
                $relationCollection = $relationCollection->merge($item->$relationName->pluck('id'));
            }
        }

        return $relationCollection;
    }
}
