<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Support\Facades\DB;

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
        // Checking if user has access to contract with $identifier
        $user = auth('customer-api')->user();

        $contract = Contract::query()->findOrFail($identifier);

        if ($user->company_id !== $contract->company_id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        // AI
        $contract = Contract::with([
            'queries.criteriumGroups.criteria',
            'queries.criteriumGroups.criteriumType',
        ])->findOrFail($identifier);

        $query = $contract->queries->firstWhere('id', $queryID);

        $this->joinTables = [];

        $this->collectJoins($query);

        $sql = "SELECT * FROM station ";

        foreach (array_keys($this->joinTables) as $table) {
            $sql .= " " . $this->resolveJoin($table);
        }

        $sql .= " WHERE " . $this->buildQuery($query);

        $results = DB::select($sql);

        return response()->json([
            "meta" => [
                "result_count" => count($results),
            ],
            'data' => $results,
        ]);
    }

    private function collectJoins($query): void
    {
        foreach ($query->criteriumGroups as $group) {
            $type = $group->criteriumType;

            if (!$type) continue;

            $table = $type->referenced_table;

            if ($table !== 'station') {
                $this->joinTables[$table] = true;
            }
        }
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

        // AUTO REGISTER JOIN (IMPORTANT PART)
        if ($table !== 'station') {
            $this->joinTables[$table] = true;
        }

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

    private function resolveJoin(string $table): string
    {
        return match ($table) {
            'geolocation' =>
            'LEFT JOIN geolocation ON geolocation.station_name = station.name',

            'station' => '',

            default =>
            throw new \Exception("No join defined for table: $table"),
        };
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
