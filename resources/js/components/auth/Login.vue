<template>
    <div class="card-group">
        <div class="card p-4">
            <div class="card-body">
                <h1>Masuk</h1>
                <p class="text-muted">Masuk untuk mengakses sistem</p>
                <form @submit.prevent="authenticate" @keydown="form.onKeydown($event)">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="c-icon cil-envelope-closed"></i>
                            </span>
                        </div>
                        <input class="form-control" type="email" placeholder="Email" autocomplete="off"
                            v-model="form.email" :class="{'is-invalid': form.errors.has('email')}">
                        <has-error :form="form" field="email"></has-error>
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="c-icon cil-lock-locked"></i>
                            </span>
                        </div>
                        <input class="form-control" type="password" autocomplete="off" placeholder="Kata Sandi"
                            v-model="form.password" :class="{'is-invalid': form.errors.has('password')}">
                        <has-error :form="form" field="password"></has-error>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <button class="btn btn-primary px-4" type="submit" :disabled="form.busy">Masuk</button>
                        </div>
                        <div class="col-6 text-right">
                            <button class="btn btn-link px-0" type="button">Lupa kata sandi?</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
            <div class="card-body text-center">
                <div>
                    <h2>Sign up</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                        incididunt ut labore et dolore magna aliqua.</p>
                    <button class="btn btn-lg btn-outline-light mt-3" type="button">Register Now!</button>
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
                    email: '',
                    password: ''
                })
            }
        },
        methods: {
            authenticate() {
                this.$toasted.show("Mengotentikasi ...");
                axios.get('/sanctum/csrf-cookie')
                    .then(() => {
                        this.form.post('/api/v1/login')
                            .then(res => {
                                if (res.data.msg !== "Login successfull!") {
                                    this.$toasted.error("Email atau kata sandi salah!");
                                } else {
                                    this.$toasted.success("Login berhasil!");
                                    this.$toasted.show("Mengalihkan ...");
                                    this.form.reset();
                                    this.form.clear();
                                    setTimeout(function () {
                                        window.location.replace("/backoffice/profile");
                                    }, 1000);
                                }
                            })
                            .catch(err => {
                                this.$toasted.error(err);
                            });
                    })
                    .catch(err => {
                        this.$toasted.error(err);
                    });
            }
        },
        created() {
            //
        }
    }

</script>
