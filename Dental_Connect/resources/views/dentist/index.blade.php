@extends('layouts.main')

@section('content')

    <div class="container mt-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h2 class="mb-4 text-primary fw-bold">Orders List</h2>

                @if(count($orders) === 0)
                    <div class="alert alert-info mb-0">There are no orders at this time.</div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle text-center">
                            <thead class="table-primary">
                            <tr>
                                <th class="text-uppercase small fw-bold">Date & Time</th>
                                <th class="text-uppercase small fw-bold">Patient Name</th>
                                <th class="text-uppercase small fw-bold">Phone Number</th>
                                <th class="text-uppercase small fw-bold text-nowrap px-1">Status</th>
                                <th class="text-uppercase small fw-bold text-nowrap px-1">Actions</th>


                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr style="{{ $order->status === 'processed' ? 'background-color: #f8f9fa;' : '' }}">
                                    <td class="{{ $order->status === 'processed' ? 'bg-body-secondary' : '' }}">
                                        <span class="utc-to-local" data-utc="{{ $order->created_at->toIso8601String() }}">
                                            {{ $order->created_at->format('d.m H:i') }}
                                        </span>
                                    </td>

                                    <td class="{{ $order->status === 'processed' ? 'bg-body-secondary' : 'fw-medium' }}">
                                        {{ $order->patient_name }}
                                    </td>
                                    <td class="{{ $order->status === 'processed' ? 'bg-body-secondary' : '' }}">
                                        +38 {{ $order->phone }}
                                    </td>
                                    <td class="{{ $order->status === 'processed' ? 'bg-body-secondary' : '' }}">
                                        @if($order->status === 'processed')
                                            <span class="badge bg-success px-3 py-2">Processed</span>
                                        @else
                                            <span class="badge bg-secondary px-3 py-2">New</span>
                                        @endif
                                    </td>
                                    <td class="{{ $order->status === 'processed' ? 'bg-body-secondary' : '' }}">
                                        <div class="d-flex flex-wrap justify-content-center gap-2">
                                            <form method="POST" action="{{ route('dentist.orders.toggle', $order->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm {{ $order->status === 'processed' ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                                    {{ $order->status === 'processed' ? 'Mark as New' : 'Mark as Processed' }}
                                                </button>
                                            </form>
                                            @if($order->status === 'new')
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-primary open-appointment-modal"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#createAppointmentModal"
                                                        data-order-id="{{ $order->id }}"
                                                        data-patient-name="{{ $order->patient_name }}"
                                                        data-phone-number="{{ $order->phone }}">
                                                    Create Appointment
                                                </button>
                                            @endif
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>



                    <div class="d-flex justify-content-center">
                        <ul class="pagination pagination-sm mb-0">
                            {{-- Попередня сторінка --}}
                            @if ($orders->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link border border-secondary rounded-0">&laquo;</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link border border-secondary rounded-0" href="{{ $orders->previousPageUrl() }}" rel="prev">&laquo;</a>
                                </li>
                            @endif

                            {{-- Номери сторінок --}}
                            @foreach ($orders->links()->elements[0] as $page => $url)
                                @if ($page == $orders->currentPage())
                                    <li class="page-item active" aria-current="page">
                                        <span class="page-link border border-secondary rounded-0 bg-primary text-white">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link border border-secondary rounded-0" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Наступна сторінка --}}
                            @if ($orders->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link border border-secondary rounded-0" href="{{ $orders->nextPageUrl() }}" rel="next">&raquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link border border-secondary rounded-0">&raquo;</span>
                                </li>
                            @endif
                        </ul>
                    </div>

                @endif
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="createAppointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('dentist.appointment.store') }}">
                @csrf

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="appointmentModalLabel">Create an Appointment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="modalPatientName" class="form-label">Patient Name</label>
                            <input type="text" class="form-control" id="modalPatientName" name="patient_name"
                                   value="{{ old('patient_name') }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="modalPhone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="modalPhone" name="phone_number"
                                   value="{{ old('phone_number') }}" readonly>
                        </div>


                        <div class="mb-3">
                            <label for="modalDate" class="form-label">Date</label>
                            <input type="date" class="form-control" name="date" id="modalDate"
                                   value="{{ old('date') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="modalBeginTime" class="form-label">Start Time</label>
                            <input type="time" class="form-control" name="begin_time" id="modalBeginTime"
                                   value="{{ old('begin_time') }}" required>
                            @error('begin_time')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="modalEndTime" class="form-label">End Time</label>
                            <input type="time" class="form-control" name="end_time" id="modalEndTime"
                                   value="{{ old('end_time') }}" required>
                            @error('end_time')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="hidden" name="order_id" id="modalOrderId" value="{{ old('order_id') }}">


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Appointment</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

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
            const modal = new bootstrap.Modal(document.getElementById('createAppointmentModal'));
            const buttons = document.querySelectorAll('.open-appointment-modal');

            buttons.forEach(button => {
                button.addEventListener('click', function () {
                    const patientName = this.dataset.patientName;
                    const phoneNumber = this.dataset.phoneNumber;
                    const orderId = this.dataset.orderId;

                    document.getElementById('modalPatientName').value = patientName;
                    document.getElementById('modalPhone').value = phoneNumber;
                    document.getElementById('modalOrderId').value = orderId;

                    modal.show();
                });
            });
        });
    </script>

    {{-- Reopen modal window --}}
    @if ($errors->has('begin_time') || $errors->has('end_time') || $errors->has('date'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                const modal = new bootstrap.Modal(document.getElementById('createAppointmentModal'));
                modal.show();
            });
        </script>
    @endif

{{--    Toast for successfully created appointment --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toastEl = document.getElementById('successToast');
            if (toastEl) {
                const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
                toast.show();
            }
        });
    </script>

    {{-- Min date for calendar form --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const dd = String(today.getDate()).padStart(2, '0');
            const minDate = `${yyyy}-${mm}-${dd}`;

            document.getElementById('modalDate').setAttribute('min', minDate);
        });
    </script>

    {{-- Time to user Time Zone --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.utc-to-local').forEach(el => {
                const utcString = el.dataset.utc;
                const date = new Date(utcString); // UTC-час

                const dd = String(date.getDate()).padStart(2, '0');
                const mm = String(date.getMonth() + 1).padStart(2, '0'); // місяці з 0
                const hh = String(date.getHours()).padStart(2, '0');
                const min = String(date.getMinutes()).padStart(2, '0');

                el.textContent = `${dd}.${mm} ${hh}:${min}`;
            });
        });
    </script>



@endsection



