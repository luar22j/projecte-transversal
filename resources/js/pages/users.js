import UserService from "@/services/UserService";
import UsersTable from "@/components/UsersTable";

class UsersPage {
    constructor() {
        this.table = new UsersTable("users-container", {
            onEdit: this.handleEdit.bind(this),
            onDelete: this.handleDelete.bind(this),
        });
        this.init();
    }

    async init() {
        this.bindEvents();
        await this.loadUsers();
    }

    bindEvents() {
        document
            .querySelector("[data-action='create']")
            ?.addEventListener("click", () => {
                window.location.href = "/admin/users/create";
            });
    }

    async loadUsers() {
        try {
            const users = await UserService.getUsers();
            this.table.updateUsers(users);
        } catch (error) {
            this.table.showError(error.message);
        }
    }

    async handleEdit(userId) {
        window.location.href = `/admin/users/${userId}/edit`;
    }

    async handleDelete(userId) {
        try {
            await UserService.deleteUser(userId);
            this.table.showSuccess("Usuario eliminado correctamente");
            await this.loadUsers();
        } catch (error) {
            this.table.showError(error.message);
        }
    }
}

// Inicializar la página cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
    new UsersPage();
});
