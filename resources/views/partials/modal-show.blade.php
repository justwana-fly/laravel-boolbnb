<!-- Button trigger modal -->
{{--<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  Launch static backdrop modal
</button>--}}

<!-- Modal -->
<!-- resources/views/partials/modal-show-info.blade.php -->
<div class="modal fade" id="staticBackdropInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropInfoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropInfoLabel">Project Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h1 id="modalTitleInfo"></h1>
                <p id="modalDescriptionInfo"></p>
                <p id="modalCreatedInfo"></p>
                <p id="modalCategoriesInfo"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

