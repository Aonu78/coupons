<?php

namespace App\Services\User;

use App\Models\User;
use App\Models\Shop;
use App\Models\UserBank;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Constants\UserFiles;
use App\Enum\Users\UserType;
use Illuminate\Support\Facades\Hash;
use App\Enum\Finance\WalletCurrency;
use App\DataTransfer\User\CreateUserDTO;
use App\DataTransfer\User\UpdateProfileDTO;
use App\Services\Filesystem\FilesystemService;
use App\DataTransfer\User\BankAccount\SaveBankDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Http\Resources\User\Billing\PaymentMethodTransformer;
use Illuminate\Contracts\Container\BindingResolutionException;

final class UserService
{
    public function __construct(
        private readonly FilesystemService $filesystemService,
        private readonly User $userModel
    ) {}

    public function getUsersWithoutBots(): LengthAwarePaginator
    {
        $query = $this->userModel->newQuery();

        return $query->where('user_type', '!=', UserType::BOT->value)->paginate();
    }

    /**
     * @throws \Exception
     */
    public function create(CreateUserDTO $createUserDTO): User
    {
        $newUser = $this->userModel->newInstance();

        $newUser->name = $createUserDTO->name;
        $newUser->email = $createUserDTO->email;
        $newUser->password = Hash::make($createUserDTO->password);
        $newUser->user_type = $createUserDTO->userType;
        $newUser->phone_number = $createUserDTO->phoneNumber;
        $newUser->invite_code = rand(100000, 999999);

        if (is_string($createUserDTO->inviteCode)) {
            $inviter = $this->findByInviteCode($createUserDTO->inviteCode);

            if (isset($inviter)) {
                $newUser->invitedBy()->associate($inviter);
            }
        }

        $newUser->save();

        $newUser->createWallet(WalletCurrency::USD);
        $newUser->createWallet(WalletCurrency::CP_TOKEN);

        $defaultAvatar = $this->getDefaultAvatar();

        return $this->saveAvatar($defaultAvatar, $newUser);
    }

    /**
     * @throws \Exception
     */
    public function update(User $user, UpdateProfileDTO $updateDTO): User
    {
        $user->name = $updateDTO->name;
        $user->phone_number = $updateDTO->phoneNumber;

        if ($user->email !== $updateDTO->email) {
            $user->email = $updateDTO->email;
            $user->email_verified_at = null;
        }

        $user->save();

        if ($updateDTO->hasAvatar()) {
            $this->saveAvatar($updateDTO->convertAvatarToFile(), $user);
        }

        return $user;
    }

    public function updateAvatar(User $user, string $fileContent): User
    {
        return $this->saveAvatar($fileContent, $user);
    }

    public function verifyPassword(User $user, string $password): bool
    {
        return Hash::check($password, $user->password);
    }

    public function updatePassword(User $user, string $newPassword): User
    {
        $user->password = Hash::make($newPassword);
        $user->save();

        return $user;
    }

    public function createToken(User $user, string $tokenName = 'DEFAULT_TOKEN'): string
    {
        return $user->createToken($tokenName)->plainTextToken;
    }

    public function findByLogin(string $login): ?User
    {
        $query = $this->userModel->newQuery();

        return $query->where("email", $login)->orWhere("phone_number", $login)->first();
    }

    public function findById(int $id): ?User
    {
        $query = $this->userModel->newQuery();

        return $query->where("id", $id)->first();
    }

    public function findByInviteCode(string $code): ?User
    {
        $query = $this->userModel->newQuery();

        return $query->where("invite_code", $code)->first();
    }

    public function getUserBank(User $user): ?UserBank
    {
        return $user->bank;
    }

    public function createUserBank(User $user, SaveBankDTO $bankDTO): UserBank
    {
        /** @var UserBank $bank */
        $bank = $user->bank()->newModelInstance();

        $bank->bank_uuid = Str::uuid();
        $bank->user_id = $user->id;
        $bank->account_name = $bankDTO->accountName;
        $bank->account_name_furigana = $bankDTO->accountNameFurigana;
        $bank->account_number = $bankDTO->accountNumber;
        $bank->bank_name = $bankDTO->bankName;
        $bank->branch_number = $bankDTO->branchNumber;
        $bank->deposit_type = $bankDTO->depositType;

        $bank->save();

        return $bank;
    }

    public function updateBank(UserBank $bank, SaveBankDTO $bankDTO): UserBank
    {
        $bank->account_name = $bankDTO->accountName;
        $bank->account_name_furigana = $bankDTO->accountNameFurigana;
        $bank->account_number = $bankDTO->accountNumber;
        $bank->bank_name = $bankDTO->bankName;
        $bank->branch_number = $bankDTO->branchNumber;
        $bank->deposit_type = $bankDTO->depositType;

        $bank->save();

        return $bank;
    }

    public function getInvitedUsers(User $user): LengthAwarePaginator
    {
        return $user->invitedUsers()->paginate();
    }

    public function destroy(User $user): bool
    {
        $user->shop()->delete();
        $user->coupons()->delete();
        $user->bank()->delete();
        $user->company()->delete();
        $user->delete();

        return true;
    }

    /**
     * @param string $avatar
     * @param User $objUser
     * @return User
     */
    private function saveAvatar(string $avatar, User $objUser): User {
        $avatarVersion = time();

        $strPath = sprintf(UserFiles::USER_AVATAR_FULL_NAME, $objUser->id, $avatarVersion);

        $this->filesystemService->save($strPath, $avatar);

        $objUser->avatar_version = $avatarVersion;
        $objUser->save();

        return $objUser;
    }

    /**
     * @throws \Exception
     */
    private function getDefaultAvatar(): string {
        $arrFiles = $this->filesystemService->files(UserFiles::DEFAULT_AVATARS_DIR);

        if (empty($arrFiles)) {
            throw new \Exception("Invalid Avatars.");
        }

        $strPath = Arr::random($arrFiles);

        return $this->filesystemService->readFile($strPath);
    }
}
