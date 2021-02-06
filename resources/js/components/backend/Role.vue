<template>
    <div class="card">
        <div class="card-body">
            <div class="text-right">
                <button class="btn btn-danger">
                    <i class="c-icon mr-2 cil-trash align-middle"></i>
                    Hapus
                </button>
                <button class="btn btn-primary" @click="showCreateRoleFrom">
                    <i class="c-icon mr-2 cil-plus align-middle"></i>
                    Tambah Role
                </button>
            </div>
            <div class="row mt-3">
                <div class="col-lg-6">
                    <select name="" id="">
                        <option value="">5</option>
                        <option value="">10</option>
                        <option value="">20</option>
                        <option value="">50</option>
                        <option value="">all</option>
                    </select>
                </div>
                <div class="col-lg-6 text-right">
                    <input type="text" >
                </div>
            </div>
            <table class="table table-hover table-bordered mt-3">
                <thead>
                    <tr>
                        <th><input type="checkbox" /></th>
                        <th>Nama</th>
                        <th>Guard name</th>
                        <th>Tanggal ditambahkan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="checkbox" /></td>
                        <td>super admin</td>
                        <td>web</td>
                        <td>12 hours ago</td>
                        <td>
                            <button class="btn btn-warning btn-sm">
                                <i class="c-icon cil-pencil mr-1 align-middle"></i>
                                edit
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="c-icon cil-trash mr-1 align-middle"></i>
                                hapus
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Role form -->
        <div class="modal fade" id="roleForm" tabindex="-1" aria-labelledby="roleFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roleFormLabel">Tambah Role Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="storeRole" @keydown="form.onKeydown($event)">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama role</label>
                            <input type="text"
                            class="form-control"
                            v-model="form.name"
                            :class="{'is-invalid': form.errors.has('name')}">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Guard name</label>
                            <input type="text"
                            class="form-control"
                            v-model="form.guard_name"
                            :class="{'is-invalid': form.errors.has('name')}"
                            readonly>
                            <has-error :form="form" field="name"></has-error>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="align-middle c-icon cil-x mr-1"></i>
                            Batal
                        </button>
                        <button type="sibmit" class="btn btn-primary">
                        <i class="align-middle c-icon cil-save mr-1"></i>
                            Simpan
                        </button>
                    </div>
                </form>
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
            })
        }
    },
    methods:{
        showCreateRoleFrom(){
            $('#roleForm').modal('show');
        },
        storeRole(){
            //
        }
    },
    mounted() {
        const data = {
            title: "Role"
        }
        Fire.$emit('PageChange', data)
    }
}
</script>
