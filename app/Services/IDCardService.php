<?php

namespace App\Services;

use App\Models\IDCard;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class IDCardService
{
    /**
     * Generate sequential ID card number per library (e.g. IDC-000001)
     */
    public function generateCardNumber(int $libraryId): string
    {
        $lastCard = IDCard::where('library_id', $libraryId)
            ->orderByDesc('id')
            ->lockForUpdate()
            ->first();

        $nextNum = 1;
        if ($lastCard && preg_match('/IDC-(\d+)/i', $lastCard->card_number, $matches)) {
            $nextNum = intval($matches[1]) + 1;
        }

        $candidate = 'IDC-' . str_pad($nextNum, 6, '0', STR_PAD_LEFT);

        while (IDCard::where('library_id', $libraryId)->where('card_number', $candidate)->exists()) {
            $nextNum++;
            $candidate = 'IDC-' . str_pad($nextNum, 6, '0', STR_PAD_LEFT);
        }

        return $candidate;
    }

    /**
     * Generate secure high-entropy QR token
     */
    public function generateQrToken(): string
    {
        return Str::random(40);
    }

    /**
     * Issue an ID Card for a student
     */
    public function issueCard(Student $student, array $data = []): IDCard
    {
        return DB::transaction(function () use ($student, $data) {
            // Expire / revoke any existing active ID cards for this student
            IDCard::where('student_id', $student->id)
                ->where('status', 'active')
                ->update(['status' => 'expired']);

            $cardNumber = $this->generateCardNumber($student->library_id);
            $qrToken = $this->generateQrToken();

            $issueDate = $data['issue_date'] ?? now()->format('Y-m-d');
            $expiryDate = $data['expiry_date'] ?? now()->addYear()->format('Y-m-d');

            $branchId = $data['branch_id']
                ?? $student->memberships()->latest()->value('branch_id')
                ?? \App\Models\Branch::where('library_id', $student->library_id)->value('id');

            return IDCard::create([
                'library_id' => $student->library_id,
                'branch_id' => $branchId,
                'student_id' => $student->id,
                'card_number' => $cardNumber,
                'qr_token' => $qrToken,
                'issue_date' => $issueDate,
                'expiry_date' => $expiryDate,
                'status' => 'active',
                'notes' => $data['notes'] ?? 'Standard Identity Card Issued',
            ]);
        });
    }

    /**
     * Revoke an active ID card
     */
    public function revokeCard(IDCard $card, ?string $reason = null): bool
    {
        return $card->update([
            'status' => 'revoked',
            'notes' => $reason ? "Revoked: {$reason}" : $card->notes,
        ]);
    }

    /**
     * Generate SVG QR Code String for an ID Card
     */
    public function getQrSvg(IDCard $card, int $size = 140): string
    {
        try {
            return QrCode::size($size)
                ->margin(1)
                ->generate($card->qr_token);
        } catch (\Throwable $e) {
            // Return clean SVG fallback if QR code library is unavailable
            return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" viewBox="0 0 100 100"><rect width="100" height="100" fill="#f3f4f6"/><text x="50" y="50" font-size="8" text-anchor="middle" fill="#6b7280">QR TOKEN</text></svg>';
        }
    }
}
