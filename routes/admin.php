<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\TwoD\SlipController;
use App\Http\Controllers\Admin\BannerTextController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\Agent\AgentController;
use App\Http\Controllers\Admin\GetBetDetailController;
use App\Http\Controllers\Admin\TwoD\HistoryController;
use App\Http\Controllers\Admin\Master\MasterController;
use App\Http\Controllers\Admin\Player\PlayerController;
use App\Http\Controllers\Admin\ThreeD\WinnerController;
use App\Http\Controllers\Admin\GameTypeProductController;
use App\Http\Controllers\Admin\ThreeD\SettingsController;
use App\Http\Controllers\Admin\TwoD\TwoDManageController;
use App\Http\Controllers\Admin\TwoD\TwoDSettingController;
use App\Http\Controllers\Admin\ThreeD\ALlHistoryController;
use App\Http\Controllers\Admin\TwoD\EveningLegarController;
use App\Http\Controllers\Admin\TwoD\MorningLegarController;
use App\Http\Controllers\Admin\TwoD\TwoDDashboardController;
use App\Http\Controllers\Admin\ThreeD\ThreeDManageController;
use App\Http\Controllers\Admin\TwoD\ManageTwoDUserController;
use App\Http\Controllers\Admin\ThreeD\OneWeekRecordController;
use App\Http\Controllers\Admin\Deposit\DepositRequestController;
use App\Http\Controllers\Admin\ThreeD\ThreedMatchTimeController;
use App\Http\Controllers\Admin\TwoD\TwoDMorningWinnerController;
use App\Http\Controllers\Admin\TransferLog\TransferLogController;
use App\Http\Controllers\Admin\WithDraw\WithDrawRequestController;
use App\Http\Controllers\Admin\TwoD\AllLotteryWinPrizeSentController;

Route::group([
    'prefix' => 'admin', 'as' => 'admin.',
    'middleware' => ['auth', 'checkBanned'],
], function () {

    Route::post('balance-up', [HomeController::class, 'balanceUp'])->name('balanceUp');
    Route::get('logs/{id}', [HomeController::class, 'logs'])
        ->name('logs');
    // Permissions
    Route::resource('permissions', PermissionController::class);
    // Roles
    Route::delete('roles/destroy', [RolesController::class, 'massDestroy'])->name('roles.massDestroy');
    Route::resource('roles', RolesController::class);
    //Bank
    Route::resource('bank', BankController::class);
    // Players
    Route::delete('user/destroy', [PlayerController::class, 'massDestroy'])->name('user.massDestroy');

    Route::put('player/{id}/ban', [PlayerController::class, 'banUser'])->name('player.ban');
    Route::resource('player', PlayerController::class);
    Route::get('player-cash-in/{player}', [PlayerController::class, 'getCashIn'])->name('player.getCashIn');
    Route::post('player-cash-in/{player}', [PlayerController::class, 'makeCashIn'])->name('player.makeCashIn');
    Route::get('player/cash-out/{player}', [PlayerController::class, 'getCashOut'])->name('player.getCashOut');
    Route::post('player/cash-out/update/{player}', [PlayerController::class, 'makeCashOut'])
        ->name('player.makeCashOut');
    Route::get('player-changepassword/{id}', [PlayerController::class, 'getChangePassword'])->name('player.getChangePassword');
    Route::post('player-changepassword/{id}', [PlayerController::class, 'makeChangePassword'])->name('player.makeChangePassword');

    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('profile/change-password/{user}', [ProfileController::class, 'updatePassword'])
        ->name('profile.updatePassword');

    // user profile route get method
    Route::put('/change-password', [ProfileController::class, 'newPassword'])->name('changePassword');
    // PhoneAddressChange route with auth id route with put method
    Route::put('/change-phone-address', [ProfileController::class, 'PhoneAddressChange'])->name('changePhoneAddress');
    Route::put('/change-kpay-no', [ProfileController::class, 'KpayNoChange'])->name('changeKpayNo');
    Route::put('/change-join-date', [ProfileController::class, 'JoinDate'])->name('addJoinDate');
    Route::resource('banners', BannerController::class);
    Route::resource('text', BannerTextController::class);
    Route::resource('/promotions', PromotionController::class);
    Route::resource('/payments', PaymentController::class);
    Route::get('gametypes', [GameTypeProductController::class, 'index'])->name('gametypes.index');
    Route::get('gametypes/{game_type_id}/product/{product_id}', [GameTypeProductController::class, 'edit'])->name('gametypes.edit');
    Route::post('gametypes/{game_type_id}/product/{product_id}', [GameTypeProductController::class, 'update'])->name('gametypes.update');

    Route::resource('agent', AgentController::class);
    Route::get('agent-cash-in/{id}', [AgentController::class, 'getCashIn'])->name('agent.getCashIn');
    Route::post('agent-cash-in/{id}', [AgentController::class, 'makeCashIn'])->name('agent.makeCashIn');
    Route::get('agent/cash-out/{id}', [AgentController::class, 'getCashOut'])->name('agent.getCashOut');
    Route::post('agent/cash-out/update/{id}', [AgentController::class, 'makeCashOut'])
        ->name('agent.makeCashOut');
    Route::put('agent/{id}/ban', [AgentController::class, 'banAgent'])->name('agent.ban');
    Route::get('agent-changepassword/{id}', [AgentController::class, 'getChangePassword'])->name('agent.getChangePassword');
    Route::post('agent-changepassword/{id}', [AgentController::class, 'makeChangePassword'])->name('agent.makeChangePassword');

    Route::resource('master', MasterController::class);
    Route::get('master-cash-in/{id}', [MasterController::class, 'getCashIn'])->name('master.getCashIn');
    Route::post('master-cash-in/{id}', [MasterController::class, 'makeCashIn'])->name('master.makeCashIn');
    Route::get('master/cash-out/{id}', [MasterController::class, 'getCashOut'])->name('master.getCashOut');
    Route::post('master/cash-out/update/{id}', [MasterController::class, 'makeCashOut'])
        ->name('master.makeCashOut');
    Route::put('master/{id}/ban', [MasterController::class, 'banMaster'])->name('master.ban');
    Route::get('master-changepassword/{id}', [MasterController::class, 'getChangePassword'])->name('master.getChangePassword');
    Route::post('master-changepassword/{id}', [MasterController::class, 'makeChangePassword'])->name('master.makeChangePassword');

    Route::get('withdraw', [WithDrawRequestController::class, 'index'])->name('agent.withdraw');
    Route::get('withdraw/{id}', [WithDrawRequestController::class, 'show'])->name('agent.withdrawshow');

    Route::post('withdraw/{withdraw}', [WithDrawRequestController::class, 'statusChange'])->name('agent.statusChange');

    Route::get('deposit', [DepositRequestController::class, 'index'])->name('agent.deposit');
    Route::get('deposit/{id}', [DepositRequestController::class, 'show'])->name('agent.depositshow');

    Route::post('deposit/{deposit}', [DepositRequestController::class, 'updateStatus'])->name('agent.updateStatus');

    Route::get('transer-log', [TransferLogController::class, 'index'])->name('transferLog');
    Route::group(['prefix' => 'report'], function () {
        Route::get('index', [ReportController::class, 'index'])->name('report.index');
        Route::get('view/{user_id}', [ReportController::class, 'view'])->name('report.view');
        Route::get('show/{proudct_code}', [ReportController::class, 'show'])->name('report.show');
        Route::get('detail/{user_id}/{product_code}', [ReportController::class, 'detail'])->name('report.detail');
    });

    // get bet deatil
    Route::get('get-bet-detail', [GetBetDetailController::class, 'index'])->name('getBetDetail');
    Route::get('get-bet-detail/{wagerId}', [GetBetDetailController::class, 'getBetDetail'])->name('getBetDetail.show');

    // two - d route start
    Route::get('2-d-dashboard', [TwoDDashboardController::class, 'index'])->name('TwoD_dashboard');
    Route::get('two-d-settins', [TwoDSettingController::class, 'index']);
    Route::get('two-d-more-settings', [TwoDSettingController::class, 'getCurrentMonthSettings']);

    Route::patch('/two-2-status/{id}/status', [TwoDSettingController::class, 'updateStatus'])->name('twodStatusOpenClose');

    Route::patch('/two-2-status/{id}/evening', [TwoDSettingController::class, 'updateStatusEvening'])->name('twodStatusOpenCloseEvening');

    Route::patch('/two-d-results/{id}/status', [TwoDSettingController::class, 'updateResultNumber'])
        ->name('update_result_number');
    //close 2 digit (စိတ်ကြိုက်ပိတ်ဂဏန်း)
    Route::get('/close-2d-digit', [TwoDSettingController::class, 'closetwoDigitindex'])->name('two-digit-close');
    Route::post('/close-2-digit', [TwoDSettingController::class, 'store'])->name('CloseTwoDigitStore');
    Route::delete('/two-digit-close/{id}', [TwoDSettingController::class, 'destroy'])->name('two-digit-close.destroy');
    // close head 2digit (ထိပ်စီးဂဏန်းသုံးလုံးပိတ်ရန်)
    Route::get('/close-head-2d-digit', [TwoDSettingController::class, 'HeadDigitindex'])->name('two-digit-close-head');
    Route::post('/close-head-2-digit', [TwoDSettingController::class, 'HeadDigitstore'])->name('HeadClosestore');
    Route::delete('/two-digit-close-head/{id}', [TwoDSettingController::class, 'HeadDigitdestroy'])->name('digit-2-close-head.destroy');
    // morning history
    Route::get('2d-morning-history', [HistoryController::class, 'showMorningHistory']);
    Route::get('2d-evening-history', [HistoryController::class, 'showEveningHistory']);
    Route::get('2d-default-limit', [TwoDSettingController::class, 'Limitindex'])->name('default2dLimit');
    Route::post('2d-default-limit-store', [TwoDSettingController::class, 'Limitstore'])->name('DefaultLimitStore');
    Route::delete('2d-default-limits/{id}', [TwoDSettingController::class, 'Limitdestroy'])->name('defaultLimitDelete');
    Route::get('/2d-users-with-agents', [ManageTwoDUserController::class, 'index'])->name('2dusers.with_agents');

    Route::get('/2d-users-limit-cor', [ManageTwoDUserController::class, 'limitCorindex'])->name('2dusers.limit_cor');

    Route::post('/2d-users/update-limits', [ManageTwoDUserController::class, 'updateLimits'])->name('update_limits');

    Route::post('/2d-users/update-cor', [ManageTwoDUserController::class, 'updateCor'])->name('update_cor');
    Route::get('/2d-morning-legar', [MorningLegarController::class, 'showMorningLegar'])->name('morningLegar.show');
    // default break update
    Route::post('/2d-default-limit-update', [MorningLegarController::class, 'update'])->name('DefaultBreakupdate');

    Route::get('/2d-evening-legar', [EveningLegarController::class, 'showMorningLegar'])->name('eveningLegar.show');
    // default break update
    Route::post('/2d-evening-limit-update', [EveningLegarController::class, 'Eveningupdate'])->name('eveningDefaultBreakupdate');
    // admin morning winner history
    Route::get('/2-d-morning-winner', [TwoDMorningWinnerController::class, 'MorningWinHistoryForAdmin'])->name('morningWinner');
    Route::get('/2-d-evening-winner', [TwoDMorningWinnerController::class, 'EveningWinHistoryForAdmin'])->name('eveningWinner');
    Route::get('/2-d-all-winner', [AllLotteryWinPrizeSentController::class, 'TwoAllWinHistoryForAdmin']);
    Route::post('/2-d-session-reset', [TwoDManageController::class, 'SessionReset'])->name('SessionReset');
    Route::get('/2d-morning-slip', [SlipController::class, 'index'])->name('MorningSlipIndex');
    Route::get('/2d-morningslip/{userId}/{slipNo}', [SlipController::class, 'show'])->name('MorningSlipShow');

    Route::get('/2d-morning-all-slip', [SlipController::class, 'AllSlipForMorningindex'])->name('MorningAllSlipIndex');

    Route::get('/2d-morningallslip/{userId}/{slipNo}', [SlipController::class, 'MorningAllSlipshow'])->name('MorningAllSlipShow');

    Route::get('/2d-evening-slip', [SlipController::class, 'Eveningindex'])->name('EveningSlipIndex');
    Route::get('/2d-eveningslip/{userId}/{slipNo}', [SlipController::class, 'Eveningshow'])->name('EveningSlipShow');

    Route::get('/2d-evening-all-slip', [SlipController::class, 'AllSlipForEveningindex'])->name('EveningAllSlipIndex');
    Route::get('/2d-eveningallslip/{userId}/{slipNo}', [SlipController::class, 'EveningAllSlipshow'])->name('EveningAllSlipShow');
    // two - d route end

    // three 3 route start
    Route::post('/3-d-reset', [ThreeDManageController::class, 'ThreeDReset'])->name('ThreeDReset');

    Route::get('3d-settings', [SettingsController::class, 'index']);
    Route::get('3d-more-setting', [SettingsController::class, 'getCurrentMonthResultsSetting']);
    Route::get('/3d-users-with-agents', [ThreeDManageController::class, 'Userindex'])->name('2dusers.with_agents');

    Route::get('/3d-users-limit-cor', [ThreeDManageController::class, 'limitCorindex'])->name('3dusers.limit_cor');

    Route::post('/3d-users/update-limits', [ThreeDManageController::class, 'updateLimits'])->name('ThreeDupdate_limits');

    Route::post('/3d-users/update-cor', [ThreeDManageController::class, 'updateCor'])->name('ThreeDupdate_cor');

    // result date update
    Route::patch('/3d-results/{id}/status', [SettingsController::class, 'updateStatus'])
        ->name('ThreedOpenClose');
    Route::patch('/three-d-results/{id}/status', [SettingsController::class, 'updateResultNumber'])
        ->name('UpdateResult_number');

    Route::post('/store-permutations', [SettingsController::class, 'PermutationStore'])->name('storePermutations');
    //deletePermutation
    Route::delete('/delete-permutation/{id}', [SettingsController::class, 'deletePermutation'])->name('deletePermutation');
    Route::post('/permutation-reset', [SettingsController::class, 'PermutationReset'])->name('PermutationReset');

    Route::post('/3d-prizes-store', [SettingsController::class, 'store'])->name('PrizeStore');
    //deletePermutation
    Route::delete('/delete-prize/{id}', [SettingsController::class, 'destroy'])->name('DeletePrize');

    Route::get('3d-close-digit', [ThreeDManageController::class, 'index'])->name('ThreedCloseIndex');
    Route::post('3d-close-digit-store', [ThreeDManageController::class, 'store'])->name('CloseDigitStore');
    Route::delete('/delete-close-digit/{id}', [ThreeDManageController::class, 'destroy'])->name('DeleteCloseDigit');

    Route::get('3d-default-limits', [ThreeDManageController::class, 'ThreedDefaultLimitindex'])->name('ThreeddefaultLimitIndex');
    Route::post('3d-default-limit-store', [ThreeDManageController::class, 'ThreedLimitstore'])->name('ThreedDefaultlimitStore');
    Route::delete('/3d-delete-defalut-limit/{id}', [ThreeDManageController::class, 'ThreedLimitdestroy'])->name('ThreedDefaultLimitDelete');
    Route::get('/3d-one-week-records', [OneWeekRecordController::class, 'showRecordsForOneWeek'])->name('oneWeekRec');

    Route::get('/3d-all-history', [ALlHistoryController::class, 'showRecords'])->name('AllHistory');

    Route::get('/3d-one-week-slip', [OneWeekRecordController::class, 'index'])->name('OneWeekSlipIndex');
    Route::get('/3d-oneweek-slip-no/{userId}/{slipNo}', [OneWeekRecordController::class, 'show'])->name('OneWeekSlipDetail');

    Route::get('/3d-year-match-times', [ThreedMatchTimeController::class, 'getCurrentYearAndMatchTimes']);

    Route::get('/3d-slip-history', [ALlHistoryController::class, 'index'])->name('SlipHistoryIndex');
    Route::get('/3d-slip-no-history/{userId}/{slipNo}', [ALlHistoryController::class, 'show'])->name('SlipHistoryShow');
    Route::get('/3d-first-winner', [WinnerController::class, 'ThreeDFirstWinner'])->name('WinnerFirst');
    Route::get('/3d-second-winner', [WinnerController::class, 'ThreeDSecondWinner'])->name('WinnerSecond');
    Route::get('/3d-third-winner', [WinnerController::class, 'ThreeDThirdWinner'])->name('WinnerThird');
    // three 3 route end
});
