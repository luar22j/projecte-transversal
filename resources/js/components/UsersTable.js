class UsersTable {
    constructor(containerId, options = {}) {
        this.container = document.getElementById(containerId);
        this.options = {
            onEdit: () => {},
            onDelete: () => {},
            ...options,
        };
        this.init();
    }

    init() {
        this.render();
        this.bindEvents();
    }

    render() {
        this.container.innerHTML = `
            <div class="bg-white shadow-md rounded my-6">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">ID</th>
                            <th class="py-3 px-6 text-left">Nombre</th>
                            <th class="py-3 px-6 text-left">Email</th>
                            <th class="py-3 px-6 text-left">Rol</th>
                            <th class="py-3 px-6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="users-table-body" class="text-gray-600 text-sm font-light">
                    </tbody>
                </table>
            </div>
        `;
    }

    bindEvents() {
        const tbody = document.getElementById("users-table-body");
        tbody.addEventListener("click", (e) => {
            const editButton = e.target.closest("[data-action='edit']");
            const deleteButton = e.target.closest("[data-action='delete']");

            if (editButton) {
                const userId = editButton.dataset.userId;
                this.options.onEdit(userId);
            }

            if (deleteButton) {
                const userId = deleteButton.dataset.userId;
                if (
                    confirm(
                        "¿Estás seguro de que deseas eliminar este usuario?"
                    )
                ) {
                    this.options.onDelete(userId);
                }
            }
        });
    }

    updateUsers(users) {
        const tbody = document.getElementById("users-table-body");
        tbody.innerHTML = users
            .map((user) => this.renderUserRow(user))
            .join("");
    }

    renderUserRow(user) {
        const roleClass =
            user.role.nombre === "admin"
                ? "bg-purple-100 text-purple-800"
                : "bg-green-100 text-green-800";

        return `
            <tr class="border-b border-gray-200 hover:bg-gray-100">
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    ${user.id}
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    ${user.nombre} ${user.apellidos}
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    ${user.email}
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${roleClass}">
                        ${user.role.nombre}
                    </span>
                </td>
                <td class="py-3 px-6 text-center">
                    <button data-action="edit" data-user-id="${user.id}" 
                            class="text-indigo-600 hover:text-indigo-900 mr-3">
                        Editar
                    </button>
                    ${
                        user.id !== window.currentUserId
                            ? `
                        <button data-action="delete" data-user-id="${user.id}" 
                                class="text-red-600 hover:text-red-900">
                            Eliminar
                        </button>
                    `
                            : ""
                    }
                </td>
            </tr>
        `;
    }

    showSuccess(message) {
        const alert = document.createElement("div");
        alert.className =
            "bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4";
        alert.innerHTML = `<span class="block sm:inline">${message}</span>`;
        this.container.insertBefore(alert, this.container.firstChild);
        setTimeout(() => alert.remove(), 3000);
    }

    showError(message) {
        const alert = document.createElement("div");
        alert.className =
            "bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4";
        alert.innerHTML = `<span class="block sm:inline">${message}</span>`;
        this.container.insertBefore(alert, this.container.firstChild);
        setTimeout(() => alert.remove(), 3000);
    }
}

export default UsersTable;
