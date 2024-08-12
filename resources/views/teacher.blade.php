@extends('layouts.app')

@section('content')
    <style>
        .teacherForm {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            width: 30%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
    </style>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h2>Teacher List</h2>
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
            <div class="col-auto">
                <button class="btn btn-primary addPopup"><i class="fa-solid fa-plus"></i></button>
            </div>
        </div>

        <div class="teacherForm">
            <form id="teacherForm" action="{{ route('teachers.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="teacher_id" id="teacher_id">
                <div class="form-group">
                    <label for="teacher_name">Name</label>
                    <input type="text" class="form-control @error('teacher_name') is-invalid @enderror" id="teacher_name"
                        name="teacher_name" placeholder="Name" value="{{ old('teacher_name') }}" required>
                    @error('teacher_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="teacher_dob">Date of Birth</label>
                    <input type="date" class="form-control @error('teacher_dob') is-invalid @enderror" id="teacher_dob"
                        name="teacher_dob" value="{{ old('teacher_dob') }}" required>
                    @error('teacher_dob')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="teacher_doj">Date of Joining</label>
                    <input type="date" class="form-control @error('teacher_doj') is-invalid @enderror" id="teacher_doj"
                        name="teacher_doj" value="{{ old('teacher_doj') }}" required>
                    @error('teacher_doj')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="teacher_gender">Gender</label>
                    <select class="form-control @error('teacher_gender') is-invalid @enderror" id="teacher_gender"
                        name="teacher_gender" required>
                        <option value="">Select</option>
                        <option value="1" {{ old('teacher_gender') == 1 ? 'selected' : '' }}>Female</option>
                        <option value="0" {{ old('teacher_gender') == 0 ? 'selected' : '' }}>Male</option>
                    </select>
                    @error('teacher_gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="teacher_dol">Date of Leaving</label>
                    <input type="date" class="form-control @error('teacher_dol') is-invalid @enderror" id="teacher_dol"
                        name="teacher_dol" placeholder="Date of Leaving" value="{{ old('teacher_dol') }}">
                    @error('teacher_dol')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" id="formSubmitButton" class="btn btn-primary">Add</button>
                <button type="button" class="btn btn-secondary cancelButton">Cancel</button>
            </form>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date of birth</th>
                    <th>Date of joining</th>
                    <th>Gender</th>
                    <th>Date of Leaving</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teachers as $teacher)
                    <tr>
                        <td>{{ $teacher->teacher_name }}</td>
                        <td>{{ $teacher->teacher_dob }}</td>
                        <td>{{ $teacher->teacher_doj }}</td>
                        <td>{{ $teacher->teacher_gender == 1 ? 'Female' : 'Male' }}</td>
                        <td>{{ $teacher->teacher_dol }}</td>
                        <td>
                            <button type="button" class="btn btn-primary"
                                onclick="editTeacher({{ json_encode($teacher) }})"><i
                                    class="fa-solid fa-pen-to-square"></i></button>
                            <form action="{{ route('teachers.destroy', $teacher->teacher_id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination">
            {{ $teachers->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            document.querySelector('.addPopup').addEventListener('click', function() {
                document.querySelector('.teacherForm').style.display = 'block';
            });

            document.querySelector('.cancelButton').addEventListener('click', function() {
                document.getElementById('teacherForm').reset();
                document.querySelector('.teacherForm').style.display = 'none';
            });

            window.editTeacher = function(teacher) {
                document.querySelector('.teacherForm').style.display = 'block';
                document.getElementById('teacherForm').action = `{{ url('/teachers') }}/${teacher.teacher_id}`;

                document.getElementById('teacher_id').value = teacher.teacher_id;
                document.getElementById('teacher_name').value = teacher.teacher_name;
                document.getElementById('teacher_dob').value = teacher.teacher_dob;
                document.getElementById('teacher_doj').value = teacher.teacher_doj;
                document.getElementById('teacher_gender').value = teacher.teacher_gender;
                document.getElementById('teacher_dol').value = teacher.teacher_dol;

                document.getElementById('formSubmitButton').textContent = 'Update';
                document.getElementById('formMethod').value = 'PUT';
            };

            function autoHideMessage(selector, delay) {
                const messageElement = document.querySelector(selector);
                if (messageElement) {
                    setTimeout(function() {
                        messageElement.style.opacity = 0;
                        setTimeout(function() {
                            messageElement.style.display = 'none';
                        }, 500); 
                    }, delay);
                }
            }

            autoHideMessage('#successMessage', 5000);
            autoHideMessage('#errorMessage', 5000);
        });
    </script>

@endsection
