<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Query;

// TODO: Fully ChatGPT generated code. Needs to be rewritten by the team but can't due to time constraints
class ContractController extends Controller
{
    private array $criterionOperators = [
        1 => 'AND',
        2 => 'OR',
    ];
    private array $groupOperators = [
        1 => 'AND',
        2 => 'OR',
    ];

    private array $comparisons = [
        1 => '=',
        2 => '!=',
        3 => '<',
        4 => '<=',
        5 => '>',
        6 => '>='
    ];

    public function stations($identifier, $queryID)
    {
        $query = Query::with([
            'criteriumGroups.criteria',
            'criteriumGroups.criteriumType'
        ])->findOrFail($queryID);
        return response()->json([
            '$query' => $this->buildQuery($query),
        ]);
    }

    public function buildQuery($query)
    {
        $tree = [];

        foreach ($query->criteriumGroups as $group) {
            $tree[] = [
                'group' => $group,
                'operator' => $group->operator,
                'criteria' => $group->criteria,
            ];
        }

        return $this->buildGroup($tree);
    }

    private function buildComparison($group, $criterion)
    {
        $type = $group->criteriumType;

        $field = $type->referenced_field;
        $table = $type->referenced_table;

        $operator = $this->comparisons[$criterion['value_comparison']] ?? '=';

        $value = match ($criterion['value_type']) {
            1 => $criterion['int_value'],
            2 => $criterion['string_value'],
            3 => $criterion['float_value'],
            default => null,
        };

        if (is_string($value)) {
            $value = "'" . addslashes($value) . "'";
        }

        return "$table.$field $operator $value";
    }

    private function buildGroup($groups)
    {
        $groupParts = [];

        foreach ($groups as $groupData) {

            $group = $groupData['group'];

            $groupOperator = $this->groupOperators[$group->operator] ?? 'AND';

            $criteriaParts = [];

            foreach ($group->criteria as $criterion) {

                $criteriaParts[] = $this->buildComparison($group, $criterion);
            }

            // IMPORTANT: determine how criteria inside group are combined
            // Based on your example: NO / SE => OR

            $criterionGlue = 'OR'; // <-- THIS is your fix

            $groupParts[] = "(" . implode(" $criterionGlue ", $criteriaParts) . ")";
        }

        return implode(" " . $this->groupOperators[$rootOperator ?? 1] . " ", $groupParts);
    }
}
