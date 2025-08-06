@extends('layouts.main')


@section('content')
    <div class = "container mt-4">
        <h2 class = "mb-4 text-primary fw-bold">Our Dentists</h2>

        <div class = "row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($dentists as $dentist)
                <div class = "col">
                    <div class = "card h-100 shadow-sm cursor-pointer dentist-card"
                         data-name = "{{ $dentist->name }}"
                         data-experience = "{{ $dentist->experience }}"
                         data-description = "{{ $dentist->description }}"
                         data-photo = "{{ asset('storage/dentist_photos/' . $dentist->photo_name) }}"
                         data-bs-toggle = "modal"
                         data-bs-target = "#dentistModal">
                        <div class = "ratio ratio-1x1">
                            <img src = "{{ asset('storage/dentist_photos/' . $dentist->photo_name) }}"
                                 class = "card-img-top object-fit-cover" alt = "{{ $dentist->name }}">
                        </div>
                        <div class = "card-body">
                            <div class = "fw-bold fs-5 mb-1">{{ $dentist->name }}</div>
                            <div class = "fw-semibold text-dark">
                                Experience: {{ $dentist->experience }} {{ \Illuminate\Support\Str::plural('year', $dentist->experience) }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal -->
    <div class = "modal fade" id = "dentistModal" tabindex = "-1" aria-labelledby = "dentistModalLabel"
         aria-hidden = "true">
        <div class = "modal-dialog modal-dialog-centered modal-lg">
            <div class = "modal-content">
                <div class = "modal-header">
                    <h5 class = "modal-title" id = "dentistModalLabel">Dentist Details</h5>
                    <button type = "button" class = "btn-close" data-bs-dismiss = "modal" aria-label = "Close"></button>
                </div>
                <div class = "modal-body d-flex flex-column flex-md-row gap-3">
                    <div class = "ratio-1x1">
                        <img id = "modalDentistPhoto" src = "" class = "img-fluid rounded shadow"
                             style = "max-width: 250px;" alt = "Dentist photo">
                    </div>
                    <div>
                        <h4 id = "modalDentistName"></h4>
                        <p class = "text-muted mb-1" id = "modalDentistExperience"></p>
                        <p id="modalDentistDescription">{!! nl2br(e($dentist->description)) !!}</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dentistCards = document.querySelectorAll('.dentist-card');
        const modalName = document.getElementById('modalDentistName');
        const modalExperience = document.getElementById('modalDentistExperience');
        const modalDescription = document.getElementById('modalDentistDescription');
        const modalPhoto = document.getElementById('modalDentistPhoto');

        function escapeHtml(text) {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        dentistCards.forEach(card => {
            card.addEventListener('click', function () {
                modalName.textContent = this.dataset.name;
                modalExperience.textContent = `Experience: ${this.dataset.experience} ${this.dataset.experience === "1" ? "year" : "years"}`;
                modalDescription.innerHTML = escapeHtml(this.dataset.description).replace(/\n/g, '<br>');
                modalPhoto.src = this.dataset.photo;
                modalPhoto.alt = this.dataset.name;
            });
        });
    });
</script>

