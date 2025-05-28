@extends('layouts.app')

@section('title', 'FAQ Management')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0 text-gray-800">FAQ Management</h1>
        </div>
        <div class="col-md-6 text-md-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFaqModal">
                <i class="bi bi-plus-circle me-1"></i> Add New FAQ
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        @if($errors->any())
        <ul class="mt-2 mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Frequently Asked Questions</h6>
            <div class="input-group w-50">
                <input type="text" class="form-control" placeholder="Search FAQs..." id="faqSearchInput">
                <span class="input-group-text bg-primary text-white">
                    <i class="bi bi-search"></i>
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="faqTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="30%">Question</th>
                            <th width="50%">Answer</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($faqs->count() > 0)
                        @foreach($faqs as $faq)
                        <tr data-question="{{ $faq->question }}" data-answer="{{ $faq->answer }}">
                            <td>{{ Str::limit($faq->question, 50) }}</td>
                            <td>{{ Str::limit($faq->answer, 100) }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-info edit-faq-btn"
                                        data-id="{{ $faq->id }}" data-question="{{ $faq->question }}"
                                        data-answer="{{ $faq->answer }}" data-bs-toggle="modal"
                                        data-bs-target="#editFaqModal">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger delete-faq-btn"
                                        data-id="{{ $faq->id }}" data-bs-toggle="modal"
                                        data-bs-target="#deleteFaqModal">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="3" class="text-center">No FAQs found. Add your first FAQ.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add FAQ Modal -->
<div class="modal fade" id="addFaqModal" tabindex="-1" aria-labelledby="addFaqModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.faq.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addFaqModalLabel">Add New FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="question" class="form-label">Question</label>
                        <input type="text" class="form-control @error('question') is-invalid @enderror" id="question"
                            name="question" required value="{{ old('question') }}">
                        @error('question')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="answer" class="form-label">Answer</label>
                        <textarea class="form-control @error('answer') is-invalid @enderror" id="answer" name="answer"
                            rows="4" required>{{ old('answer') }}</textarea>
                        @error('answer')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit FAQ Modal -->
<div class="modal fade" id="editFaqModal" tabindex="-1" aria-labelledby="editFaqModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editFaqForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editFaqModalLabel">Edit FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_question" class="form-label">Question</label>
                        <input type="text" class="form-control" id="edit_question" name="question" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_answer" class="form-label">Answer</label>
                        <textarea class="form-control" id="edit_answer" name="answer" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete FAQ Modal -->
<div class="modal fade" id="deleteFaqModal" tabindex="-1" aria-labelledby="deleteFaqModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteFaqForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteFaqModalLabel">Delete FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this FAQ? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card-header .input-group {
        max-width: 300px;
    }

    .badge {
        font-size: 85%;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Edit FAQ functionality
        const editBtns = document.querySelectorAll('.edit-faq-btn');
        editBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const question = this.getAttribute('data-question');
                const answer = this.getAttribute('data-answer');

                document.getElementById('edit_question').value = question;
                document.getElementById('edit_answer').value = answer;

                document.getElementById('editFaqForm').action = `/admin/faq/${id}`;
            });
        });

        // Delete FAQ functionality
        const deleteBtns = document.querySelectorAll('.delete-faq-btn');
        deleteBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('deleteFaqForm').action = `/admin/faq/${id}`;
            });
        });

        // Search functionality
        const searchInput = document.getElementById('faqSearchInput');
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('#faqTable tbody tr');

            rows.forEach(row => {
                const question = row.getAttribute('data-question')?.toLowerCase() || '';
                const answer = row.getAttribute('data-answer')?.toLowerCase() || '';

                if (question.includes(searchTerm) || answer.includes(searchTerm) || searchTerm === '') {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush