<?php


namespace App\Reports;

use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Class UserTransactions
 * @package App\Reports
 */
class UserTransactions
{
    /**
     * Rows number for page
     */
    const PAGE_SIZE = 1;

    /**
     * @param User $user
     * @param int $page
     * @param string|null $startDate
     * @param string|null $endDate
     * @return array
     */
    public function getTotalReport(User $user, int $page, ?string $startDate, ?string $endDate)
    {
        $totals = $this->getBaseQuery($user->id, $startDate, $endDate)
            ->select(DB::raw('COUNT(transactions.id) as cnt, SUM(operations.amount) as total_amount'))
            ->first();

        $report = [
            'totalAmount'  => $totals->total_amount,
            'totalPages'   => ceil($totals->cnt / self::PAGE_SIZE),
            'transactions' => $this->getTransactionsForPage($user, $page, $startDate, $endDate),
        ];

        if (!empty($user->currency->actualRate())) {
            $report['totalInUSD'] = round($report['totalAmount'] / $user->currency->actualRate()->exchange_rate, 4);
        }

        return $report;
    }

    /**
     * Return user transactions for page
     *
     * @param User $user
     * @param int $page
     * @param string|null $startDate
     * @param string|null $endDate
     * @return \Illuminate\Support\Collection
     */
    public function getTransactionsForPage(User $user, int $page, ?string $startDate, ?string $endDate)
    {
        return $this->getBaseQuery($user->id, $startDate, $endDate)
            ->select(
                'transactions.id',
                'transactions.type',
                'transactions.comment',
                'transactions.created_at',
                'operations.amount'
            )
            ->limit(self::PAGE_SIZE)
            ->offset(($page - 1) * self::PAGE_SIZE)
            ->get();
    }

    /**
     * Return base SQL query for report
     *
     * @param int $userId
     * @param string|null $startDate
     * @param string|null $endDate
     * @return \Illuminate\Database\Query\Builder
     */
    protected function getBaseQuery(int $userId, ?string $startDate, ?string $endDate)
    {
        $query = DB::table('transactions')
            ->join('operations', 'operations.transaction_id', '=', 'transactions.id')
            ->where('operations.user_id', $userId);


        if (strtotime($startDate) !== false) {
            $query->where('transactions.created_at', '>=', $startDate);
        }

        if (strtotime($endDate) !== false) {
            $query->where('transactions.created_at', '<=', $endDate);
        }

        return $query;
    }
}
