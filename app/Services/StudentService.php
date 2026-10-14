<?php

namespace App\Services;

use App\Models\Student;
use App\Models\StudentGuardian;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StudentService
{
    /**
     * Generate sequential student number for a library (e.g. LIB-000001)
     */
    public function generateStudentNumber(int $libraryId): string
    {
        return DB::transaction(function () use ($libraryId) {
            $lastStudent = Student::withTrashed()
                ->where('library_id', $libraryId)
                ->orderBy('id', 'desc')
                ->lockForUpdate()
                ->first();

            $nextNumber = 1;

            if ($lastStudent && preg_match('/LIB-(\d+)/i', $lastStudent->student_number, $matches)) {
                $nextNumber = intval($matches[1]) + 1;
            }

            return sprintf('LIB-%06d', $nextNumber);
        });
    }

    /**
     * Create a new student record along with optional guardian details and photo upload
     */
    public function createStudent(array $data, ?UploadedFile $photoFile = null): Student
    {
        return DB::transaction(function () use ($data, $photoFile) {
            if ($photoFile) {
                $data['photo'] = $photoFile->store('students/photos', 'public');
            }

            if (empty($data['student_number'])) {
                $data['student_number'] = $this->generateStudentNumber($data['library_id']);
            }

            $studentData = array_diff_key($data, array_flip(['guardian_name', 'guardian_relationship', 'guardian_mobile', 'guardian_alternate_mobile', 'guardian_email', 'guardian_address']));

            $student = Student::create($studentData);

            if (!empty($data['guardian_name']) && !empty($data['guardian_mobile'])) {
                StudentGuardian::create([
                    'student_id' => $student->id,
                    'name' => $data['guardian_name'],
                    'relationship' => $data['guardian_relationship'] ?? 'Guardian',
                    'mobile' => $data['guardian_mobile'],
                    'alternate_mobile' => $data['guardian_alternate_mobile'] ?? null,
                    'email' => $data['guardian_email'] ?? null,
                    'address' => $data['guardian_address'] ?? null,
                ]);
            }

            return $student;
        });
    }

    /**
     * Update student record & guardian details
     */
    public function updateStudent(Student $student, array $data, ?UploadedFile $photoFile = null): Student
    {
        return DB::transaction(function () use ($student, $data, $photoFile) {
            if ($photoFile) {
                if ($student->photo && Storage::disk('public')->exists($student->photo)) {
                    Storage::disk('public')->delete($student->photo);
                }
                $data['photo'] = $photoFile->store('students/photos', 'public');
            }

            $studentData = array_diff_key($data, array_flip(['guardian_name', 'guardian_relationship', 'guardian_mobile', 'guardian_alternate_mobile', 'guardian_email', 'guardian_address']));

            $student->update($studentData);

            if (!empty($data['guardian_name']) && !empty($data['guardian_mobile'])) {
                $student->guardian()->updateOrCreate(
                    ['student_id' => $student->id],
                    [
                        'name' => $data['guardian_name'],
                        'relationship' => $data['guardian_relationship'] ?? 'Guardian',
                        'mobile' => $data['guardian_mobile'],
                        'alternate_mobile' => $data['guardian_alternate_mobile'] ?? null,
                        'email' => $data['guardian_email'] ?? null,
                        'address' => $data['guardian_address'] ?? null,
                    ]
                );
            }

            return $student;
        });
    }
}
