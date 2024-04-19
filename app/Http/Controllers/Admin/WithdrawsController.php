<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enum\Finance\WithdrawStatus;
use App\Services\Finance\WithdrawService;

final class WithdrawsController extends Controller
{
    public function __construct(
        private readonly WithdrawService $withdrawService
    ) {}

    public function index()
    {
        $withdraws = $this->withdrawService->getAll();

        return view('admin.withdraws.index', compact('withdraws'));
    }

    public function edit(string $id)
    {
        $withdraw = $this->withdrawService->find($id);

        if (is_null($withdraw)) {
            return back();
        }

        return view('admin.withdraws.edit', compact('withdraw'));
    }

    public function save(string $id, Request $request)
    {
        $withdraw = $this->withdrawService->find($id);

        if (is_null($withdraw)) {
            return back()->with('error', "Withdraw Not Found.");
        }

        $withdrawStatus = WithdrawStatus::tryFrom($request->input('withdraw_status'));

        if (is_null($withdrawStatus)) {
            return back()->with('error', "Invalid Status.");
        }

        $withdraw = $this->withdrawService->updateStatus($withdraw, $withdrawStatus);

        return redirect()->route('admin.withdraws.edit', $withdraw->withdraw_uuid)
            ->with('success', 'You have successfully processed withdraw request.');
    }
}
