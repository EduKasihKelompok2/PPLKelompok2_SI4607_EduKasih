<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ECourseController extends Controller
{
    public function index(Request $request)
    {
       
        $category = $request->kategori;
        $query = $request->query('query');


        $courses = $this->getDummyCourses();

     
        if ($category) {
            $courses = $courses->filter(function ($course) use ($category) {
                return strtolower($course['category']) === $category;
            });
        }

     
        if ($query) {
            $courses = $courses->filter(function ($course) use ($query) {
                return stripos($course['title'], $query) !== false ||
                    stripos($course['description'], $query) !== false ||
                    stripos($course['category'], $query) !== false;
            });
        }

      
        $perPage = 6;
        $page = $request->input('page', 1);
        $total = $courses->count();

       
        if ($page > ceil($total / $perPage) && $total > 0) {
            $page = 1;
        }

        $paginatedCourses = new LengthAwarePaginator(
            $courses->forPage($page, $perPage),
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('user.e-course', [
            'courses' => $paginatedCourses
        ]);
    }

    public function show($id)
    {
        return view('user.e-course-detail');
    }

    private function getDummyCourses()
    {
        return collect([
            [
                'id' => 1,
                'title' => 'Mengenal Konsep Matematika Dasar',
                'category' => 'Matematika',
                'subject' => 'Mata Pelajaran Matematika',
                'description' => 'Pelajari dasar-dasar matematika dengan pendekatan yang mudah dipahami untuk siswa SMA.',
                'image' => 'https://source.unsplash.com/random/600x400/?mathematics',
                'rating' => 4.7,
                'reviews' => 112
            ],
            [
                'id' => 2,
                'title' => 'Mengenal Konsep Ilmu Sosial',
                'category' => 'Sosiologi',
                'subject' => 'Mata Pelajaran Sosiologi',
                'description' => 'Memahami konsep dasar dan teori sosiologi yang diaplikasikan dalam kehidupan sehari-hari.',
                'image' => 'https://source.unsplash.com/random/600x400/?sociology',
                'rating' => 4.5,
                'reviews' => 251
            ],
            [
                'id' => 3,
                'title' => 'Mengenal Konsep Dasar Seni',
                'category' => 'Seni Budaya',
                'subject' => 'Mata Pelajaran Seni Budaya',
                'description' => 'Eksplorasi seni dan budaya Indonesia dengan pendekatan kreatif dan menyenangkan.',
                'image' => 'https://source.unsplash.com/random/600x400/?art',
                'rating' => 4.8,
                'reviews' => 236
            ],
            [
                'id' => 4,
                'title' => 'Fisika Modern untuk SMA',
                'category' => 'Fisika',
                'subject' => 'Mata Pelajaran Fisika',
                'description' => 'Memahami konsep fisika modern dengan pendekatan praktis dan eksperimen sederhana.',
                'image' => 'https://source.unsplash.com/random/600x400/?physics',
                'rating' => 4.6,
                'reviews' => 198
            ],
            [
                'id' => 5,
                'title' => 'Dasar-dasar Biologi Molekuler',
                'category' => 'Biologi',
                'subject' => 'Mata Pelajaran Biologi',
                'description' => 'Mempelajari prinsip dasar biologi molekuler dengan ilustrasi dan contoh kasus.',
                'image' => 'https://source.unsplash.com/random/600x400/?biology',
                'rating' => 4.7,
                'reviews' => 183
            ],
            [
                'id' => 6,
                'title' => 'English for Academic Purposes',
                'category' => 'Bahasa Inggris',
                'subject' => 'Mata Pelajaran Bahasa Inggris',
                'description' => 'Belajar bahasa Inggris untuk keperluan akademis dengan metode komunikatif.',
                'image' => 'https://source.unsplash.com/random/600x400/?english',
                'rating' => 4.5,
                'reviews' => 221
            ],
            [
                'id' => 7,
                'title' => 'Kimia Organik Dasar',
                'category' => 'Kimia',
                'subject' => 'Mata Pelajaran Kimia',
                'description' => 'Mempelajari struktur, sifat dan reaksi senyawa organik dengan pendekatan visual dan praktis.',
                'image' => 'https://source.unsplash.com/random/600x400/?chemistry',
                'rating' => 4.4,
                'reviews' => 167
            ],
            [
                'id' => 8,
                'title' => 'Sejarah Indonesia Modern',
                'category' => 'Sejarah',
                'subject' => 'Mata Pelajaran Sejarah',
                'description' => 'Memahami perjalanan bangsa Indonesia dari masa kolonial hingga reformasi.',
                'image' => 'https://source.unsplash.com/random/600x400/?history',
                'rating' => 4.6,
                'reviews' => 195
            ],
            [
                'id' => 9,
                'title' => 'Geografi Fisik dan Sosial',
                'category' => 'Geografi',
                'subject' => 'Mata Pelajaran Geografi',
                'description' => 'Mengkaji interaksi antara aspek fisik dan sosial dalam dinamika geografi Indonesia.',
                'image' => 'https://source.unsplash.com/random/600x400/?geography',
                'rating' => 4.3,
                'reviews' => 154
            ],
            [
                'id' => 10,
                'title' => 'Ekonomi Mikro dan Makro',
                'category' => 'Ekonomi',
                'subject' => 'Mata Pelajaran Ekonomi',
                'description' => 'Memahami sistem ekonomi pada skala individu hingga negara dengan contoh kasus terkini.',
                'image' => 'https://source.unsplash.com/random/600x400/?economics',
                'rating' => 4.5,
                'reviews' => 178
            ],
            [
                'id' => 11,
                'title' => 'Teknik Menulis Kreatif',
                'category' => 'Bahasa Indonesia',
                'subject' => 'Mata Pelajaran Bahasa Indonesia',
                'description' => 'Belajar menulis dengan berbagai gaya dan format untuk mengembangkan keterampilan literasi.',
                'image' => 'https://source.unsplash.com/random/600x400/?writing',
                'rating' => 4.8,
                'reviews' => 214
            ],
            [
                'id' => 12,
                'title' => 'Pendidikan Kewarganegaraan',
                'category' => 'PKN',
                'subject' => 'Mata Pelajaran PKN',
                'description' => 'Memahami hak dan kewajiban sebagai warga negara dalam konteks demokrasi Indonesia.',
                'image' => 'https://source.unsplash.com/random/600x400/?civics',
                'rating' => 4.2,
                'reviews' => 146
            ]
        ]);
    }
}