<template>
    <div>
        <facebook-loading v-show="isLoading"></facebook-loading>
        <div class="row" v-show="!isLoading">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-body text-center">
                        <img :src="profile.image" alt="img" class="rounded-circle" width="100" height="100">
                        <h3 class="mt-2">{{ profile.name }}</h3>
                        <p class="text-muted"><span class="badge badge-info">{{ role.join(', ') }}</span></p>
                    </div>
                    <div class="card-footer">
                        <button @click="showUpdateImageModal" class="btn btn-primary">
                            <i class="c-icon align-middle cil-image mr-1"></i>
                            Ubah gambar
                        </button>
                        <button @click="showUpdatePasswordModal" class="btn btn-danger">
                            <i class="c-icon align-middle cil-lock-locked mr-1"></i>
                            Ubah kata sandi
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h3>Profil</h3>
                        <p class="text-muted">Terkadang data kita perlu diperbarui :v</p>
                        <form @submit.prevent="updateGeneralInformation"  @keydown="profile.onKeydown($event)">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control"
                                        v-model="profile.name"
                                        :class="{'is-invalid': profile.errors.has('name')}">
                                        <has-error :form="profile" field="name"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control"
                                        v-model="profile.email"
                                        :class="{'is-invalid': profile.errors.has('email')}">
                                        <has-error :form="profile" field="email"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label>No.Hp</label>
                                        <input type="text" class="form-control"
                                        v-model="profile.phone_number"
                                        :class="{'is-invalid': profile.errors.has('phone_number')}">
                                        <has-error :form="profile" field="phone_number"></has-error>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <textarea name="address" cols="30" rows="5" class="form-control"
                                        v-model="profile.address"
                                        :class="{'is-invalid': profile.errors.has('address')}"></textarea>
                                        <has-error :form="profile" field="address"></has-error>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="c-icon cil-save align-middle mr-1"></i>
                                    Ubah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- update image modal -->
        <div class="modal fade" id="updateImageModal" tabindex="-1" aria-labelledby="roleFormLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="roleFormLabel">Ubah gambar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="javascript:void(0);" @submit.prevent="submitImage">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Gambar baru</label>
                                <input type="file" name="image" ref="imageFile" @change="imageUpload($event.target)" class="form-control" required>
                            </div>
                            <div class="progress">
                            <!-- PROGRESS BAR DENGAN VALUE NYA KITA DAPATKAN DARI VARIABLE progressBar -->
                            <div class="progress-bar" role="progressbar"
                                :style="{width: progressBar + '%'}"
                                :aria-valuenow="progressBar"
                                aria-valuemin="0"
                                aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <i class="align-middle c-icon cil-x mr-1"></i>
                                Batal
                            </button>
                            <button :disabled="progressLoading" type="submit" class="btn btn-primary">
                                <i class="align-middle c-icon cil-image mr-1"></i>
                                Ubah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- update password modal -->
        <div class="modal fade" id="updatePasswordModal" tabindex="-1" aria-labelledby="roleFormLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="roleFormLabel">Ubah kata sandi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="javascript:void(0);" @submit.prevent="updatePassword">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Kata sandi baru</label>
                                <input type="password" class="form-control" v-model="password.password"
                                :class="{'is-invalid': password.errors.has('password')}">
                                <has-error :form="password" field="password"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Ulang kata sandi baru</label>
                                <input type="password" class="form-control" v-model="password.password_confirmation"
                                :class="{'is-invalid': password.errors.has('password_confirmation')}">
                                <has-error :form="password" field="password_confirmation"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <i class="align-middle c-icon cil-x mr-1"></i>
                                Batal
                            </button>
                            <button type="submit" class="btn btn-danger">
                                <i class="align-middle c-icon cil-lock-locked mr-1"></i>
                                Ubah
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
                profile: new Form({
                    name: '',
                    email: '',
                    phone_number: '',
                    address: '',
                    image: '',
                }),
                password: new Form({
                    password: '',
                    password_confirmation: ''
                }),
                role: [],
                assetUri: '/storage/',
                isLoading: false,
                progressBar: 0,
                image: '',
                progressLoading: false,
            };
        },
        methods:{
            fetchProfileData(){
                this.isLoading = true;
                this.$Progress.start();
                axios.get(`${RESTURIV1}/profile`)
                .then(res => {
                    this.isLoading = false;
                    this.$Progress.finish();
                    this.profile.fill(res.data);
                    this.role = res.data.role;
                    this.profile.image = this.assetUri + res.data.image;
                }).catch(err => {
                    this.$Progress.finish();
                });
            },
            updateGeneralInformation(){
                this.$Progress.start();
                this.profile.post(`${RESTURIV1}/profile/updategeneralinformations`)
                .then(() => {
                    this.$Progress.finish();
                    this.$toasted.success('Profile berhasil diperbarui');
                    Fire.$emit('ProfileChange');
                })
                .catch(err => {
                    this.$Progress.finish();
                    this.$toasted.error(err);
                });
            },
            showUpdateImageModal(){
                $('#updateImageModal').modal('show');
            },
            //MENYIMPAN DATA FILE YANG AKAN DI-UPLOAD
            imageUpload(event) {
                this.image = event.files[0]
            },
            //MENGIRIM FILE UNTUK DI-UPLOAD
            submitImage() {
                this.$Progress.start();
                this.progressLoading = true
                let formData = new FormData();
                formData.append('image', this.image);

                axios.post(`${RESTURIV1}/profile/updateimage`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    //FUNGSI INI YANG MEMILIKI PERAN UNTUK MENGUBAH SEBERAPA JAUH PROGRESS UPLOAD FILE BERJALAN
                    onUploadProgress: function( progressEvent ) {
                        //DATA TERSEBUT AKAN DI ASSIGN KE VARIABLE progressBar
                        this.progressBar = parseInt(Math.round((progressEvent.loaded * 100) / progressEvent.total))
                    }.bind(this)
                })
                .then(() => {
                    this.$Progress.finish();
                    setTimeout(() => {
                        this.progressLoading = false;
                        this.reset();
                    });
                    Fire.$emit('ProfileChange');
                    this.$toasted.success('Gambar berhasil diperbarui');
                    this.image = '';
                    $('#updateImageModal').modal('hide');
                });
            },
            //RESET FORM UPLOAD
            reset() {
                this.$refs.imageFile.value = null;
            },
            showUpdatePasswordModal(){
                this.password.clear();
                this.password.reset();
                $('#updatePasswordModal').modal('show');
            },
            updatePassword(){
                this.$Progress.start();
                this.password.post(`${RESTURIV1}/profile/updatepassword`)
                .then(() => {
                    this.$toasted.success('Kata sandi berhasil diperbarui');
                    this.$Progress.finish();
                $('#updatePasswordModal').modal('hide');
                }).catch(err => {
                    this.$Progress.finish();
                    this.$toasted.error(err);
                });
            },
        },
        mounted() {
            const data = {
                title: "Profil"
            }
            Fire.$emit('PageChange', data);
        },
        created(){
            this.fetchProfileData();
            Fire.$on('ProfileChange', () => {
                this.fetchProfileData();
            });
        }
    }
</script>
