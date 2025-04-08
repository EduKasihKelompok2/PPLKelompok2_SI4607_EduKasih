<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankSoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'class',
        'subject',
        'description',
        'question_count',
        'file_path',
        'upload_date',
    ];

    protected $casts = [
        'upload_date' => 'date',
    ];

    /**
     * Scope a query to filter bank soals based on search criteria.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, array $filters)
    {
        // Search by title or description
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        });

        // Filter by class
        $query->when($filters['class'] ?? false, function ($query, $class) {
            if ($class !== 'Semua Kelas') {
                $query->where('class', $class);
            }
        });

        // Filter by subject
        $query->when($filters['subject'] ?? false, function ($query, $subject) {
            if ($subject !== 'Semua Mata Pelajaran') {
                $query->where('subject', $subject);
            }
        });

        return $query;
    }

    /**
     * Get the badge color based on the subject.
     *
     * @return string
     */
    public function getBadgeColorAttribute()
    {
        return match ($this->subject) {
            'Fisika' => 'primary',
            'Kimia' => 'success',
            'Matematika' => 'info',
            'Biologi' => 'warning',
            'Bahasa Inggris' => 'danger',
            'Bahasa Indonesia' => 'secondary',
            'Sejarah' => 'dark',
            'Geografi' => 'light text-dark',
            'Ekonomi' => 'indigo',
            'Sosiologi' => 'purple',
            default => 'secondary',
        };
    }
}
