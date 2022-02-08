<?php

namespace App\Traits;

trait RelationshipsManager
{
    public function filterRelations(
        $query,
        $table,
        $join,
        $local,
        $orderBy,
        $direction,
        $pagination,
        $foreign = 'id'
    ) {
        return $query
            ->select($table.'.*')
            ->join($join, $table . "." . $local, '=', $join . "." . $foreign)
            ->orderBy($join . '.' . $orderBy, $direction)
            ->paginate($pagination);
    }
    
    public function setFilters(
        $query,
        $search,
        $fields,
        $fieldsParam,
        $relationalFields,
        $relationalFieldsParam
    ) {
        if ($search['value']) {
            foreach ($fields as $key => $field) {
                if ($search['for'] === $field) {
                    $searchField = $fieldsParam[$key] === 'LIKE' ? '%' . $search['value'] . '%' : $search['value'];
                    return $query->where($field, $fieldsParam[$key], $searchField);
                }
            }
    
            foreach ($relationalFields as $key => $relationalField) {
                if ($search['for'] === $relationalField) {
                    $searchField = $relationalFieldsParam[$key][1] === 'LIKE' ? '%' . $search['value'] . '%' : $search['value'];
                    return $query->whereHas($relationalField, function ($relation) use ($key, $relationalFieldsParam, $searchField) {
                        $relation->where($relationalFieldsParam[$key][0], $relationalFieldsParam[$key][1], $searchField);
                    });
                }
            }
        }
        
        return $query;
    }
}
