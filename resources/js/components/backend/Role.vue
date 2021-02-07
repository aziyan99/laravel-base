<template>
<div>
    <div class="card">
        <div class="card-body">
            <div class="text-right">
                <button type="button" @click="showBulkDestroyRoleForm" class="btn btn-danger" v-if="deleteRoles.length > 0">
                    <i class="c-icon cil-trash align-middle mr-2"></i>Hapus yang dipilih
                </button>
                <button type="button" disabled class="btn btn-danger" v-else>
                    <i class="c-icon cil-trash align-middle mr-2"></i>Hapus yang dipilih
                </button>
                <button class="btn btn-primary" @click="showCreateRoleFrom">
                    <i class="c-icon mr-2 cil-plus align-middle"></i>
                    Tambah Role
                </button>
            </div>
            <div class="row mt-3">
                <div class="col-lg-6">
                    <select style="width: 40px;" v-model="count">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                        <option value="999999999">all</option>
                    </select>
                </div>
                <div class="col-lg-6 text-right">
                    <input style="width: 300px;" v-model="keywords" />
                </div>
            </div>
            <table-loading class="mt-3" v-show="isLoading"></table-loading>
            <div class="table-responsive" v-show="!isLoading">
                <table class="table table-hover table-bordered table-sm mt-3">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" v-model="allSelect" @click="selectAll" />
                            </th>
                            <th>Nama</th>
                            <th>Guard name</th>
                            <th>Tanggal ditambahkan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="role in roles.data" :key="role.id">
                            <td><input type="checkbox" v-model="deleteRoles" :value="`${role.id}`" /></td>
                            <td>{{ role.name }}</td>
                            <td>{{ role.guard_name }}</td>
                            <td>{{ role.created_at | formatDate }}</td>
                            <td>
                                <button @click="showEditRoleForm(role)" class="btn btn-warning btn-sm">
                                    <i class="c-icon cil-pencil mr-1 align-middle"></i>
                                    edit
                                </button>
                                <button @click="showDestroyRoleForm(role)" class="btn btn-danger btn-sm">
                                    <i class="c-icon cil-trash mr-1 align-middle"></i>
                                    hapus
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <pagination align="right" :data="roles" @pagination-change-page="getRoles">
                <span slot="prev-nav">Prev</span>
                <span slot="next-nav">Next</span>
            </pagination>
        </div>
        <!-- Role form -->
        <div class="modal fade" id="roleForm" tabindex="-1" aria-labelledby="roleFormLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="roleFormLabel" v-show="!editMode">Tambah Role Baru</h5>
                        <h5 class="modal-title" id="roleFormLabel" v-show="editMode">Ubah Role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? updateRole() : storeRole()" @keydown="form.onKeydown($event)">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama role</label>
                                <input type="text" class="form-control" v-model="form.name"
                                    :class="{'is-invalid': form.errors.has('name')}">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Guard name</label>
                                <input type="text" class="form-control" v-model="form.guard_name"
                                    :class="{'is-invalid': form.errors.has('guard_name')}" readonly>
                                <has-error :form="form" field="guard_name"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <i class="align-middle c-icon cil-x mr-1"></i>
                                Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="align-middle c-icon cil-save mr-1"></i>
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Delete Role form -->
        <div class="modal fade" id="destroyRoleForm" tabindex="-1" aria-labelledby="roleFormLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="roleFormLabel" v-show="!bulkDeleteMode">Hapus Role</h5>
                        <h5 class="modal-title" id="roleFormLabel" v-show="bulkDeleteMode">Hapus Masal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger">
                            Hapus Role ini?. Pengguna dengan role ini mungkin tidak akan memiliki akses lagi kesistem.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="align-middle c-icon cil-x mr-1"></i>
                            Batal
                        </button>
                        <button type="button" class="btn btn-danger" @click="destroyRole" v-show="!bulkDeleteMode">
                            <i class="align-middle c-icon cil-trash mr-1"></i>
                            Hapus
                        </button>
                        <button type="button" class="btn btn-danger" @click="bulkDestroy" v-show="bulkDeleteMode">
                            <i class="align-middle c-icon cil-trash mr-1"></i>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
    export default {
        data() {
            return {
                form: new Form({
                    id: '',
                    name: '',
                    guard_name: 'web'
                }),
                editMode: false,
                roles: {},
                keywords: null,
                count: 5,
                deleteRoles: [],
                allSelect: false,
                bulkDeleteMode: false,
                isLoading: false,
            }
        },
        watch: {
            keywords(after, before) {
                this.getRoles();
            },
            count(after, before) {
                this.getRoles();
            }
        },
        methods: {
            getRoles(page = 1) {
                this.isLoading = true;
                this.$Progress.start();
                axios.get(`${RESTURIV1}/roles?page=${page}`, {
                        params: {
                            keywords: this.keywords,
                            count: this.count
                        }
                    })
                    .then(res => {
                        this.$Progress.finish();
                        this.isLoading = false;
                        this.roles = res.data;
                    }).catch(err => {
                        this.$Progress.finish();
                        this.isLoading = true;
                    });
            },
            showCreateRoleFrom() {
                this.editMode = false;
                this.resetForm();
                $('#roleForm').modal('show');
            },
            storeRole() {
                this.$Progress.start();
                this.form.post(`${RESTURIV1}/roles`)
                    .then(() => {
                        this.$Progress.finish();
                        $('#roleForm').modal('hide');
                        this.$toasted.success('Role berhasil disimpan');
                        Fire.$emit('DataUpdated');
                    })
                    .catch(err => {
                        this.$Progress.finish();
                        this.$toasted.error(err);
                    });
            },
            showEditRoleForm(role) {
                this.editMode = true;
                this.resetForm();
                this.form.fill(role);
                $('#roleForm').modal('show');
            },
            updateRole() {
                this.$Progress.start();
                this.form.put(`${RESTURIV1}/roles/${this.form.id}`)
                    .then(() => {
                        this.$Progress.finish();
                        $('#roleForm').modal('hide');
                        this.$toasted.success('Role berhasil diubah');
                        Fire.$emit('DataUpdated');
                    })
                    .catch(err => {
                        this.$Progress.finish();
                        this.$toasted.error(err);
                    });
            },
            showDestroyRoleForm(role) {
                this.bulkDeleteMode = false;
                $('#destroyRoleForm').modal('show');
                this.form.fill(role);
            },
            destroyRole() {
                this.$Progress.start();
                axios.delete(`${RESTURIV1}/roles/${this.form.id}`)
                    .then(() => {
                        this.$Progress.finish();
                        this.resetForm();
                        $('#destroyRoleForm').modal('hide');
                        this.$toasted.success('Role berhasil dihapus');
                        Fire.$emit('DataUpdated');
                    })
                    .catch(err => {
                        this.$Progress.finish();
                        this.$toasted.success(err);
                    });
            },
            selectAll() {
                if (this.allSelect == false) {
                    this.allSelect = true;
                    this.roles.data.forEach(role => {
                        this.deleteRoles.push(role.id);
                    });
                } else {
                    this.allSelect = false;
                    this.deleteRoles = [];
                }
            },
            showBulkDestroyRoleForm() {
                this.bulkDeleteMode = true;
                $('#destroyRoleForm').modal('show');
            },
            bulkDestroy() {
                this.$Progress.start();
                const data = {
                    'id': this.deleteRoles
                }
                axios.post(`${RESTURIV1}/roles/bulkdelete`, data)
                    .then(res => {
                        this.$Progress.finish();
                        Fire.$emit('DataUpdated');
                        $('#destroyRoleForm').modal('hide');
                        this.$toasted.success('Role berhasil dihapus');
                        this.deleteRoles = [];
                        this.allSelect = false;
                    }).catch(err => {
                        this.$Progress.finish();
                        this.$toasted.error(err);
                    });
            },
            resetForm() {
                this.form.reset();
                this.form.clear();
            }
        },
        mounted() {
            const data = {
                title: "Role"
            }
            Fire.$emit('PageChange', data);
        },
        created() {
            this.getRoles();
            Fire.$on('DataUpdated', () => {
                this.getRoles();
            });
        }
    }
</script>
