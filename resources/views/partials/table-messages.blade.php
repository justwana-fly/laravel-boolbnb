@include('partials.modal-show')

<table id="mr-table" class="table table-hover shadow mb-2 mt-3">
    <thead>
        <tr class="text-white">
            <th scope="col" class="align-content-center text-white d-xl-table-cell fw-normal">Apartment Name</th>
            <th scope="col" class="align-content-center text-white d-xl-table-cell fw-normal">Received On</th>
            <th scope="col" class="align-content-center text-white d-xl-table-cell fw-normal">Sender Name</th>
            <th scope="col" class="align-content-center text-white d-lg-table-cell fw-normal">Sender Email</th>
            <th scope="col" class="text-white fw-normal align-content-center d-lg-table-cell">Message</th>
            <th scope="col" class="text-white fw-normal align-content-center d-lg-table-cell">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($messages as $message)
            <tr>
                <td class="align-content-center d-xl-table-cell">
                    {{ $message->apartment ? $message->apartment->name : 'N/A' }}
                </td>
                <td class="align-content-center d-xl-table-cell">{{ $message->created_at }}</td>
                <td class="align-content-center d-xl-table-cell">{{ $message->name }}</td>
                <td class="align-content-center d-lg-table-cell">{{ $message->email }}</td>
                <td class="align-content-center d-lg-table-cell">{{ $message->message }}</td>
                <td class="align-content-center d-lg-table-cell">
                    <a href="{{ route('admin.leads.show', $message->id) }}" class="btn draw-border">
                        <div class="icon-container">
                            <i class="fs-3 fas fa-info-circle"></i>
                        </div>
                    </a>
                    <form class="d-inline" id="delete-form-{{ $message->id }}" action="{{ route('admin.leads.destroy', $message->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn draw-border" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $message->id }}">
                            <i class="fs-3 text-danger fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            <!-- Include the modal for delete confirmation -->
            <div class="modal fade" id="deleteModal-{{ $message->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Confirm deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this message?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn draw-border" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cancel</button>
                            <form action="{{ route('admin.leads.destroy', ['lead' => $message->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn draw-border"><i class="fa-solid fa-trash"></i> Delete permanently</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </tbody>
</table>

