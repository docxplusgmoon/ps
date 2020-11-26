<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Reports\UserTransactions;
use Illuminate\Http\Request;

/**
 * Class UserController
 * @package App\Http\Controllers\Web
 */
class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application
     */
    public function showUserTransactions(Request $request)
    {
        $report = [];
        $user   = User::where('name', $request->get('name'))->first();
        $page   = $request->get('page', 1);

        if (!empty($user)) {
            $report = (new UserTransactions())->getTotalReport(
                $user,
                $page,
                $request->get('start_date'),
                $request->get('end_date')
            );
        }

        return view('user.transactions', compact('user', 'report', 'request', 'page'));
    }

    /**
     * @param Request $request
     */
    public function downloadUserTransactions(Request $request)
    {
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=file.csv");
        header("Pragma: no-cache");
        header("Expires: 0");

        $user = User::where('name', $request->get('name'))->first();


        if (!empty($user)) {
            $reporter = new UserTransactions();
            $page     = 0;

            while (true) {
                $page++;
                $transactions = $reporter->getTransactionsForPage(
                    $user,
                    $page,
                    $request->get('start_date'),
                    $request->get('end_date')
                );

                if (count($transactions) == 0) {
                    break;
                }

                echo view('user.transactions_csv', compact('transactions', 'page'))->render();
            }
        }

        return;
    }
}
