<div class="modal fade" id="deleteModal-{{ $element->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this item?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn draw-border" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cancel</button>
        <form action="{{ route('admin.apartments.destroy', ['apartment' => $element->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn draw-border"><i class="fa-solid fa-trash"></i> Delete permanently</button>
        </form>

      </div>
    </div>
  </div>
</div> 