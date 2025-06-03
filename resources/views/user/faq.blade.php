@extends('layouts.app')

@section('title', 'FAQ')

@section('content')
<div class="container py-4">
    <!-- FAQ Header Card -->
    <div class="faq-header mb-4">
        <div class="faq-image-container">
            <img src="{{asset('img/web/faq-vector.png')}}" alt="FAQ Illustration" class="img-fluid">
        </div>
        <h1 class="faq-title">Frequently Ask Question</h1>
        <p class="faq-subtitle">Temukan jawaban untuk semua pertanyaan yang ditanyakan</p>

        <!-- Search form (without Alpine.js) -->
        <div class="search-container mb-3">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search text-secondary"></i>
                </span>
                <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari pertanyaan..."
                    id="faqSearchInput" aria-label="Search questions">
            </div>
        </div>

        <button class="scroll-button" id="scrollButton">
            Gulir ke bawah <i class="bi bi-arrow-down"></i>
        </button>
    </div>

    <!-- No results message -->
    <div class="text-center my-4 d-none" id="noResultsMessage">
        <div class="empty-results">
            <i class="bi bi-search fs-1 text-secondary"></i>
            <p class="mt-3 fs-5">Tidak ada hasil yang cocok dengan pencarian Anda.</p>
            <p class="text-secondary">Coba gunakan kata kunci lain atau periksa ejaan Anda.</p>
        </div>
    </div>

    <!-- FAQ Accordion -->
    <div class="accordion" id="faqAccordion">
        @forelse($faqs as $index => $faq)
        <div class="accordion-item faq-item" data-question="{{ $faq->question }}" data-answer="{{ $faq->answer }}">
            <h2 class="accordion-header" id="heading{{ $faq->id }}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse{{ $faq->id }}" aria-expanded="false"
                    aria-controls="collapse{{ $faq->id }}">
                    {{ $faq->question }}
                </button>
            </h2>
            <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $faq->id }}"
                data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    {{ $faq->answer }}
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <p class="text-muted">No FAQs available at the moment.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<style>
    [x-cloak] {
        display: none !important;
    }

    body {
        background-color: #f8f9fa;
    }

    .faq-header {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        padding: 2rem;
        margin-bottom: 2rem;
        text-align: center;
    }

    .faq-image-container {
        max-width: 350px;
        margin: 0 auto 1.5rem;
    }

    .faq-title {
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    .faq-subtitle {
        color: #6c757d;
        margin-bottom: 1.5rem;
    }

    .scroll-button {
        background-color: #6366F1;
        color: white;
        border: none;
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .scroll-button:hover {
        background-color: #4F46E5;
        transform: translateY(-2px);
    }

    .accordion-item {
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 10px !important;
        margin-bottom: 1rem;
        background-color: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        overflow: hidden;
        transition: border-left 0.3s ease;
        border-left: 0px solid transparent;
    }

    .accordion-button {
        padding: 1.25rem 1.5rem;
        font-weight: 500;
        background-color: white;
        color: #212529;
    }

    .accordion-button:not(.collapsed) {
        background-color: white;
        color: #4F46E5;
        box-shadow: none;
    }

    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(0, 0, 0, 0.08);
    }

    .accordion-button::after {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%236366F1' class='bi bi-chevron-down' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
    }

    .accordion-button:not(.collapsed)::after {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%236366F1' class='bi bi-chevron-up' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z'/%3E%3C/svg%3E");
    }

    .accordion-body {
        padding: 1rem 1.5rem 1.5rem;
        color: #6c757d;
    }

    /* First accordion item with purple border */
    .accordion-item.active {
        border-left: 4px solid #6366F1;
        animation: borderSlideIn 0.1s ease-out;
    }

    .accordion-button.active-button {
        color: #4F46E5;
    }

    @keyframes borderSlideIn {
        0% {
            border-left: 0px solid #6366F1;
        }

        100% {
            border-left: 4px solid #6366F1;
        }
    }

    .search-container {
        max-width: 600px;
        margin: 0 auto 1.5rem;
    }

    .input-group {
        border-radius: 50px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .input-group-text,
    .form-control {
        border-color: #E5E7EB;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #E5E7EB;
    }

    .empty-results {
        padding: 3rem;
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
    }
</style>
@endpush

@push('scripts')
<script>
    // Scroll button functionality
    document.getElementById('scrollButton').addEventListener('click', function() {
        document.querySelector('#faqAccordion').scrollIntoView({
            behavior: 'smooth'
        });
    });

    // Add active state to clicked accordion items
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.accordion-button').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active classes from all accordion items
                document.querySelectorAll('.accordion-item').forEach(item => {
                    item.classList.remove('active');
                });
                document.querySelectorAll('.accordion-button').forEach(btn => {
                    btn.classList.remove('active-button');
                });

                // Add active class to the parent accordion item when expanded
                if (this.classList.contains('collapsed')) {
                    this.closest('.accordion-item').classList.add('active');
                    this.classList.add('active-button');
                }
            });
        });

        // Bootstrap's collapse event to manage active states
        const accordionItems = document.querySelectorAll('.accordion-collapse');
        accordionItems.forEach(item => {
            item.addEventListener('shown.bs.collapse', function() {
                // When an item is shown, add active classes
                this.closest('.accordion-item').classList.add('active');
                this.previousElementSibling.querySelector('.accordion-button').classList.add('active-button');
            });

            item.addEventListener('hidden.bs.collapse', function() {
                // When an item is hidden, remove active classes
                this.closest('.accordion-item').classList.remove('active');
                this.previousElementSibling.querySelector('.accordion-button').classList.remove('active-button');
            });
        });
    });

    // JavaScript-based live search
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('faqSearchInput');
        const faqItems = document.querySelectorAll('.faq-item');
        const noResultsMessage = document.getElementById('noResultsMessage');
        const faqAccordion = document.getElementById('faqAccordion');

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            let hasResults = false;

            // Loop through all FAQ items
            faqItems.forEach(item => {
                const question = item.getAttribute('data-question').toLowerCase();
                const answer = item.getAttribute('data-answer').toLowerCase();

                // Check if either question or answer contains the search term
                if (question.includes(searchTerm) || answer.includes(searchTerm) || searchTerm === '') {
                    item.style.display = 'block';
                    hasResults = true;
                } else {
                    item.style.display = 'none';
                }
            });

            // Show/hide no results message
            if (!hasResults && searchTerm !== '') {
                noResultsMessage.classList.remove('d-none');
                faqAccordion.classList.add('d-none');
            } else {
                noResultsMessage.classList.add('d-none');
                faqAccordion.classList.remove('d-none');
            }
        });
    });
</script>
@endpush