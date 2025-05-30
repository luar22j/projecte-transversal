import HttpService from "./HttpService";

class UserService {
    async getUsers(params = {}) {
        return await HttpService.get("/users", params);
    }

    async createUser(userData) {
        return await HttpService.post("/users", userData);
    }

    async updateUser(userId, userData) {
        return await HttpService.put(`/users/${userId}`, userData);
    }

    async deleteUser(userId) {
        return await HttpService.delete(`/users/${userId}`);
    }

    async getUser(userId) {
        return await HttpService.get(`/users/${userId}`);
    }
}

export default new UserService();
