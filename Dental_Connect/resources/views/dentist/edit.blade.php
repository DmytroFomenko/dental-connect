@extends('layouts.main')


@section('content')
    <div class="container mt-2">
        <div class="card shadow rounded mx-auto" style="max-width: 600px;">
            <div class="card-body">

                <form action="{{ route('dentist.update') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('patch')

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Name</label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name', $dentist->name) }}"
                               class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Photo -->
                    <div class="mb-3">
                        <label for="photo" class="form-label fw-semibold">Photo</label>
                        @if ($dentist->photo_name && $dentist->photo_name !== 'null.png')
                            <div class="mb-2 text-center">
                                <img src="{{ asset('storage/dentist_photos/' . $dentist->photo_name) }}" alt="Dentist photo"
                                     class="rounded img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                            </div>
                        @endif
                        <input type="file" name="photo" id="photo"
                               class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                        @error('photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <!-- Experience -->
                    <div class="mb-3">
                        <label for="experience" class="form-label fw-semibold">Experience (years)</label>
                        <input type="number" name="experience" id="experience"
                               value="{{ old('experience', $dentist->experience) }}"
                               class="form-control @error('experience') is-invalid @enderror" min="0" max="100" required>
                        @error('experience')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">Description</label>
                        <textarea name="description" id="description" rows="5"
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $dentist->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@if (session('success'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
        <div id="successToast" class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toastEl = document.getElementById('successToast');
        if (toastEl) {
            const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
            toast.show();
        }
    });
</script>

