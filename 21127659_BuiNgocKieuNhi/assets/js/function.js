function addAuthorRow(event) {
    event.preventDefault();

    const container = document.getElementById('author-list');

    const row = document.createElement('div');
    row.className = 'author-row';

    row.innerHTML = `
        <select name="authors[]" class="input-field">
            ${authorOptions}
        </select>

        <select name="roles[]" class="input-field">
            <option value="first_author">First Author</option>
            <option value="member" selected>Member</option>
        </select>

        <button type="button" class="delete-btn" onclick="removeAuthorRow(this)">✖</button>
    `;

    container.appendChild(row);
}

function removeAuthorRow(button) {
    const container = document.getElementById('author-list');
    const rows = container.getElementsByClassName('author-row');

    if (rows.length > 1) {
        button.parentElement.remove();
    }
}