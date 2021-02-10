<template>
    <div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h3>Role</h3>
                        <div class="form-group">
                            <label>Pilih role</label>
                            <select v-model="selectedRole" class="form-control">
                                <option v-for="role in roles.data" :key="role.id" :value="role.id">{{ role.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h3>Permission</h3>
                        <p class="text-muted">Ubah permission dari role yang dipilih</p>
                        <div class="row" v-if="$can('assignpermission.ubah')">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <v-select v-model="selectedPermission" :options="permissionOptions"></v-select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group" v-show="selectedPermission !== ''">
                                    <button class="btn btn-primary" @click="assignPermission">
                                        <i class="c-icon cil-lock-locked mr-1 align-middle"></i>
                                        Update permission
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3 mb-2" v-show="selectedRole !== ''">
                            <div class="col-lg-6">
                                <select style="width: 60px;" v-model="count">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                    <option value="999999999">all</option>
                                </select>
                            </div>
                            <div class="col-lg-6 d-flex justify-content-end">
                                <input style="width: 300px;" v-model="keywords" />
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table-loading v-show="isLoading" class="mt-1"></table-loading>
                            <table class="table table-hover table-bordered table-striped table-sm" v-show="!isLoading">
                                <thead>
                                    <th>ID.</th>
                                    <th>Resource name</th>
                                    <th v-if="$can('assignpermission.ubah')">Delete</th>
                                </thead>
                                <tbody>
                                    <tr v-for="permission in roleWithPermissions.data" :key="permission.id"
                                        v-show="selectedRole !== '' && roleWithPermissions.data.length > 0">
                                        <td>{{ permission.id }}</td>
                                        <td>{{ permission.name }}</td>
                                        <td v-if="$can('assignpermission.ubah')">
                                            <button class="btn btn-danger btn-sm"
                                                @click="revokePermission(permission.name)">
                                                <i class="c-icon cil-trash align-middle"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr v-show="selectedRole === ''">
                                        <td colspan="3" class="text-center text-muted"><i>Nothing to show</i></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <pagination align="right" :data="roleWithPermissions"
                            @pagination-change-page="getRoleAndPermission">
                            <span slot="prev-nav">Prev</span>
                            <span slot="next-nav">Next</span>
                        </pagination>
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
                roles: {},
                permissions: {},
                roleWithPermissions: {},
                permissionOptions: [],
                selectedRole: '',
                selectedPermission: '',
                keywords: null,
                count: 5,
                isLoading: false,
            }
        },
        methods: {
            getRoles() {
                this.$Progress.start();
                this.isLoading = true;
                axios.get(`${RESTURIV1}/assignpermission/roles`)
                    .then(res => {
                        this.$Progress.finish();
                        this.roles = res;
                        this.isLoading = false;
                    }).catch(() => {
                        this.$Progress.finish();
                        this.isLoading = true;
                    });
            },
            getPermission() {
                this.$Progress.start();
                this.isLoading = true;
                axios.get(`${RESTURIV1}/assignpermission/getpermission`)
                    .then(res => {
                        this.$Progress.finish();
                        this.permissions = res.data;
                        this.permissionOptions = [];
                        this.permissions.map(permission => {
                            this.permissionOptions.push(permission.name);
                        });
                        this.isLoading = false;
                    }).catch(() => {
                        this.$Progress.finish();
                        this.isLoading = true;
                    });
            },
            getRoleAndPermission(page = 1) {
                this.isLoading = true;
                this.$Progress.start();
                axios.get(`${RESTURIV1}/assignpermission/getroleandpermission/${this.selectedRole}?page=${page}`, {
                        params: {
                            keywords: this.keywords,
                            count: this.count
                        }
                    })
                    .then(res => {
                        this.$Progress.finish();
                        this.getPermission();
                        this.roleWithPermissions = res.data;
                        this.isLoading = false;
                    }).catch(() => {
                        this.$Progress.finish();
                        this.isLoading = true;
                    });
            },
            assignPermission() {
                this.$Progress.start();
                const data = {
                    'role_id': this.selectedRole,
                    'permission': this.selectedPermission,
                };
                axios.post(`${RESTURIV1}/assignpermission/assignpermission`, data).then(res => {
                    this.$Progress.finish();
                    this.$toasted.success('Hak akses berhasil disimpan');
                    this.getRoleAndPermission();
                    this.selectedPermission = "";
                }).catch(err => {
                    this.$Progress.finish();
                    this.$toasted.error(err);
                    this.getRoleAndPermission();
                });
            },
            revokePermission(permission) {
                this.$Progress.start();
                const data = {
                    'role_id': this.selectedRole,
                    'permission': permission,
                };
                axios.post(`${RESTURIV1}/assignpermission/revokepermission`, data)
                .then(res => {
                    this.$Progress.finish();
                    this.$toasted.success('Hak akses berhasil dicabut');
                    this.getRoleAndPermission();
                }).catch(err => {
                    this.$Progress.finish();
                    this.$toasted.error(err);
                    this.getRoleAndPermission();
                });
            }

        },
        watch: {
            selectedRole(after, before) {
                this.getRoleAndPermission()
            },
            keywords(after, before) {
                this.getRoleAndPermission();
            },
            count(after, before) {
                this.getRoleAndPermission();
            }
        },
        created() {
            this.getRoles();
        },
        mounted(){
            const data = {
                title: "Assign Permission"
            }
            Fire.$emit('PageChange', data)
        }
    }
</script>
