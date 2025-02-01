<style>
    .modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    }

    .modal-content {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    width: 400px;
    z-index: 1001;
    }

    .modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    }

    .modal-title {
    font-size: 1.25rem;
    font-weight: bold;
    }

    .close-button {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0;
    color: #666;
    }

    .modal-body {
    margin-bottom: 20px;
    }

    .modal-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    }

    .btn-cancel {
    background-color: #6c757d;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    }

    .btn-delete {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    }
</style>

<div id="deleteModal" class="modal-overlay">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Delete Application</h5>
      <button type="button" class="close-button" onclick="closeModal()">&times;</button>
    </div>
    <div class="modal-body">
      <p>Are you sure you want to delete this application?</p>
    </div>
    <div class="modal-buttons">
      <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
      <button type="button" class="btn-delete" onclick="confirmDelete()">Delete</button>
    </div>
  </div>
</div>

<script>
    let currentDeleteForm = null;

    function showDeleteModal(form) {
    currentDeleteForm = form;
    document.getElementById('deleteModal').style.display = 'block';
    }

    function closeModal() {
    document.getElementById('deleteModal').style.display = 'none';
    currentDeleteForm = null;
    }

    function confirmDelete() {
    if (currentDeleteForm) {
        currentDeleteForm.submit();
    }
    closeModal();
    }

    // Close modal if clicking outside
    window.onclick = function(event) {
    const modal = document.getElementById('deleteModal');
    if (event.target === modal) {
        closeModal();
    }
    }
</script>