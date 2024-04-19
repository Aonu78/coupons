<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Stripe\PaymentMethod;
use App\Support\Http\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enum\Finance\WalletCurrency;
use App\Http\Resources\UserTransformer;
use App\Services\Settings\SettingService;
use App\Constants\TransactionDescriptions;
use App\Services\Finance\TransactionService;
use App\Http\Resources\FakeCardsTransformer;
use App\Enum\Finance\Transaction\TransactionType;
use App\Http\Requests\Api\User\Billing\ChargeRequest;
use App\Enum\Finance\Transaction\TransactionOperation;
use App\Http\Resources\User\Billing\PaymentMethodTransformer;
use App\Http\Requests\Api\User\Billing\PaymentMethodRequest;

final class StripeController extends Controller
{
    public function __construct(
        private readonly TransactionService $transactionService,
        private readonly SettingService $settingsService
    ) {}

    public function getIntent(ApiResponse $response): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        return $response->success([
            "intent" => $user->createSetupIntent()->client_secret
        ]);
    }

    public function getKey(ApiResponse $response)
    {
        return $response->success(["key" => config('cashier.key')]);
    }

    public function savePaymentMethod(PaymentMethodRequest $request, ApiResponse $response): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $user->createOrGetStripeCustomer();

        try {
            /** @var PaymentMethod $paymentMethod */
            $paymentMethod = $user->addPaymentMethod($request->string("payment_method"));
        } catch (\Exception $exception) {
            return $response->error($exception->getMessage());
        }

        if ($user->hasDefaultPaymentMethod() === false) {
            $user->updateDefaultPaymentMethod($paymentMethod->id);
        }

        return $response->success(
            PaymentMethodTransformer::collection($user->paymentMethods()),
            trans('billing.new_card')
        );
    }

    /**
     * @throws \Exception
     */
    public function updateDefaultPaymentMethod(PaymentMethodRequest $request, ApiResponse $response)
    {
        /** @var User $user */
        $user = Auth::user();
        $user->createOrGetStripeCustomer();

        /** @var PaymentMethod $paymentMethod */
        $paymentMethod = $user->findPaymentMethod($request->str("payment_method"));

        if (is_null($paymentMethod)) {
            throw new \Exception(trans('billing.invalid_card'));
        }

        try {
            $user->updateDefaultPaymentMethod($paymentMethod->id);
        } catch (\Exception $exception) {
            return $response->error($exception->getMessage());
        }

        return $response->success(
            new PaymentMethodTransformer($paymentMethod),
            trans('billing.updated_default_card')
        );
    }

    public function getPaymentMethods(ApiResponse $response): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $user->createOrGetStripeCustomer();

        return $response->success(
            PaymentMethodTransformer::collection($user->paymentMethods())
        );
    }

    public function deletePaymentMethod(Request $request, ApiResponse $response): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $user->createOrGetStripeCustomer();

        if ($request->has("payment_method")) {
            $user->deletePaymentMethod($request->string("payment_method"));
        } else {
            $user->deletePaymentMethods();
        }

        return $response->success(
            PaymentMethodTransformer::collection($user->paymentMethods()),
            trans('billing.removed_card')
        );
    }

    public function charge(ChargeRequest $request, ApiResponse $response): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $user->createOrGetStripeCustomer();
        $dto = $request->getDTO();

        if ($request->has("payment_method")) {
            $paymentMethodID = $request->str("payment_method");

            if ($user->findPaymentMethod($paymentMethodID) === null) {
                return $response->error(trans('billing.invalid_card'));
            }
        } else {
            if ($user->hasDefaultPaymentMethod() === false) {
                return $response->error(trans('billing.cards_empty'));
            }

            $paymentMethodID = $user->defaultPaymentMethod()->id;
        }

        try {
            $objCharge = $user->charge(
                $dto->amount->getAmountFloat() * 100,
                $paymentMethodID
            );
        } catch (\Exception $exception) {
            return $response->error($exception->getMessage());
        }

        if ($objCharge->isSucceeded() === false) {
            return $response->error(trans('messages.default_error'));
        }

        $this->transactionService->execute(
            $dto->amount,
            $user,
            $user->getWallet(WalletCurrency::USD),
            TransactionOperation::DEBIT,
            TransactionType::DEPOSIT,
            sprintf(TransactionDescriptions::DEPOSIT, $dto->amount->getAmountString())
        );

        return $response->success(new UserTransformer($user));
    }

    public function getFakeCard(ApiResponse $response)
    {
        /** @var User $user */
        $user = Auth::user();

        $cards = $user->fakeCards;

        return $response->success(FakeCardsTransformer::collection($cards));
    }

    public function saveFakeCard(Request $request, ApiResponse $response)
    {
        /** @var User $user */
        $user = Auth::user();

        $card = $user->fakeCards()->create([
            "card_number" => encrypt($request->str("card_number")),
            "card_cvc" => encrypt($request->str("card_cvc")),
            "card_exp_month" => $request->input("card_exp_month"),
            "card_exp_year" => $request->input("card_exp_year"),
        ]);

        return $response->success(new FakeCardsTransformer($card));
    }
}
