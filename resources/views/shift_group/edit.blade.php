@extends('layout.main')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
        </div>
        <section class="content">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center mb-2">
                    <div class="col">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb" style="background-color: transparent;">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.shift_group') }}">Shift Group</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Show</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.shift_group.update', ['id' => $shiftGroup->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="container-fluid px-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Group Code</label>
                                    <input name="group_code" type="text" class="form-control" value={{$shiftGroup->group_code}}>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Group Name</label>
                                    <input name="group_name" type="text" class="form-control" value={{$shiftGroup->group_name}}>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Total Days</label>
                                    <input id="total_days" name="total_days" type="text" class="form-control" value={{$shiftGroup->total_days}}>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Start Date</label>
                                    <input name="start_date" type="date" class="form-control" value={{$shiftGroup->start_date}}>
                                </div>
                                <div class="col-md-8">
                                    <label></label>
                                    <div class=""
                                        style="d-flex justify-content-center align-items-center text-align:center">
                                        <button type="button" onclick="generateTable()" class="btn btn-success">Generate
                                            Table</button>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <table id="resultTable" class="table" border="1">
                                        <!-- Table content will be generated here -->
                                    </table>
                                </div>
                                <input type="text" id="shift_data" name="shift_data" value="" hidden>
                                <div class=""
                                style="d-flex justify-content-center align-items-center text-align:center">
                                <button onclick="submitDataShift()" type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script>
            window.shiftDaily = JSON.parse('{!! $shiftDaily !!}');

            function generateTable() {
                const totalDays = document.getElementById("total_days").value;
                const resultTable = document.getElementById("resultTable");
                resultTable.innerHTML = "";

                const headerRow = document.createElement("tr");
                const headers = ["Days Number", "Shift Code", "Description"];
                headers.forEach(headerText => {
                    const headerCell = document.createElement("th");
                    headerCell.textContent = headerText;
                    headerRow.appendChild(headerCell);
                });
                resultTable.appendChild(headerRow);
                const shifts = window.shiftDaily;

                for (let i = 1; i <= totalDays; i++) {
                    const row = document.createElement("tr");
                    const dayCell = document.createElement("td");
                    dayCell.textContent = i;
                    row.appendChild(dayCell);

                    const shiftCodeCell = document.createElement("td");
                    const shiftCodeSelect = document.createElement("select");
                    shiftCodeSelect.name = `shift_code_${i}`;
                    shiftCodeSelect.className = "form-control";

                    for (let i = 0; i < shifts.length; i++) {
                        const option = document.createElement("option");
                        option.value = shifts[i].id;
                        option.textContent = shifts[i].shift_daily_code;
                        shiftCodeSelect.appendChild(option);
                    }

                    const descriptionCell = document.createElement("td");
                    row.appendChild(descriptionCell);

                    shiftCodeSelect.addEventListener('change', function() {
                        const selectedShiftId = shiftCodeSelect.value;
                        const selectedShift = shifts.find(shift => shift.id == selectedShiftId);

                        if (selectedShift) {
                            descriptionCell.textContent = "Start - End: " + selectedShift.start_time.slice(0, 5) +
                                " - " +
                                selectedShift.end_time.slice(0, 5) || '';
                        }
                    });

                    const defaultShiftId = shiftCodeSelect.options[0].value;
                    const defaultShift = shifts.find(shift => shift.id == defaultShiftId);
                    if (defaultShift) {
                        descriptionCell.textContent = "Start - End: " + defaultShift.start_time.slice(0, 5) + " - " +
                            defaultShift.end_time.slice(0, 5) || ''; // Set description or empty string
                    }

                    shiftCodeCell.appendChild(shiftCodeSelect);
                    row.appendChild(shiftCodeCell);
                    row.appendChild(descriptionCell);
                    // Append the row to the result table
                    resultTable.appendChild(row);
                }
            }

            function submitDataShift() {
                const resultTable = document.getElementById('resultTable');
                const totalDays = document.getElementById('total_days').value;

                let data = [];

                for (let i = 0; i < totalDays; i++) {
                    let row = resultTable.rows[i + 1]; // Skip the header row (i + 1)
                    let dayNumber = row.cells[0].textContent;
                    let shiftCode = row.cells[1].querySelector('select').value;
                    let description = row.cells[2].textContent;

                    // Push the data as an object into the data array
                    data.push({
                        day_order: dayNumber,
                        shift_daily_id: shiftCode,
                    });
                }

                // Convert the data array to JSON string
                const jsonData = JSON.stringify(data);

                // Set the value of the hidden input field
                const dataShiftInput = document.getElementById('shift_data');
                dataShiftInput.value = jsonData;
            }
        </script>
    @endpush
@stop
