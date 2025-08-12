<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use App\Services\TransferService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Transfer;

class TransferController extends Controller
{
    public function transfer(Request $request, TransferService $service)
    {
        try {
            // ✅ تحقق من البيانات
            $request->validate([
                'user_identifier' => 'required|string|exists:users,user_identifier',
                'amount' => 'required|numeric|min:0.01'
            ]);

            $user_identifier = $request->user_identifier;
            $amount = $request->amount;
            $sender = auth()->user();
            if ($sender->user_identifier == $user_identifier) {
                return response()->json(['error' => 'You cannot transfer to yourself'], 400);
            }
            Log::info('Transfer initiated', [
                'from_user_id' => $sender->id,
                'to_user_identifier' => $user_identifier,
                'amount' => $amount
            ]);

            // ✅ تأكد من أن الرصيد كافي
            if ($sender->balance < $amount) {
                Log::warning('Insufficient balance', [
                    'user_id' => $sender->id,
                    'balance' => $sender->balance,
                    'attempted_amount' => $amount
                ]);
                return response()->json(['error' => 'Insufficient balance'], 400);
            }

            // ✅ تنفيذ العملية داخل transaction
            DB::beginTransaction();

            $recipient = User::where('user_identifier', $user_identifier)->first();

            $sender->balance -= $amount + $amount * 0.01;
            $sender->save();

            $recipient->balance += $amount;
            $recipient->save();

            DB::commit();
            Transfer::create([
                'sender_id' => $sender->id,
                'recipient_id' => $recipient->id,
                'amount' => $amount
            ]);
            Log::info('Transfer successful', [
                'from_user' => $sender->id,
                'to_user' => $recipient->id,
                'amount' => $amount
            ]);

            // ✅ إرسال الإشعار – لو لسه هتست فايربيز، بس سجل المحاولة
            try {
                $service->sendNotification(
                    $recipient->id,
                    "لقد تلقيت مدفوعات بقيمة {$amount} من {$sender->name}"
                );


                Notification::create([
                    'user_id' => $recipient->id,
                    'body' => "لقد تلقيت مدفوعات بقيمة {$amount} من {$sender->name}"

                ]);
                Notification::create([
                    'user_id' => $sender->id,
                    'body' => "لقد تم إرسال مدفوعات بقيمة {$amount} إلي {$recipient->name}"

                ]);
                Log::info('Notification sent', [
                    'to_user_id' => $recipient->id
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send notification', [
                    'to_user_id' => $recipient->id,
                    'error' => $e->getMessage()
                ]);
            }

            return response()->json(['message' => 'Transfer successful']);
        } catch (\Exception $e) {
            DB::rollBack(); // لو في خطأ وسط الترانزاكشن
            Log::error('Transfer failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            return response()->json(['error' => 'Transfer failed'], 500);
        }
    }
}
