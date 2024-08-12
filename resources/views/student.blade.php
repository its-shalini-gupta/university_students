@extends('layouts.app')

@section('content')
    <div class="mt-4">
        <div class="row align-items-center">
            <div class="col-auto">
                <h2>Student List</h2>
            </div>
            <div class="col-auto">
                <input type="search" id="searchInput" placeholder="Search">
            </div>
            <div class="col text-center">
                @if (session('success'))
                    <div class="alert alert-success" id="successMessage">
                        {{ session('success') }}
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger" id="errorMessage">
                        {{ session('error') }}
                    </div>
                @endif
            </div>

        </div>

        <div>

            <table class="table table-hover mt-4">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>DOB</th>
                        <th>Admission Date</th>
                        <th>Class</th>
                        <th>Gender</th>
                        <th>Teacher</th>
                        <th>Yearly Fees</th>
                        <th>Date of Leaving</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <form id="studentForm" action="{{ route('students.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="_method" id="formMethod" value="POST">
                            <input type="hidden" name="student_id" id="student_id">
                            <td>
                                <input type="text" class="form-control @error('student_name') is-invalid @enderror"
                                    id="student_name" name="student_name" placeholder="Name"
                                    value="{{ old('student_name') }}" required>
                                @error('student_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <input type="date" class="form-control @error('student_dob') is-invalid @enderror"
                                    id="student_dob" name="student_dob" value="{{ old('student_dob') }}" required>
                                @error('student_dob')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <input type="date"
                                    class="form-control @error('student_admission_date') is-invalid @enderror"
                                    id="student_admission_date" name="student_admission_date"
                                    value="{{ old('student_admission_date') }}" required>
                                @error('student_admission_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <input type="text" class="form-control @error('student_class') is-invalid @enderror"
                                    id="student_class" name="student_class" placeholder="Class"
                                    value="{{ old('student_class') }}" required>
                                @error('student_class')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <select class="form-control @error('student_gender') is-invalid @enderror"
                                    id="student_gender" name="student_gender" required>
                                    <option value="">Select</option>
                                    <option value="1" {{ old('student_gender') == 1 ? 'selected' : '' }}>Female
                                    </option>
                                    <option value="0" {{ old('student_gender') == 0 ? 'selected' : '' }}>Male
                                    </option>
                                </select>
                                @error('student_gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <select class="form-control @error('student_teacher_id') is-invalid @enderror"
                                    id="student_teacher_id" name="student_teacher_id" required>
                                    <option value="">Select</option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->teacher_id }}"
                                            {{ old('student_teacher_id') == $teacher->teacher_id ? 'selected' : '' }}>
                                            {{ $teacher->teacher_name }}</option>
                                    @endforeach
                                </select>
                                @error('student_teacher_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <input type="text"
                                    class="form-control @error('student_yearly_fees') is-invalid @enderror"
                                    id="student_yearly_fees" name="student_yearly_fees" placeholder="Yearly Fees"
                                    value="{{ old('student_yearly_fees') }}" required>
                                @error('student_yearly_fees')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <input type="date" class="form-control @error('student_dol') is-invalid @enderror"
                                    id="student_dol" name="student_dol" placeholder="Date of Leaving"
                                    value="{{ old('student_dol') }}">
                                @error('student_dol')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <button type="submit" id="formSubmitButton" class="btn btn-primary">Add</button>
                                <button type="button" class="btn btn-secondary" onclick="clearForm()">Cancel</button>
                            </td>
                        </form>
                    </tr>

                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->student_name }}</td>
                            <td>{{ $student->student_dob }}</td>
                            <td>{{ $student->student_admission_date }}</td>
                            <td>{{ $student->student_class }}</td>
                            <td>{{ $student->student_gender == 1 ? 'Female' : 'Male' }}</td>
                            <td>{{ $student->teacher->teacher_name ?? '' }}</td>
                            <td>{{ $student->yearly_fees }}</td>
                            <td>{{ $student->student_dol }}</td>
                            <td>
                                <button type="button" class="btn btn-primary"
                                    onclick="editStudent({{ json_encode($student) }})">Edit</button>
                                <form action="{{ route('students.destroy', $student->student_id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination">
            {{ $students->links() }}
        </div>

        <script>
            document.getElementById('searchInput').addEventListener('input', function() {
                var searchValue = this.value.toLowerCase();
                var tableRows = document.querySelectorAll('table tbody tr');

                tableRows.forEach(function(row) {
                    var cells = row.querySelectorAll('td');
                    var rowText = '';

                    cells.forEach(function(cell) {
                        rowText += cell.textContent.toLowerCase() + ' ';
                    });

                    if (rowText.indexOf(searchValue) > -1) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            function clearForm() {
                const form = document.getElementById('studentForm');
                form.reset();
                document.getElementById('formMethod').value = 'POST';
                document.getElementById('formSubmitButton').textContent = 'Add';
                document.getElementById('studentForm').action = "{{ route('students.store') }}";
                document.getElementById('successMessage')?.remove();
                document.getElementById('errorMessage')?.remove();
            }

            function editStudent(student) {
                const form = document.getElementById('studentForm');
                form.action = `{{ route('students.update', '') }}/${student.student_id}`;
                document.getElementById('student_id').value = student.student_id;
                document.getElementById('student_name').value = student.student_name;
                document.getElementById('student_dob').value = student.student_dob;
                document.getElementById('student_admission_date').value = student.student_admission_date;
                document.getElementById('student_class').value = student.student_class;
                document.getElementById('student_gender').value = student.student_gender;
                document.getElementById('student_teacher_id').value = student.student_teacher_id;
                document.getElementById('student_yearly_fees').value = student.student_yearly_fees;
                document.getElementById('student_dol').value = student.student_dol;
                document.getElementById('formMethod').value = 'PUT';
                document.getElementById('formSubmitButton').textContent = 'Update';
            }
        </script>

    </div>
@endsection
