<template>
<div>
    <div class="card">
        <div class="card-body">
            <div class="text-right">
                <button type="button" @click="showBulkDestroyPermissionModal" class="btn btn-danger" v-if="deletePermissions.length > 0">
                    <i class="c-icon cil-trash align-middle mr-2"></i>Hapus yang dipilih
                </button>
                <button type="button" disabled class="btn btn-danger" v-else>
                    <i class="c-icon cil-trash align-middle mr-2"></i>Hapus yang dipilih
                </button>
                <button class="btn btn-primary" @click="showCreatePermissionModal">
                    <i class="c-icon mr-2 cil-plus align-middle"></i>
                    Tambah Permission
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
                        <tr v-for="permission in permissions.data" :key="permission.id">
                            <td><input type="checkbox" v-model="deletePermissions" :value="`${permission.id}`" /></td>
                            <td>{{ permission.name }}</td>
                            <td>{{ permission.guard_name }}</td>
                            <td>{{ permission.created_at | formatDate }}</td>
                            <td>
                                <button @click="showEditPermissionModal(permission)" class="btn btn-warning btn-sm">
                                    <i class="c-icon cil-pencil mr-1 align-middle"></i>
                                    edit
                                </button>
                                <button @click="showDestroyPermissionModal(permission)" class="btn btn-danger btn-sm">
                                    <i class="c-icon cil-trash mr-1 align-middle"></i>
                                    hapus
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <pagination align="right" :data="permissions" @pagination-change-page="getPermissions">
                <span slot="prev-nav">Prev</span>
                <span slot="next-nav">Next</span>
            </pagination>
        </div>
        <!-- Role form -->
        <div class="modal fade" id="permissionModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editMode">Tambah Permission Baru</h5>
                        <h5 class="modal-title" v-show="editMode">Ubah Permission</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? updatePermission() : storePermission()" @keydown="form.onKeydown($event)">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama permission</label>
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
        <div class="modal fade" id="destroyPermissionModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!bulkDeleteMode">Hapus Permission</h5>
                        <h5 class="modal-title" v-show="bulkDeleteMode">Hapus Masal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger">
                            Hapus Permission ini?. Pengguna dengan permission ini mungkin tidak akan memiliki akses lagi keresource.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="align-middle c-icon cil-x mr-1"></i>
                            Batal
                        </button>
                        <button type="button" class="btn btn-danger" @click="destroyPermission" v-show="!bulkDeleteMode">
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
                permissions: {},
                keywords: null,
                count: 5,
                deletePermissions: [],
                allSelect: false,
                bulkDeleteMode: false,
                isLoading: false,
            }
        },
        watch: {
            keywords(after, before) {
                this.getPermissions();
            },
            count(after, before) {
                this.getPermissions();
            }
        },
        methods: {
            getPermissions(page = 1) {
                this.isLoading = true;
                this.$Progress.start();
                axios.get(`${RESTURIV1}/permissions?page=${page}`, {
                        params: {
                            keywords: this.keywords,
                            count: this.count
                        }
                    })
                    .then(res => {
                        this.isLoading = false;
                        this.$Progress.finish();
                        this.permissions = res.data;
                    }).catch(err => {
                        this.isLoading = true;
                        this.$Progress.finish();
                    });
            },
            showCreatePermissionModal() {
                this.editMode = false;
                this.resetForm();
                $('#permissionModal').modal('show');
            },
            storePermission() {
                this.$Progress.start();
                this.form.post(`${RESTURIV1}/permissions`)
                    .then(() => {
                        this.$Progress.finish();
                        $('#permissionModal').modal('hide');
                        this.$toasted.success('Permission berhasil disimpan');
                        Fire.$emit('DataUpdated');
                    })
                    .catch(err => {
                        this.$Progress.finish();
                        this.$toasted.error(err);
                    });
            },
            showEditPermissionModal(permission) {
                this.editMode = true;
                this.resetForm();
                this.form.fill(permission);
                $('#permissionModal').modal('show');
            },
            updatePermission() {
                this.$Progress.start();
                this.form.put(`${RESTURIV1}/permissions/${this.form.id}`)
                    .then(() => {
                        this.$Progress.finish();
                        $('#permissionModal').modal('hide');
                        this.$toasted.success('Permission berhasil diubah');
                        Fire.$emit('DataUpdated');
                    })
                    .catch(err => {
                        this.$Progress.finish();
                        this.$toasted.error(err);
                    });
            },
            showDestroyPermissionModal(permission) {
                this.bulkDeleteMode = false;
                $('#destroyPermissionModal').modal('show');
                this.form.fill(permission);
            },
            destroyPermission() {
                this.$Progress.finish();
                axios.delete(`${RESTURIV1}/permissions/${this.form.id}`)
                    .then(() => {
                        this.$Progress.finish();
                        this.resetForm();
                        $('#destroyPermissionModal').modal('hide');
                        this.$toasted.success('Permission berhasil dihapus');
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
                    this.permissions.data.forEach(permission => {
                        this.deletePermissions.push(permission.id);
                    });
                } else {
                    this.allSelect = false;
                    this.deletePermissions = [];
                }
            },
            showBulkDestroyPermissionModal() {
                this.bulkDeleteMode = true;
                $('#destroyPermissionModal').modal('show');
            },
            bulkDestroy() {
                this.$Progress.start();
                const data = {
                    'id': this.deletePermissions
                }
                axios.post(`${RESTURIV1}/permissions/bulkdelete`, data)
                    .then(res => {
                        this.$Progress.finish();
                        Fire.$emit('DataUpdated');
                        $('#destroyPermissionModal').modal('hide');
                        this.$toasted.success('Permission berhasil dihapus');
                        this.deletePermissions = [];
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
                title: "Permissions"
            }
            Fire.$emit('PageChange', data);
        },
        created() {
            this.getPermissions();
            Fire.$on('DataUpdated', () => {
                this.getPermissions();
            });
        }
    }
</script>
