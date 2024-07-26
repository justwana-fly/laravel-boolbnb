<!-- resources/views/admin/project/table.blade.php -->
@include('partials.modal-show')
<table id="mr-table" class="table table-hover shadow mb-2 mt-3">
    <thead>
        <tr>
            <!-- <th scope="col">#id Project</th> -->
            <th scope="col" class="text-white fw-normal align-content-center">Service id</th>
            <th scope="col" class="text-white fw-normal d-xl-table-cell align-content-center">Name</th>
            <th scope="col" class="text-white fw-normal d-lg-table-cell align-content-center">Icon</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($elements as $element)
            <tr>
                <!-- <td>{{ $element->id }}</td> -->
                <td class="align-content-center d-xl-table-cell ">{{ $element->id }}</td>
                <td class="align-content-center d-xl-table-cell">{{ $element->name }}</td>
                <td class="align-content-center d-lg-table-cell">
                    <div class="img-icon rounded-circle bg-white p-2">   
                        <img class="img-fluid" src="{{ asset('storage/' . $element->icon) }}" alt="{{ $element->name }}">
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

