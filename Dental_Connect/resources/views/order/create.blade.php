@extends('layouts.main')

@section('content')
    <div class = "container mt-5" style = "max-width: 40%;">
        <h2 class = "mb-4 text-center">Send an Appointment</h2>

        <form method = "POST" action = "{{ route('order.store') }}">
            @csrf

            <div class = "mb-3">
                <label for = "patient_name" class = "form-label">Name</label>
                <input
                    type = "text"
                    name = "patient_name"
                    id = "patient_name"
                    required
                    value = "{{ old('patient_name') }}"
                    class = "form-control @error('patient_name') is-invalid @enderror"
                    placeholder = "Enter your name"
                >
                @error('patient_name')
                <div class = "invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class = "mb-3">
                <label for = "phone" class = "form-label">Phone Number</label>
                <div class = "input-group @error('phone') is-invalid @enderror">
                    <span class = "input-group-text">+38</span>
                    <input
                        type = "text"
                        name = "phone"
                        id = "phone"
                        required
                        value = "{{ old('phone') }}"
                        class = "form-control @error('phone') is-invalid @enderror"
                        placeholder = "XXXXXXXXX"
                    >
                </div>
                @error('phone')
                <div class = "invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>


            <div class = "mb-3 position-relative">
                <label for = "dentist_id" class = "form-label">Choose a dentist</label>

                <!-- Приховане поле для зберігання вибраного dentist_id -->
                <input type = "hidden" name = "dentist_id" id = "dentist_id" value = "{{ old('dentist_id') }}">

                <!-- Кнопка, яка відкриває список -->
                <div class = "dropdown">
                    <button
                        class = "form-select text-start position-relative d-flex justify-content-between align-items-center"
                        type = "button"
                        id = "dentistDropdownButton"
                        data-bs-toggle = "dropdown"
                        aria-expanded = "false">
                        {{ optional($dentists->firstWhere('id', old('dentist_id')))->name ?? 'Choose a dentist' }}
                        <span
                            class = "dropdown-toggle ms-auto position-absolute end-0 me-3 top-50 translate-middle-y"></span>
                    </button>

                    <!-- Dropdown список лікарів -->
                    <ul class = "dropdown-menu w-100" aria-labelledby = "dentistDropdownButton"
                        style = "max-height: 300px; overflow-y: auto;" id = "dentistDropdownList">
                        @foreach($dentists as $dentist)
                            <li>
                                <button type = "button"
                                        class = "dropdown-item d-flex align-items-start gap-2 @if(old('dentist_id') == $dentist->id) active bg-primary bg-opacity-10 @endif"
                                        data-id = "{{ $dentist->id }}"
                                        data-name = "{{ $dentist->name }}"
                                        onclick = "selectDentist(this)">
                                    <img src = "{{ asset('storage/dentist_photos/' . $dentist->photo_name) }}"
                                         alt = "{{ $dentist->name }}"
                                         class = "rounded-circle"
                                         style = "width: 40px; height: 40px; object-fit: cover;">
                                    <div>
                                        <div class = "fw-bold">{{ $dentist->name }}</div>
                                        <small class = "text-muted">{{ $dentist->experience }} years of experience</small>
                                    </div>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>

                @error('dentist_id')
                <div class = "invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>


            <button type = "submit" class = "btn btn-primary w-100">Submit Request</button>
        </form>
    </div>
@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.select-dentist').forEach(function (item) {
                item.addEventListener('click', function (e) {
                    e.preventDefault();
                    const id = this.dataset.id;
                    const name = this.dataset.name;

                    // Записати у приховане поле
                    document.getElementById('selectedDentistId').value = id;

                    // Замінити текст кнопки
                    document.getElementById('dentistDropdown').textContent = name;
                });
            });
        });
    </script>
@endpush

<!-- JS: оновлення прихованого input та тексту кнопки -->
<script>
    function selectDentist(button) {
        const name = button.getAttribute('data-name');
        const id = button.getAttribute('data-id');

        // Оновлюємо текст кнопки
        document.getElementById('dentistDropdownButton').textContent = name;

        // Оновлюємо приховане поле
        document.getElementById('dentist_id').value = id;

        // Видаляємо підсвітку у всіх
        document.querySelectorAll('#dentistDropdownList .dropdown-item').forEach(item => {
            item.classList.remove('bg-primary', 'bg-opacity-10');
        });

        // Додаємо підсвітку вибраному
        button.classList.add('active', 'bg-primary', 'bg-opacity-10', 'text-black');
    }
</script>

