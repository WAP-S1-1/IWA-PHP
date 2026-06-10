<template>
    <div>
        <Navbar />
        <div id="wrapper2">
            <!-- left side info - hidden on mobile, visible on desktop -->
            <div id="left-side" class="desktop-only">
                <h5>SYSTEM NODE</h5>
                <div class="side-stats">
                    <p>active directory</p>
                    <p>role: {{ currentUser.role }}</p>
                    <p>access level: full</p>
                    <p style="margin-top: 0.8rem;">user registry</p>
                </div>
                <div style="margin-top: auto; font-size: 0.7rem; color: #6f6f6f;">
                    local storage · persistent
                </div>
            </div>

            <!-- main panel: user table + add button + total users -->
            <div class="main-panel">
                <div class="panel-header">
                    <h2>registered employees</h2>
                    <button v-if="isAdmin" @click="openAddModal" class="btn-primary">+ Add user</button>
                </div>

                <!-- Total users card - moved here from right side -->
                <div class="total-users-card">
                    <span class="total-label">total users</span>
                    <strong class="total-number">{{ users.length }}</strong>
                </div>

                <div class="user-table-wrapper">
                    <table class="user-table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="users.length === 0" class="empty-row">
                            <td colspan="3">No users yet. Click "Add user"</td>
                        </tr>
                        <tr v-for="user in users" :key="user.id">
                            <td data-label="Firstname">{{ user.name }}</td>
                            <td data-label="Email">{{ user.email || '—' }}</td>
                            <td data-label="Personal number">{{ user.role || '—' }}</td>
                            <td v-if="isAdmin" data-label="Actions" class="action-buttons">
                                <button @click="openUpdateModal(user.id)" class="btn-update">Edit</button>
                                <button @click="deleteUserById(user.id)" class="btn-danger">Delete</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- right side controls - hidden entirely (only total users was kept and moved) -->
        </div>
        <footer>user management · black & white interface</footer>

        <!-- modal popup (add / update) -->
        <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
            <div class="modal-container">
                <div class="modal-header">
                    <h3>{{ modalTitle }}</h3>
                    <button class="modal-close" @click="closeModal">&times;</button>
                </div>
                <form @submit.prevent="handleModalSubmit">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Firstname *</label>
                            <input type="text" v-model="formData.name" placeholder="Enter name" required />
                        </div>
                        <div class="form-group">
                            <label>Email (optional)</label>
                            <input type="email" v-model="formData.email" placeholder="user@example.com" />
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" v-model="formData.password" placeholder="********" />
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" v-model="formData.password_confirmation" placeholder="Confirm Password" />
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select type="role" v-model="formData.role">
                                <option value="user" selected>User</option>
                                <option value="staff">Staff</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" @click="closeModal">Cancel</button>
                        <button type="submit" class="btn-submit">Save user</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from "./Navbar.vue";
import api from "../../js/stores/users.js";
import {useAuthStore} from "../../js/stores/auth.js";


export default {
    name: "UserAdministration",
    components: {
        Navbar
    },
    data() {
        return {
            users: [],
            showModal: false,
            modalMode: "add", // 'add' or 'update'
            editingUserId: null,
            formData: {
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
                role: "user"
            }
        };
    },
    computed: {
        isAdmin() {
            const auth = useAuthStore()
            return auth.user?.role === "admin"
        },

        currentUser() {
            return useAuthStore().user;
        },

        modalTitle() {
            return this.modalMode === "add" ? "Add new user" : "Update user";
        }
    },
    mounted() {
        this.loadUsers();
    },
    methods: {
        async loadUsers() {
            try {
                const response = await api.get('/users')
                this.users = response.data
            } catch (error) {
                console.error(error)
            }
        },
        resetForm() {
            this.formData = {
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
                role: "user"
            };
        },
        openAddModal() {
            this.modalMode = "add";
            this.editingUserId = null;
            this.resetForm();
            this.showModal = true;
        },
        openUpdateModal(userId) {
            const user = this.users.find(u => u.id === userId);
            if (!user) return;
            this.modalMode = "update";
            this.editingUserId = userId;
            this.formData = {
                name: user.name,
                email: user.email || "",
                password: "",
                password_confirmation: "",
                role: user.role || "user"
            };
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
            this.resetForm();
        },
        async handleModalSubmit() {
            if (!this.formData.name) {
                alert("Name is required.");
                return;
            }

            try {
                if (this.modalMode === "add") {
                    const response = await api.post('/users', {
                        name: this.formData.name,
                        email: this.formData.email,
                        password: this.formData.password,
                        password_confirmation: this.formData.password_confirmation,
                        role: this.formData.role
                    });

                    console.log("User created:", response.data);

                } else if (this.modalMode === "update" && this.editingUserId) {
                    const data = {
                        name: this.formData.name,
                        email: this.formData.email,
                        role: this.formData.role
                    };

                    if (this.formData.password) {
                        data.password = this.formData.password;
                        data.password_confirmation = this.formData.password_confirmation;
                    }

                    const response = await api.put(`/users/${this.editingUserId}`, data);

                    console.log("User updated:", response.data);

                } else {
                    alert("User not found, please refresh.");
                    return;
                }

                await this.loadUsers();
                this.closeModal();

            } catch (error) {
                console.error("API Error:", error);

                if (error.response) {
                    console.error("Response data:", error.response.data);
                    alert(error.response.data.message || "Something went wrong.");
                } else {
                    alert("Cannot connect to API.");
                }
            }
        },
        async deleteUserById(id) {
            if (!confirm('Delete user?')) return

            await api.delete(`/users/${id}`)

            await this.loadUsers()
        }
    },
};
</script>

<style scoped>
/* ===== MOBILE-FIRST STYLES (default for all screen sizes) ===== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: system-ui, 'Segoe UI', 'Inter', 'Helvetica Neue', sans-serif;
}

/* Hide desktop-only elements on mobile */
.desktop-only {
    display: none;
}

#wrapper2 {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: calc(100vh - 72px);
    padding: 1rem;
    background: #f5f5f5;
}

/* main panel - full width on mobile */
.main-panel {
    width: 100%;
    max-width: 100%;
    background: #ffffff;
    border-radius: 24px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    border: 1px solid #e4e4e4;
    overflow: hidden;
}

.panel-header {
    background: #fefefe;
    padding: 1.2rem 1rem;
    border-bottom: 1px solid #eaeaea;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.panel-header h2 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f1f1f;
    letter-spacing: -0.2px;
}

.btn-primary {
    background: #111111;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 40px;
    color: white;
    font-weight: 500;
    cursor: pointer;
    transition: 0.2s;
    font-size: 0.8rem;
    white-space: nowrap;
}

.btn-primary:hover {
    background: #2c2c2c;
}

/* Total users card - moved from right side, prominent on mobile */
.total-users-card {
    background: #0e0e0e;
    margin: 1rem;
    padding: 1rem;
    border-radius: 20px;
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    color: white;
}

.total-label {
    font-size: 0.85rem;
    font-weight: 400;
    letter-spacing: 0.3px;
    text-transform: uppercase;
    color: #c0c0c0;
}

.total-number {
    font-size: 2rem;
    font-weight: 700;
    color: white;
    line-height: 1;
}

.user-table-wrapper {
    overflow-x: auto;
    padding: 0 1rem 1.5rem 1rem;
}

.user-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.8rem;
    min-width: 500px;
}

.user-table th {
    text-align: left;
    padding: 0.85rem 0.5rem;
    background: #fafafa;
    color: #2b2b2b;
    font-weight: 600;
    border-bottom: 1px solid #ddd;
    font-size: 0.75rem;
}

.user-table td {
    padding: 0.8rem 0.5rem;
    border-bottom: 1px solid #efefef;
    color: #2c2c2c;
    vertical-align: middle;
}

.user-table tr:hover {
    background: #f9f9f9;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.btn-update {
    background: transparent;
    border: 1px solid #aaa;
    padding: 0.3rem 0.8rem;
    border-radius: 30px;
    font-size: 0.7rem;
    cursor: pointer;
    transition: 0.2s;
}

.btn-update:hover {
    background: #eaeaea;
}

.btn-danger {
    background: transparent;
    border: 1px solid #bcbcbc;
    color: #3a3a3a;
    padding: 0.3rem 0.8rem;
    border-radius: 30px;
    font-size: 0.7rem;
    font-weight: 500;
    cursor: pointer;
    transition: 0.2s;
}

.btn-danger:hover {
    background: #f1f1f1;
    border-color: #888;
    color: #000;
}

.empty-row td {
    text-align: center;
    padding: 2rem;
    color: #8f8f8f;
    font-style: italic;
}

footer {
    text-align: center;
    font-size: 0.7rem;
    padding: 1rem;
    color: #7c7c7c;
    border-top: 1px solid #ececec;
    background: white;
}

/* Modal styles - mobile first */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(4px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    padding: 1rem;
}

.modal-container {
    background: #ffffff;
    width: 100%;
    max-width: 500px;
    border-radius: 28px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    overflow: hidden;
}

.modal-header {
    background: #111111;
    padding: 1rem 1.5rem;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    font-weight: 500;
    font-size: 1.1rem;
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.6rem;
    cursor: pointer;
    color: #ccc;
    transition: 0.2s;
    line-height: 1;
}

.modal-close:hover {
    color: white;
}

.modal-body {
    padding: 1.5rem;
    background: #ffffff;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    font-weight: 500;
    margin-bottom: 0.3rem;
    color: #1e1e1e;
    font-size: 0.8rem;
}

.form-group input {
    width: 100%;
    padding: 0.7rem 1rem;
    border: 1px solid #cfcfcf;
    border-radius: 20px;
    background: white;
    transition: 0.2s;
    font-size: 0.85rem;
}

.form-group input:focus {
    outline: none;
    border-color: #666;
    box-shadow: 0 0 0 2px rgba(0,0,0,0.05);
}

.modal-footer {
    padding: 0.5rem 1.5rem 1.5rem 1.5rem;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    background: #ffffff;
}

.btn-submit {
    background: #111;
    color: white;
    border: none;
    padding: 0.6rem 1.4rem;
    border-radius: 40px;
    font-weight: 500;
    cursor: pointer;
    font-size: 0.85rem;
}

.btn-cancel {
    background: #eaeaea;
    border: none;
    padding: 0.6rem 1.2rem;
    border-radius: 40px;
    cursor: pointer;
    font-size: 0.85rem;
}

/* ===== DESKTOP STYLES (media query for larger screens) ===== */
@media (min-width: 1024px) {
    #wrapper2 {
        padding: 2rem 1rem;
        position: relative;
    }

    /* Show left sidebar on desktop */
    .desktop-only {
        display: flex;
    }

    #left-side {
        background: #1a1a1a;
        width: 260px;
        height: auto;
        min-height: 400px;
        position: fixed;
        left: 0;
        top: 88px;
        bottom: 2rem;
        border-radius: 0 20px 20px 0;
        box-shadow: 4px 0 12px rgba(0,0,0,0.05);
        border-right: 1px solid #2e2e2e;
        flex-direction: column;
        padding: 2rem 1.2rem;
        gap: 2rem;
    }

    #left-side h5 {
        color: #f0f0f0;
        font-weight: 500;
        letter-spacing: 0.3px;
        border-left: 3px solid #aaaaaa;
        padding-left: 1rem;
        font-size: 0.9rem;
    }

    .side-stats {
        background: #0f0f0f;
        border-radius: 18px;
        padding: 1rem;
        margin-top: 0.5rem;
    }

    .side-stats p {
        color: #cbcbcb;
        font-size: 0.8rem;
        margin: 0.5rem 0;
    }

    /* Main panel with margins for desktop */
    .main-panel {
        max-width: 1000px;
        width: 100%;
        margin: 0 auto;
        margin-left: 300px;
        margin-right: 0;
    }

    .panel-header h2 {
        font-size: 1.5rem;
    }

    .btn-primary {
        padding: 0.6rem 1.4rem;
        font-size: 0.85rem;
    }

    .total-users-card {
        margin: 1rem 1.5rem;
        padding: 1rem 1.5rem;
    }

    .total-label {
        font-size: 0.9rem;
    }

    .total-number {
        font-size: 2.2rem;
    }

    .user-table-wrapper {
        padding: 0 1.5rem 1.8rem 1.5rem;
    }

    .user-table {
        font-size: 0.85rem;
        min-width: auto;
    }

    .user-table th {
        padding: 1rem 0.75rem;
        font-size: 0.85rem;
    }

    .user-table td {
        padding: 0.8rem 0.75rem;
    }

    .action-buttons {
        flex-direction: row;
    }
}

/* Medium screens (tablet) */
@media (min-width: 768px) and (max-width: 1023px) {
    .main-panel {
        max-width: 90%;
        margin: 0 auto;
    }

    .total-users-card {
        margin: 1rem 1.5rem;
    }
}

/* Small screens adjustments */
@media (max-width: 480px) {
    .panel-header {
        flex-direction: column;
        align-items: stretch;
        text-align: center;
    }

    .btn-primary {
        width: 100%;
        text-align: center;
    }

    .action-buttons {
        flex-direction: column;
        gap: 0.3rem;
    }

    .btn-update, .btn-danger {
        width: 100%;
        text-align: center;
    }

    .modal-body {
        padding: 1.2rem;
    }

    .modal-footer {
        flex-direction: column;
    }

    .btn-submit, .btn-cancel {
        width: 100%;
        text-align: center;
    }
}
</style>
