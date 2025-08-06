@extends('layouts.main')

@section('content')
    <div class="container mt-3">
        {{-- <h2 class="mb-4">My appointment schedule</h2> --}}

        @if ($appointments->isEmpty())
            <div class="alert alert-info">
                You don't have any appointments scheduled yet.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light">
                    <tr>
                        <th scope="col">Patient name</th>
                        <th scope="col">Phone number</th>
                        <th scope="col">Start of reception</th>
                        <th scope="col">End of reception</th>
                        <th scope="col">Duration</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $previousDate = null;
                    @endphp

                    @foreach ($appointments as $index => $appointment)
                        @php
                            $currentDate = \Carbon\Carbon::parse($appointment->begin_time)->format('Y-m-d');
                        @endphp

                        @if ($currentDate !== $previousDate)
                            <tr>
                                <td colspan="5" class="table-info text-start fw-semibold" style="border-top: 3px solid #0dcaf0;">
                                    <div class="py-2 px-3 text-center">
                                        {{ \Carbon\Carbon::parse($appointment->begin_time)->format('d.m, l') }}
                                    </div>
                                </td>
                            </tr>
                            @php
                                $previousDate = $currentDate;
                            @endphp
                        @endif

                        <tr>
                            <td class="fw-semibold">{{ $appointment->patient_name }}</td>
                            <td>
                                <a href="tel:{{ $appointment->phone_number }}" class="text-decoration-none">
                                    +38{{ $appointment->phone_number }}
                                </a>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($appointment->begin_time)->format('H:i') }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}
                            </td>
                            <td>
                                {{
                                    \Carbon\Carbon::parse($appointment->begin_time)
                                        ->diff(\Carbon\Carbon::parse($appointment->end_time))
                                        ->format('%h h. %i min.')
                                }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-4">
                    {{ $appointments->links() }}
                </div>

            </div>
        @endif
    </div>
@endsection
